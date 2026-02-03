<?php

namespace App\Providers;

use App\Models\BackEnd\Pages;
use App\Models\BackEnd\Menu;
use App\Models\BackEnd\Banner;
use App\Models\BackEnd\App;
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

        View::composer('layouts.frontend.navbar', function ($view) {
            $pages = Pages::whereNull('parent_id')
                ->where('active', 1)
                ->orderBy('sort_order', 'asc')
                ->with('children')
                ->get();
    
            $view->with('pages', $pages);
        });

        View::composer('layouts.frontend.footer', function ($view) {
            $footerPages = Pages::where('type', 'Pages')
                ->where('active', 1)
                ->orderBy('sort_order', 'asc')
                ->limit(5)
                ->get();
    
            $view->with('footerPages', $footerPages);
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

        view()->composer('*', function ($view) {
            $setting = App::first();

            $view->with('appSetting', $setting);
        });
        
        View::composer('layouts.frontend', function ($view) {
            $banners = Banner::orderBy('urutan', 'asc')->get();

            $view->with('banners', $banners);
        });
    }
}
