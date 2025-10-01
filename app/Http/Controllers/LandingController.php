<?php

namespace App\Http\Controllers;

use App\Models\Article;

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
            'resensi_buku' => Article::where('category_id', 4)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'review_film' => Article::where('category_id', 5)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'opini' => Article::where('category_id', 6)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'esai' => Article::where('category_id', 7)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'artikel' => Article::where('category_id', 8)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'puisi' => Article::where('category_id', 9)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'cerpen' => Article::where('category_id', 10)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
        ];

        return view('pages.landing.index', compact('data'));
    }
}
