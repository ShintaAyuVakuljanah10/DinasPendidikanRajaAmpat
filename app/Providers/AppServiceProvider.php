<?php

namespace App\Providers;

use App\Models\BackEnd\Pages;
use App\Models\BackEnd\Menu;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('layouts.frontend', function ($view) {
            $pages = Pages::whereNull('parent_id')
                ->where('active', 1)
                ->orderBy('sort_order')
                ->with('children')
                ->get();
    
            $view->with('pages', $pages);
        });

        view()->composer('layouts.backend', function ($view) {
            $menus = Menu::where('active', 1)
                ->orderBy('sort_order')
                ->with(['submenus' => function ($q) {
                    $q->where('active', 1)->orderBy('sort_order');
                }])
                ->get();
    
            $view->with('menus', $menus);
        });
    }
}
