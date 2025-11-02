<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::with(['user', 'category', 'tags']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tags', function ($tagQuery) use ($search) {
                        $tagQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Sorting functionality
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // Validate sort fields
        $allowedSortFields = ['title', 'created_at', 'is_active', 'is_pinned', 'views'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'created_at';
        }

        // Handle relation sorting
        if ($sortField === 'user') {
            $query->join('users', 'articles.user_id', '=', 'users.id')
                ->orderBy('users.name', $sortDirection)
                ->select('articles.*');
        } elseif ($sortField === 'category') {
            $query->join('categories', 'articles.category_id', '=', 'categories.id')
                ->orderBy('categories.name', $sortDirection)
                ->select('articles.*');
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $articles = $query->paginate($perPage);

        // Append query parameters to pagination links
        $articles->appends($request->query());

        $data = [
            'articles' => $articles,
            'search' => $request->search,
            'sort' => $sortField,
            'direction' => $sortDirection,
            'per_page' => $perPage
        ];

        return view('pages.articles.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();

        $data = [
            'categories' => Category::all(),
            'tags' => $tags,
        ];

        return view('pages.articles.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'category_id' => ['required', 'exists:categories,id'],
                'tags' => ['nullable', 'array'],
                'tags.*' => ['exists:tags,name'],
                'title' => ['required', 'string', 'max:255'],
                'content' => ['required', 'string'],
                'embed' => ['nullable', 'string'],
                'thumbnail' => ['nullable', 'image', 'max:5120'],
                'is_active' => ['required', 'boolean'],
                'is_pinned' => ['required', 'boolean'],
            ]);

            DB::beginTransaction();

            $data = $request->except(['thumbnail', 'tags', 'embed']);
            $data['user_id'] = Auth::id();
            $data['slug'] = Str::slug($request->title);

            $body = $request->content;
            $embedHtml = $request->filled('embed') ? $request->embed : '';

            if ($embedHtml) {
                $combined = '<div class="article-wrapper">'
                    . '<div class="article-body">' . $body . '</div>'
                    . '<div class="article-embed">' . $embedHtml . '</div>'
                    . '</div>';
            } else {
                $combined = '<div class="article-wrapper">'
                    . '<div class="article-body">' . $body . '</div>'
                    . '</div>';
            }

            $data['content'] = $combined;

            if ($request->hasFile('thumbnail')) {
                $disk = config('filesystems.default');
                $path = Storage::disk($disk)->put('thumbnails', $request->file('thumbnail'));
                $data['thumbnail'] = $path;
            }

            $article = Article::create($data);

            if ($request->filled('tags')) {
                $tagIds = Tag::whereIn('name', $request->tags)->pluck('id')->toArray();
                $article->tags()->sync($tagIds);
            }

            DB::commit();

            return redirect()
                ->route('articles.index')
                ->with('success', 'Artikel berhasil dibuat.');
        } catch (ValidationException $e) {
            DB::rollBack();

            Log::error('Validation error creating article: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data yang diisi tidak valid. Silakan periksa kembali.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error creating article: ' . $th->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan artikel.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $data = [
            'article' => $article,
        ];

        return view('pages.articles.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $tags = Tag::all();

        $content = $article->content;
        $embed = '';

        if (preg_match('/<div[^>]*class=["\']article-embed["\'][^>]*>(.*?)<\/div>/is', $content, $m)) {
            $embed = $m[1];
            $content = preg_replace('/<div[^>]*class=["\']article-embed["\'][^>]*>.*?<\/div>/is', '', $content, 1);
        }

        if (preg_match('/<div[^>]*class=["\']article-body["\'][^>]*>(.*?)<\/div>/is', $content, $m2)) {
            $content = $m2[1];
        } else {
            if (preg_match('/<div[^>]*class=["\']article-wrapper["\'][^>]*>(.*?)<\/div>/is', $content, $m3)) {
                $content = $m3[1];
            }
        }

        $articleForEdit = clone $article;
        $articleForEdit->content = $content;
        $articleForEdit->embed = $embed;

        $data = [
            'article' => $articleForEdit,
            'categories' => Category::all(),
            'tags' => $tags,
        ];

        return view('pages.articles.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        try {
            $request->validate([
                'category_id' => ['required', 'exists:categories,id'],
                'tags' => ['nullable', 'array'],
                'tags.*' => ['exists:tags,name'],
                'title' => ['required', 'string', 'max:255'],
                'content' => ['required', 'string'],
                'embed' => ['nullable', 'string'],
                'thumbnail' => ['nullable', 'image', 'max:5120'],
                'is_active' => ['required', 'boolean'],
                'is_pinned' => ['required', 'boolean'],
            ]);

            DB::beginTransaction();

            $data = $request->except(['thumbnail', 'tags', 'remove_thumbnail', 'embed']);

            $data['slug'] = Str::slug($request->title);

            $body = $request->content;
            $embedHtml = $request->filled('embed') ? $request->embed : '';

            if ($embedHtml) {
                $combined = '<div class="article-wrapper">'
                    . '<div class="article-body">' . $body . '</div>'
                    . '<div class="article-embed">' . $embedHtml . '</div>'
                    . '</div>';
            } else {
                $combined = '<div class="article-wrapper">'
                    . '<div class="article-body">' . $body . '</div>'
                    . '</div>';
            }

            $data['content'] = $combined;

            $disk = config('filesystems.default');

            if ($request->remove_thumbnail == '1') {
                if ($article->thumbnail) {
                    Storage::disk($disk)->delete($article->thumbnail);
                    $data['thumbnail'] = null;
                }
            } elseif ($request->hasFile('thumbnail')) {
                if ($article->thumbnail) {
                    Storage::disk($disk)->delete($article->thumbnail);
                }
                $data['thumbnail'] = Storage::disk($disk)->put('thumbnails', $request->file('thumbnail'));
            }

            $article->update($data);

            if ($request->filled('tags')) {
                $tagIds = Tag::whereIn('name', $request->tags)->pluck('id')->toArray();
                $article->tags()->sync($tagIds);
            }

            DB::commit();

            return redirect()
                ->route('articles.index')
                ->with('success', 'Artikel berhasil diperbaharui.');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data yang diisi tidak valid. Silakan periksa kembali.');
        } catch (Throwable $th) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbaharui artikel.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if ($article->thumbnail) {
            $disk = config('filesystems.default');
            Storage::disk($disk)->delete($article->thumbnail);
        }

        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Artikel berhasil diperbaharui.');
    }

    /**
     * Handle CKEditor image upload
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'upload' => 'required|image|max:5120',
            ]);

            $disk = config('filesystems.default');
            $path = Storage::put('contents', $request->file('upload'));

            if ($disk === 'public') {
                $url = asset('storage/' . $path);
            } else {
                $url = route('files', ['path' => $path]);
            }

            return response()->json([
                'url' => $url
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation error uploading image to CKEditor: ' . $e->getMessage());

            return response()->json([
                'error' => [
                    'message' => 'File yang diupload harus berupa gambar dengan ukuran maksimal 5MB.'
                ]
            ], 400);
        } catch (Throwable $th) {
            Log::error('Error uploading image to CKEditor: ' . $th->getMessage());

            return response()->json([
                'error' => [
                    'message' => 'Terjadi kesalahan saat mengupload gambar.'
                ]
            ], 500);
        }
    }
}
