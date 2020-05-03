<?php

namespace App\Http\Controllers;

use App\SellerOrder;
use Illuminate\Http\Request;
use App\Client;
use App\Product;
use App\Payment;
use App\OrderProduct;
use App\Category;
use App\Expense;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $seller_orders = SellerOrder::all()->count();
        $products_count = Product::all()->count();
        $clients_count = Client::all()->count();
        $Debtors=[];
        $categories_count = Category::all()->count();
        $sales = DB::table('orders')
                     ->select(DB::raw('YEAR(created_at) as year,MONTH(created_at) as month,SUM(total_price) as total'))
                     ->where('created_at','>','2020-00-00')
                     ->groupBy('month','year')->get();
        
       
        $Orders_Products = OrderProduct::where('isDelevery',0)->get();
        $client_ids= $Orders_Products->pluck('client_id')->toArray();
        $client_ids = array_unique($client_ids);
        foreach ($client_ids as $index=>$id){
            $Debtors[$index] = Client::find($id);
        }
        $sales_count = OrderProduct::all()->count();
        $best_sales = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->select('products.*')
        ->groupBy('products.id')
        ->orderBy('products.id','DESC')->get();  
        $expenses_count = Expense::all()->count();      

        return view('adminlte.dashboardview.test',compact('Debtors','best_sales','expenses_count','products_count','sales_count','clients_count','categories_count','sales','seller_orders'));
    }
}
