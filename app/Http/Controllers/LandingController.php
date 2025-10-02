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
        ];

        return view('pages.landing.index', compact('data'));
    }
}
