<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Services\StorageManagerService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Storage manager singleton registration
        $this->app->singleton(StorageManagerService::class,function (){
            return new StorageManagerService();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share the authenticated user globally in views
        View::composer('*', function ($view) {
            $view->with('logged_in_user', Auth::user());
        });
        Paginator::useBootstrap();
    }
}
