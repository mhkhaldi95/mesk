<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Prخduct;
use Illuminate\Support\Facades\Request;

Route::get('/','HomeController@index')->name('welcome');
Route::get('/admin/change/lang/{lang}',['as'=>'lang','uses'=>'ControllerUser@change']);

Route::get('/helloTest', function (Request $request){
    return $request::server('HTTP_ACCEPT_LANGUAGE');
});


Auth::routes(['register'=>false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('dashboard/users')->name('dashboard.users.')->group(function (){
   Route::get('/index','ControllerUser@index')->name('index');
    Route::post('/destroy/{id?}','ControllerUser@destroy')->name('destroy');
    Route::post('/update/{id?}','ControllerUser@update')->name('update');
    Route::get('/edit/{id?}','ControllerUser@edit')->name('editview');
    Route::get('/Expenses_create','ControllerUser@Expenses_create')->name('Expenses_create');
    Route::get('/Expenses_view','ControllerUser@Expenses_view')->name('Expenses_view');
    Route::post('/Expenses_Store','ControllerUser@Expenses_Store')->name('Expenses_Store');

});
Route::prefix('dashboard/categories')->name('dashboard.categories.')->group(function (){
   Route::get('/index','ControllerCategory@index')->name('index');
//    Route::get('/users','ControllerCategory@users')->name('users');
    Route::post('/create','ControllerCategory@store')->name('create');//modal
    Route::post('/delete/{id?}','ControllerCategory@destroy')->name('destroy');
    Route::get('/edit/{category}','ControllerCategory@edit')->name('edit');
    Route::post('/update/{id?}','ControllerCategory@update')->name('update');
    Route::get('/createview','ControllerCategory@create')->name('createview');//view
});
// Route::get('/index/live_search','ControllerProduct@live_search_action')->name('live_search.action');

Route::prefix('dashboard/products')->name('dashboard.products.')->group(function (){
   Route::get('/index','ControllerProduct@index')->name('index');
   Route::get('/Best_selling_products','ControllerProduct@Best_selling_products')->name('Best_selling_products');

   Route::get('index/fetch_data','ControllerProduct@fetch_data');
    Route::get('/create','ControllerProduct@create')->name('create');//view
    Route::post('/store','ControllerProduct@store')->name('store');//modal
    Route::post('/delete/{product?}','ControllerProduct@destroy')->name('destroy');
    Route::get('/edit/{product?}','ControllerProduct@edit')->name('edit');
    Route::post('/update/{product?}','ControllerProduct@update')->name('update');
});

Route::get('/datatables/clients','ControllerClient@anyData')->name('datatables.clients');//view all clients
Route::get('/datatables/products','ControllerProduct@anyData')->name('datatables.products');//view all products
Route::get('/datatables/show_sales','ControllerOrder@show_sales')->name('datatables.show_sales');//view all products
Route::get('/Best_selling_products/getdata','ControllerProduct@Best_selling_products_getData')->name('datatables.Best_selling_products_getData');
Route::get('/Expense/getdata','ControllerUser@getExpense')->name('datatables.getExpense');
Route::get('/showProducts_order','ControllerOrder@showProducts_order')->name('datatables.showProducts_order');//in create order




Route::prefix('dashboard/clients')->name('dashboard.clients.')->group(function (){

   Route::get('/index','ControllerClient@index')->name('index');
    Route::get('/createview','ControllerClient@create')->name('create');//view
    Route::post('/store','ControllerClient@store')->name('store');//modal
    Route::post('/delete/{id?}','ControllerClient@destroy')->name('destroy');
    Route::get('/debts','ControllerClient@clients_debts')->name('debts');
    Route::get('/showSales/{client}','ControllerClient@showSales')->name('showSales');
    Route::get('/showPayments/{client}/{order}/{product}','ControllerClient@showPayments')->name('showPayments');
    Route::get('/showDebts/{client}','ControllerClient@showDebts')->name('showDebts');
    Route::get('/editDebts/{client}','ControllerClient@editDebts')->name('editDebts');//view

    Route::get('/edit/{client?}','ControllerClient@edit')->name('edit');
    Route::post('/update/{client?}','ControllerClient@update')->name('update');
});
Route::prefix('dashboard/clients/orders')->name('dashboard.clients.orders.')->group(function (){
    Route::get('/create/{client}','ControllerOrder@create')->name('create');//view
    Route::get('/create/fetch_data/{client}','ControllerOrder@fetch_data')->name('fetch_data');//oldorder
    Route::get('/edit/{client}/{order}','ControllerOrder@edit')->name('edit');//view
    Route::post('/update/{order}/{client}','ControllerOrder@update')->name('update');


    Route::post('/store/{client}','ControllerOrder@store')->name('store');
});
Route::prefix('dashboard/orders')->name('dashboard.orders.')->group(function (){
    Route::get('/index','ControllerOrder@index')->name('index');
    Route::get('/order_products/{order}','ControllerOrder@order_products')->name('order_products');
    Route::get('/create/{client}','ControllerOrder@create')->name('create');//view
    Route::post('/store/{client}','ControllerOrder@store')->name('store');
    Route::get('/delete/{order?}','ControllerOrder@destroy')->name('delete');
    Route::get('/edit/{client?}','ControllerClient@edit')->name('edit');
    Route::post('/update/{client?}','ControllerClient@update')->name('update');
    Route::get('/show_sales/view','ControllerOrder@show_sales_view')->name('show_sales_view');
});


