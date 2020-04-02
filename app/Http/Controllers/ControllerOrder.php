<?php

namespace App\Http\Controllers;
use App\Category;
use App\Client;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
class ControllerOrder extends Controller
{
    private $glass_id=null;
    public function index(Request $request)
    {
//
        // $orders = Order::whereHas('clients',function ($q) use ( $request){
        //     return $q->where('name','like','%'.$request->search.'%');
        // })->paginate(5);
        $orders = Order::orderBy('created_at', 'DESC')->get();
      
        return view('adminlte.dashboardview.Orders.index',compact('orders'));
    }
    public function create(Client $client ,Order $order)
    {

        $orders = $client->orders()->paginate(5);
        $categories = Category::all();
        return view('adminlte.dashboardview.Clients.Orders.create',compact('client','categories','orders'));

    }
    public function store(Request $request,Client $client,$flag=0)
    {   
        
        
       $request->validate([
        'product_ids'=>'required|array',
        'quantity'=>'required|array',
        'glass_ids'=>'required|array',
        'sale_price'=>'required|array',
        'volume'=>'required|array',
        'discount'=>'required|array',
        'paid'=>'required|array',
       

       ]);
       $this->attach_order($request,$client);
            
       return redirect()->back()->with('Success', 'تمت الاضافة بنجاح');  
        
        
    }
    public function order_products(Order $order){

        $products = $order->products;
        return response()->json(['products'=>$products,'order'=>$order]);
    }
    public function edit(Client $client,Order $order)
    {
        $total_paid = 0;
        $total_debt = 0;
        $categories = Category::all();
        foreach($order->products as $product){
            // $total_debt +=$product->pivot->paid;
        }
        return view('adminlte.dashboardview.Clients.Orders.edit',compact('client','order','categories','total_debt'));

    }
    public function update(Request $request,Order $order,Client $client)
    {
        
       
        $this->destroyForUpdate($order);
       
        $this->attach_order( $request, $client);
        return redirect()->route('dashboard.orders.index')->with('Success', 'تم التعديل بنجاح'); 


      
    }

