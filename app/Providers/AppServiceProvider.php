<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        // Share the authenticated user's role with all views
        // This is useful for displaying different content based on user roles
        // such as admin, editor, or viewer.
        View::composer('*', function ($view) {
            $user = Auth::user();
            $view->with('role', $user ? $user->role : null);
        });
    }
}
