<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
            $messages = [
                'category_id.required' => 'Kategori wajib dipilih.',
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',
                'tags.array' => 'Tag harus berupa array.',
                'tags.*.exists' => 'Tag yang dipilih tidak valid.',
                'title.required' => 'Judul artikel wajib diisi.',
                'title.string' => 'Judul artikel harus berupa teks.',
                'title.max' => 'Judul artikel tidak boleh lebih dari :max karakter.',
                'content.required' => 'Konten artikel wajib diisi.',
                'content.string' => 'Konten artikel harus berupa teks.',
                'embed.string' => 'Embed harus berupa teks.',
                'thumbnail.image' => 'Thumbnail harus berupa gambar.',
                'thumbnail.max' => 'Ukuran thumbnail tidak boleh lebih dari :max KB.',
                'is_active.required' => 'Status aktif wajib dipilih.',
                'is_active.boolean' => 'Status aktif harus berupa boolean.',
                'is_pinned.required' => 'Status pin wajib dipilih.',
                'is_pinned.boolean' => 'Status pin harus berupa boolean.',
            ];

            $validator = Validator::make($request->all(), [
                'category_id' => ['required', 'exists:categories,id'],
                'tags' => ['nullable', 'array'],
                'tags.*' => ['exists:tags,name'],
                'title' => ['required', 'string', 'max:255'],
                'content' => ['required', 'string'],
                'embed' => ['nullable', 'string'],
                'thumbnail' => ['nullable', 'image', 'max:5120'],
                'is_active' => ['required', 'boolean'],
                'is_pinned' => ['required', 'boolean'],
            ], $messages);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', implode('<br>', $validator->errors()->all()));
            }

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
                $path = Storage::put('thumbnails', $request->file('thumbnail'));
                $data['thumbnail'] = $path;
            }

            $article = Article::create($data);

            if ($request->filled('tags')) {
                $tagIds = Tag::whereIn('name', $request->tags)->pluck('id')->toArray();
                $article->tags()->sync($tagIds);
            }

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Artikel Ditambahkan',
                'message' => 'Artikel ' . $article->title . ' berhasil ditambahkan oleh ' . (Auth::user()->name ?? 'System') . '.',
            ]);

            DB::commit();

            return redirect()
                ->route('articles.index')
                ->with('success', 'Artikel berhasil dibuat.');
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
            $messages = [
                'category_id.required' => 'Kategori wajib dipilih.',
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',
                'tags.array' => 'Tag harus berupa array.',
                'tags.*.exists' => 'Tag yang dipilih tidak valid.',
                'title.required' => 'Judul artikel wajib diisi.',
                'title.string' => 'Judul artikel harus berupa teks.',
                'title.max' => 'Judul artikel tidak boleh lebih dari :max karakter.',
                'content.required' => 'Konten artikel wajib diisi.',
                'content.string' => 'Konten artikel harus berupa teks.',
                'embed.string' => 'Embed harus berupa teks.',
                'thumbnail.image' => 'Thumbnail harus berupa gambar.',
                'thumbnail.max' => 'Ukuran thumbnail tidak boleh lebih dari :max KB.',
                'is_active.required' => 'Status aktif wajib dipilih.',
                'is_active.boolean' => 'Status aktif harus berupa boolean.',
                'is_pinned.required' => 'Status pin wajib dipilih.',
                'is_pinned.boolean' => 'Status pin harus berupa boolean.',
            ];

            $validator = Validator::make($request->all(), [
                'category_id' => ['required', 'exists:categories,id'],
                'tags' => ['nullable', 'array'],
                'tags.*' => ['exists:tags,name'],
                'title' => ['required', 'string', 'max:255'],
                'content' => ['required', 'string'],
                'embed' => ['nullable', 'string'],
                'thumbnail' => ['nullable', 'image', 'max:5120'],
                'is_active' => ['required', 'boolean'],
                'is_pinned' => ['required', 'boolean'],
            ], $messages);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', implode('<br>', $validator->errors()->all()));
            }

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

            if ($request->remove_thumbnail == '1') {
                if ($article->thumbnail) {
                    Storage::delete($article->thumbnail);
                    $data['thumbnail'] = null;
                }
            } elseif ($request->hasFile('thumbnail')) {
                if ($article->thumbnail) {
                    Storage::delete($article->thumbnail);
                }
                $data['thumbnail'] = Storage::put('thumbnails', $request->file('thumbnail'));
            }

            $article->update($data);

            if ($request->filled('tags')) {
                $tagIds = Tag::whereIn('name', $request->tags)->pluck('id')->toArray();
                $article->tags()->sync($tagIds);
            }

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Artikel Diperbaharui',
                'message' => 'Artikel ' . $article->title . ' berhasil diperbaharui oleh ' . (Auth::user()->name ?? 'System') . '.',
            ]);

            DB::commit();

            return redirect()
                ->route('articles.index')
                ->with('success', 'Artikel berhasil diperbaharui.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error updating article: ' . $th->getMessage());

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
        try {
            DB::beginTransaction();

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Artikel Dihapus',
                'message' => 'Artikel ' . $article->title . ' berhasil dihapus oleh ' . (Auth::user()->name ?? 'System') . '.',
            ]);

            $article->delete();

            DB::commit();

            return redirect()
                ->route('articles.index')
                ->with('success', 'Artikel berhasil dihapus.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error deleting article: ' . $th->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus artikel.');
        }
    }

    /**
     * Handle CKEditor image upload
     */
    public function uploadImage(Request $request)
    {
        try {
            $messages = [
                'upload.required' => 'File gambar wajib diupload.',
                'upload.image' => 'File yang diupload harus berupa gambar.',
                'upload.max' => 'Ukuran gambar tidak boleh lebih dari :max KB.',
            ];

            $validator = Validator::make($request->all(), [
                'upload' => 'required|image|max:5120',
            ], $messages);

            if ($validator->fails()) {
                return response()->json([
                    'error' => [
                        'message' => $validator->errors()->first()
                    ]
                ], 400);
            }

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