    public function destroy(Order $order)
    {
        foreach ($order->products as $product){
            $glass = Product::find($product->pivot->glass_id);
            if($order->type_of_sale==0){
                $product->update([
                    'retail_stoke'=>$product->pivot->volume+$product->retail_stoke,
                 ]);
                 $glass->update([
                    'retail_stoke'=> $product->pivot->quantity+$glass->retail_stoke 
                ]);
               
            }else {
                $product->update([
                    'whole_stoke'=>$product->pivot->volume+$product->whole_stoke,
                 ]);
                 $glass->update([
                    'retail_stoke'=> $product->pivot->quantity+$glass->whole_stoke 
                ]);
            }
            

        }
        $order->products()->detach();

        $order->delete();
        return redirect()->route('dashboard.orders.index');

    }



    
    private function destroyForUpdate(Order $order)
    {
       
        foreach ($order->products as $product){
            $glass = Product::find($product->pivot->glass_id);
            if($order->type_of_sale==0){
                $product->update([
                    'retail_stoke'=>$product->pivot->volume+$product->retail_stoke,
                 ]);
                 $glass->update([
                    'retail_stoke'=> $product->pivot->quantity+$glass->retail_stoke 
                ]);
               
            }else {
                $product->update([
                    'whole_stoke'=>$product->pivot->volume+$product->whole_stoke,
                 ]);
                 $glass->update([
                    'retail_stoke'=> $product->pivot->quantity+$glass->whole_stoke 
                ]);
            }
            

        }



        $order->products()->detach();
       
        $order->delete();
        
    }
    public function attach_order($request,$client){
      
      
        // $total_paid= 0;
        $total_price= 0;
        // $remaining=0;
        $order= $client->orders()->create([]);//ر32
         foreach ($request->product_ids as $index=>$product_id){
             
            $product = Product::find($product_id);
            $stoke_perfume =$request->order =="retail"?$product->retail_stoke:$product->whole_stoke;
             if($request->volume[$index]<=$stoke_perfume){
                 $product_glass = Product::find($request->glass_ids[$index]);

                 $stoke_glass =$request->order =="retail"?$product_glass->retail_stoke:$product_glass->whole_stoke;
                     if($request->quantity[$index]<=$stoke_glass){
                         $debt=   $request->paid[$index]-(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index]);
                         $total_price+=(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index]);
                        //  $total_paid+=(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index])+$debt;
                        // $remaining+=$debt;
                        $store_Order_Product = new OrderProduct(); 
                        $store_Order_Product->order_id = $order->id;
                        $store_Order_Product->product_id = $product->id;
                        $store_Order_Product->client_id = $client->id;
                        $store_Order_Product->quantity = $request->quantity[$index];
                        $store_Order_Product->sale_price = $request->sale_price[$index];
                        $store_Order_Product->discount = $request->discount[$index];
                        $store_Order_Product->volume = $request->volume[$index];
                        $store_Order_Product->glass_id = $product_glass->id;
                        if($debt==0)
                        $store_Order_Product->isDelevery = true;
                        $store_Order_Product->save();
                        // $order->products()->attach($product_id,
                        //  ['quantity'=>$request->quantity[$index],
                        //  'sale_price'=>$request->sale_price[$index],
                        //  'discount'=>$request->discount[$index],
                        
                        //  'volume'=>$request->volume[$index],
                        //  'glass_id'=>$product_glass->id,
                        //  'client_id'=>$client->id,
                        //  'created_at'=>date("Y-m-d h:i:sa"),
                        //  ]);
                         $payment = new Payment();
                         $payment->paid = $debt;
                         $payment->save();
                         $store_Order_Product->payments()->save($payment);
                         $type_of_sale = 0;
                         if($request->order =="retail"){
                             $product->retail_stoke =  $product->retail_stoke - $request->volume[$index];
                             $product_glass->update([
                                 'retail_stoke'=>$product_glass->retail_stoke - $request->quantity[$index]
                             ]);
                         }else {
                             $product->whole_stoke =  $product->whole_stoke - $request->volume[$index];
                             $type_of_sale = 1;
                             $product_glass->update([
                                 'whole_stoke'=>$product_glass->whole_stoke - $request->quantity[$index]
                             ]);
                         }
                         $product->save();
 
                         
                        //  $order->total_price=$total_price;
                         $order->total_price=$total_price;
                        //  $order->remaining=$remaining;
                         $order->type_of_sale=$type_of_sale;
                         $order->save();
                       
                        
                     }else{
                         $order->delete();
                         return redirect()->back()->withErrors(['error'=>__('الزجاج لا يكفي للكمية المطلوبة')]);
         
                     }
                        
             }else{
                 $order->delete();
                 return redirect()->back()->withErrors(['error'=>__('كمية الزيت المطلوبة أكبر من الكمية الموجودة')]);
 
             }
 
             
           
         }
      
         
    }
    public function show_sales(){
        return Datatables::of(OrderProduct::query())
        
        ->setRowId('tr_{{$id}}') 
        ->setRowClass(function($product) {
                return $product->isDelevery?'alert-success':'alert-warning';
            })
       
        
        ->editColumn('client_id',function($product) {
            return $product->client->name;
        
        })
        ->editColumn('product_id',function($product) {
            return $product->product->name;
        
        })
        ->editColumn('glass_id',function($product) {
             $glass = Product::find($product->glass_id);
             return $glass->name;
        
        })
        ->addColumn('total_price',function($product) {
            return (($product->quantity*$product->sale_price)-$product->discount)
            ;
        
        })
        ->addColumn('total_paid',function($product) {
            return (($product->quantity*$product->sale_price)-$product->discount)+ $product->payments()->sum('paid');
        
        })
        ->addColumn('debt',function($product) {
            return $product->payments()->sum('paid');
        
        })
        ->toJson();
    }
    public function show_sales_view(){
        return view('adminlte.dashboardview.Orders.show_sales');

    }
}
