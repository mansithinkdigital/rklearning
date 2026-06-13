<?php

namespace App\Providers;

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
        view()->composer(['admin.inc.sidebar', 'admin.pages.dashboard'], function ($view) {
            $view->with('reattemptRequestsCount', \App\Models\ExamResult::where('reattempt_status', 'requested')->count());
        });
    }
}
