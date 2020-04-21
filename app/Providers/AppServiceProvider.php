<?php

namespace App\Providers;

use App\Client;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $clientsDOB =Client::whereDate('BOD','=', now())->get();
        View::share('clientsDOB',$clientsDOB);
        Schema::defaultStringLength(191);
    }
}
