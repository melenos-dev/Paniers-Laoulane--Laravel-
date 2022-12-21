<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
        $app->bind(
            'App\Management\LoadFileInterface', 
            'App\Management\LoadFile'
        );
        
        $app->bind(
            'App\Management\UserManagement'
        );

        /**

         * Paginate a standard Laravel Collection.

         *
         * 
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */

        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {

            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [

                    'path' => LengthAwarePaginator::resolveCurrentPath(),

                    'pageName' => $pageName,

                ]
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setlocale(config('app.locale'));
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            // For hyphens use: /^[\pL\s-]+$/u.
            return preg_match('/^[\pL\s-]+$/u', $value); 

        });

        Validator::extend('phone', function ($attribute, $value) {
            return preg_match('/^([0-9\s\-\+\(\)]*)$/', $value); 
        });   
    }
}
