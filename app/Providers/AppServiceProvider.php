<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\Chat;
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
        $targetRoutes = ['dashboard', 'menus.*', 'profile', 'profile.*', 'users.*', 'categories.*', 'tags.*', 'articles.*', 'platforms.*', 'embeds.*', 'sliders.*', 'permissions.*', 'roles.*', 'permission-role.*'];

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
                $chats = Chat::latest()->take(10)->get();
                $view->with('notifications', $notifications)->with('chats', $chats);
            }
        });
    }
}
