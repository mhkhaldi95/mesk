<?php

namespace App\Http\Controllers;
use App\Category;
use App\Client;
use App\Order;
use App\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ControllerOrder extends Controller
{
    public function index(Request $request)
    {
//
        // $orders = Order::whereHas('clients',function ($q) use ( $request){
        //     return $q->where('name','like','%'.$request->search.'%');
        // })->paginate(5);
        $orders = Order::all();
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
        $test = DB::select("SELECT * FROM `products` WHERE name ='عروسة' ");

        $glass = Product::where('name', $request->glass_names[0])->first();
       
            if($flag==1)
            dd($glass);
        
       $request->validate([
        'product_ids'=>'required|array',
        'quantity'=>'required|array',
        'glass_names'=>'required|array',
        'sale_price'=>'required|array',
        'volume'=>'required|array',
        'discount'=>'required|array',
        'paid'=>'required|array',
       

       ]);
       $total_price= 0;
       $order= $client->orders()->create([]);//ر32
        foreach ($request->product_ids as $index=>$product_id){
            
            $product = Product::find($product_id);
            $glass = Product::where('name', $request->glass_names[$index])->first();
            $stoke_perfume =$request->order =="retail"?$product->retail_stoke:$product->whole_stoke;
            if($request->volume[$index]<=$stoke_perfume){
                $product_glass = Product::find($glass->id);
                $stoke_glass =$request->order =="retail"?$product_glass->retail_stoke:$product_glass->whole_stoke;
                    if($request->quantity[$index]<=$stoke_glass){
                        $debt=   $request->paid[$index]-(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index]);
                        $total_price+=(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index])+$debt;
                        $order->products()->attach($product_id,
                        ['quantity'=>$request->quantity[$index],
                        'sale_price'=>$request->sale_price[$index],
                        'discount'=>$request->discount[$index],
                        'paid'=>$debt,
                        'volume'=>$request->volume[$index],
                        'glass_id'=>$glass->id,
                        'client_id'=>$client->id,
                        'created_at'=>date("Y-m-d h:i:sa"),
                        ]);
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

                        $ord =  Order::find($order->id);
                        $ord->total_price=$total_price;
                        $ord->type_of_sale=$type_of_sale;
                        $ord->save();
                      
                       
                    }else{
                        $order->delete();
                        return redirect()->back()->withErrors(['error'=>__('الزجاج لا يكفي للكمية المطلوبة')]);
        
                    }
                       
            }else{
                $order->delete();
                return redirect()->back()->withErrors(['error'=>__('كمية الزيت المطلوبة أكبر من الكمية الموجودة')]);

            }

            
          
        }
        if($flag==0)
        return redirect()->back()->with('Success', 'تمت الاضافة بنجاح');  
        else  return redirect()->back()->with('Success', 'تم التعديل بنجاح');  
    }
    public function order_products(Order $order){

        $products = $order->products;
        return response()->json(['products'=>$products,'order'=>$order]);
    }
    public function edit(Client $client,Order $order)
    {
        
        $categories = Category::all();
        return view('adminlte.dashboardview.Clients.Orders.edit',compact('client','order','categories'));

    }
    public function update(Request $request,Order $order,Client $client)
    {
       $flag=1;
        $this->destroyForUpdate($order);
        $this->store( $request, $client,$flag);

      
    }

    public function destroy(Order $order)
    {
        foreach ($order->products as $product){
            if($order->type_of_sale==0){
                $product->update([
                    'retail_stoke'=>$product->pivot->quantity+$product->retail_stoke,
                 ]);
            }else {
                $product->update([
                    'whole_stoke'=>$product->pivot->quantity+$product->whole_stoke,
                 ]);
            }
            

        }
        $order->products()->detach();

        $order->delete();
        return redirect()->route('dashboard.orders.index');

    }


    public function storeForUpdate(Request $request,Client $client)
    {
       
        
       $request->validate([
        'product_ids'=>'required|array',
        'quantity'=>'required|array',
        'glass_names'=>'required|array',
        'sale_price'=>'required|array',
        'volume'=>'required|array',
        'discount'=>'required|array',
        'paid'=>'required|array'

       ]);
       $total_price= 0;
       $order= $client->orders()->create([]);//ر32
        foreach ($request->product_ids as $index=>$product_id){
            $product = Product::find($product_id);
            $glass = Product::where('name', $request->glass_names[$index])->first();
            $stoke_perfume =$request->order =="retail"?$product->retail_stoke:$product->whole_stoke;
            if($request->volume[$index]<=$stoke_perfume){
                $product_glass = Product::find($glass->id);
                $stoke_glass =$request->order =="retail"?$product_glass->retail_stoke:$product_glass->whole_stoke;
                    if($request->quantity[$index]<=$stoke_glass){
                        $debt=   $request->paid[$index]-(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index]);
                        $total_price+=(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index])+$debt;
                        $order->products()->attach($product_id,
                        ['quantity'=>$request->quantity[$index],
                        'sale_price'=>$request->sale_price[$index],
                        'discount'=>$request->discount[$index],
                        'paid'=>$debt,
                        'volume'=>$request->volume[$index],
                        'glass_id'=>$glass->id,
                        'client_id'=>$client->id,
                        'created_at'=>date("Y-m-d h:i:sa"),
                        ]);
                        $type_of_sale = 0;
                        if($request->order =="retail"){
                            $product->retail_stoke =  $product->retail_stoke - $request->volume[$index];
                            $product_glass->update([
                                'retail_stoke'=>$product_glass->retail_stoke - $request->quantity[$index]
                            ]);
                           
                        }else {
                            $product->whole_stoke =  $product->whole_stoke - $request->volume[$index];
                            $product_glass->update([
                                'whole_stoke'=>$product_glass->whole_stoke - $request->quantity[$index]
                            ]);
                            $type_of_sale = 1;
                        }
                        $product->save();

                        $ord =  Order::find($order->id);
                        $ord->total_price=$total_price;
                        $ord->type_of_sale=$type_of_sale;
                        $ord->save();
                      
                       
                    }else{
                        $order->delete();
                        return redirect()->back()->withErrors(['error'=>__('الزجاج لا يكفي للكمية المطلوبة')]);
        
                    }
                       
            }else{
                $order->delete();
                return redirect()->back()->withErrors(['error'=>__('كمية الزيت المطلوبة أكبر من الكمية الموجودة')]);

            }

        }



        //         $product = Product::find($product_id);
               
                     
          
           
        //     $glass = DB::table('products')->where('name', $request->glass_names[$index])->get();
        //     $glassUpdate = Product::find($id);

        //     $total_price+=($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index];
        //     $order->products()->attach($product_id,
        //     ['quantity'=>$request->quantity[$index],
        //     'sale_price'=>$request->sale_price[$index],
        //     'discount'=>$request->discount[$index],
        //     'paid'=>$request->paid[$index]-(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index]),
        //     'volume'=>$request->volume[$index],
        //     'glass_id'=>$id,
        //     ]);
           
        //     $product->stoke =   $product->stoke - $request->volume[$index];
        //     $product->save();
          
        //     $glassUpdate->update([
        //         'stoke'=>$glassUpdate->stoke - $request->quantity[$index]
        //     ]);

                
          
        // }
        // $ord =  Order::find($order->id);
        // $ord->total_price=$total_price;
        // $ord->save();
       
    }



    
    private function destroyForUpdate(Order $order)
    {
       
        
        foreach ($order->products as $product){
            $glass = Product::find($product->pivot->glass_id);
            if($order->type_of_sale==0){
                $product->update([
                    'retail_stoke'=>$product->pivot->quantity+$product->retail_stoke,
                 ]);
                 $glass->update([
                    'retail_stoke'=> $product->pivot->quantity+$glass->retail_stoke 
                ]);
               
            }else {
                $product->update([
                    'whole_stoke'=>$product->pivot->quantity+$product->whole_stoke,
                 ]);
                 $glass->update([
                    'retail_stoke'=> $product->pivot->quantity+$glass->whole_stoke 
                ]);
            }
            

        }



        $order->products()->detach();
       
        $order->delete();
        
    }
}
