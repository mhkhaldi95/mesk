<?php

namespace App\Providers;

use App\Client;
use App\Product;
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

        $products_whole_stoke = Product::where('whole_stoke','<=',500)->whereBetween('category_id', [1,3])->get();
         $products_retail_stoke = Product::where('retail_stoke','<=',200)->whereBetween('category_id', [1,3])->get();
        View::share('products_whole_stoke',$products_whole_stoke);
        View::share('products_retail_stoke',$products_retail_stoke);
        Schema::defaultStringLength(191);
    }
}
