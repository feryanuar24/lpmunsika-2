<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Embed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        $data = [
            'pinnedArticles' => Article::where('is_pinned', true)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'berita' => Article::where('category_id', 1)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'buletin' => Article::where('category_id', 2)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'resensi_buku' => Article::with('category')->where('category_id', 4)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'review_film' => Article::with('category')->where('category_id', 5)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'opini' => Article::with('category')->where('category_id', 6)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'esai' => Article::with('category')->where('category_id', 7)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'artikel' => Article::with('category')->where('category_id', 8)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'puisi' => Article::with('category')->where('category_id', 9)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'cerpen' => Article::with('category')->where('category_id', 10)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'gaya_mahasiswa' => Article::where('category_id', 11)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'youtube' => Embed::where('platform_id', 1)
                ->latest()
                ->limit(3)
                ->get(),
            'spotify' => Embed::where('platform_id', 2)
                ->latest()
                ->limit(3)
                ->get(),
        ];

        return view('pages.landing.index', compact('data'));
    }

    public function show($slug)
    {
        $article = Article::with(['user', 'category', 'tags', 'comments.user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $article->increment('views');

        $data = [
            'article' => $article,
            'relatedArticles' => Article::where('category_id', $article->category_id)
                ->where('is_active', true)
                ->where('id', '!=', $article->id)
                ->latest()
                ->limit(3)
                ->get(),
            'youtube' => Embed::where('platform_id', 1)
                ->latest()
                ->limit(3)
                ->get(),
            'spotify' => Embed::where('platform_id', 2)
                ->latest()
                ->limit(3)
                ->get(),
        ];

        return view('pages.landing.show', compact('data'));
    }

    public function like(Request $request)
    {
        $article = Article::where('slug', $request->slug)
            ->where('is_active', true)
            ->firstOrFail();

        $article->increment('likes');

        return redirect()->route('detail', $request->slug)->with('success', 'Terima kasih telah menyukai artikel ini!');
    }

    public function comment(Request $request)
    {
        $article = Article::where('slug', $request->slug)
            ->where('is_active', true)
            ->firstOrFail();

        $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $article->comments()->create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_active' => true,
        ]);

        return redirect()->route('detail', $request->slug)->with('success', 'Komentar Anda telah ditambahkan.');
    }
}
