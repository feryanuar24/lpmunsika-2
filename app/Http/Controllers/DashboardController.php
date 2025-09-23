<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            // Statistics Cards
            'stats' => [
                'total_users' => User::count(),
                'total_articles' => Article::count(),
                'published_articles' => Article::where('is_active', true)->count(),
                'total_views' => Article::sum('views'),
                'pinned_articles' => Article::where('is_pinned', true)->count(),
                'categories_count' => Category::count(),
                'tags_count' => Tag::count(),
            ],

            // Articles by Status
            'articles_by_status' => [
                'published' => Article::where('is_active', true)->count(),
                'draft' => Article::where('is_active', false)->count(),
            ],

            // Articles by Category (top 5)
            'articles_by_category' => Category::withCount('articles')
                ->orderBy('articles_count', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($category) {
                    return [
                        'name' => $category->name,
                        'count' => $category->articles_count
                    ];
                }),

            // User Registration Trend (last 12 months)
            'user_registration_trend' => User::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->map(function ($item) {
                    return [
                        'month' => Carbon::createFromFormat('Y-m', $item->month)->format('M Y'),
                        'count' => $item->count
                    ];
                }),

            // Article Publishing Trend (last 12 months)
            'article_publishing_trend' => Article::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->map(function ($item) {
                    return [
                        'month' => Carbon::createFromFormat('Y-m', $item->month)->format('M Y'),
                        'count' => $item->count
                    ];
                }),

            // Top Authors by Article Count
            'top_authors' => User::withCount('articles')
                ->orderBy('articles_count', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($user) {
                    return [
                        'name' => $user->name,
                        'count' => $user->articles_count
                    ];
                }),

            // Most Viewed Articles
            'most_viewed_articles' => Article::with(['user', 'category'])
                ->orderBy('views', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($article) {
                    return [
                        'title' => $article->title,
                        'views' => $article->views,
                        'author' => $article->user->name,
                        'category' => $article->category->name
                    ];
                }),

            // Recent Articles
            'recent_articles' => Article::with(['user', 'category'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),

            // Articles Views Distribution
            'views_distribution' => [
                'low' => Article::where('views', '<', 100)->count(),
                'medium' => Article::whereBetween('views', [100, 1000])->count(),
                'high' => Article::where('views', '>', 1000)->count(),
            ],
        ];

        return view('pages.dashboard.index', compact('data'));
    }
}
