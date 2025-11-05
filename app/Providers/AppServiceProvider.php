<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Notification;
use App\Models\Chat;
use App\Models\Embed;
use App\Models\Footer;
use App\Models\Platform;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $targetRoutes = [
            'dashboard',
            'menus',
            'profile',
            'profile.*',
            'users.*',
            'categories.*',
            'tags.*',
            'articles.*',
            'platforms.*',
            'embeds.*',
            'sliders.*',
            'footers.*',
            'permissions.*',
            'roles.*',
            'permission-role.*'
        ];

        View::composer('*', function ($view) use ($targetRoutes) {
            $route = Route::currentRouteName() ?? '';

            $matched = false;
            foreach ($targetRoutes as $pattern) {
                if (Str::is($pattern, $route)) {
                    $matched = true;
                    break;
                }
            }

            if ($matched) {
                $notifications = Notification::latest()->take(10)->get();
                $chats = Chat::latest()->take(10)->get()->sortBy('created_at')->values();
                $view
                    ->with('notifications', $notifications)
                    ->with('chats', $chats);
            }
        });

        // Share youtube and spotify embeds for landing pages
        $landingRoutes = [
            'landing',
            'tag',
            'detail',
            'category',
            'search'
        ];

        View::composer('*', function ($view) use ($landingRoutes) {
            $route = Route::currentRouteName() ?? '';

            $matched = false;
            foreach ($landingRoutes as $pattern) {
                if (Str::is($pattern, $route)) {
                    $matched = true;
                    break;
                }
            }

            if ($matched) {
                $youtube = Embed::where('platform_id', 1)->latest()->limit(3)->get();
                $spotify = Embed::where('platform_id', 2)->latest()->limit(3)->get();
                $categoies = Category::all();
                $tags = Tag::all();
                $footers = Footer::all();
                $platforms = Platform::all();
                $view
                    ->with('youtube', $youtube)
                    ->with('spotify', $spotify)
                    ->with('categories', $categoies)
                    ->with('tags', $tags)
                    ->with('footers', $footers)
                    ->with('platforms', $platforms);
            }
        });
    }
}
