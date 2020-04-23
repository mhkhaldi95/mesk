<?php

namespace App\Http\Controllers;
use App\Category;
use App\Client;
use App\Order;
use App\OrderProduct;
use App\Point;
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
    public function create(Client $client)
    { 
    
        $orders = $client->orders()->orderBy('created_at', 'DESC')->paginate(5);
        // $categories = Category::all();
        return view('adminlte.dashboardview.Clients.Orders.create',compact('client','orders'));

    }
     public function fetch_data(Request $request,Client $client ){
        
        if ($request->ajax()) {
            $orders = $client->orders()->orderBy('created_at', 'DESC')->paginate(5);
            return view('adminlte.dashboardview.Clients.Orders.load', ['orders' => $orders,'client'=>$client])->render();  
        }
    }
    public function showProducts_order(){
       
        return Datatables::of(Product::query())
        
        ->addColumn('action',function($product) {
           
            $categories = Category::all();
            return '<a data-name ="'.$product->name.'" data-value="'.$product->id.'" class="btn btn-primary add_product" >
            <i class="fa fa-plus" aria-hidden="true"></i>
        </a>';
        })
        ->rawColumns(['action'])
       
        ->toJson();
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
     
        $categories = Category::all();
        
        return view('adminlte.dashboardview.Clients.Orders.edit',compact('client','order','categories'));

    }
    public function update(Request $request,Order $order,Client $client)
    {
        
       
        $this->destroyForUpdate($order);
       
        $this->attach_order( $request, $client);


      
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
        $total_price= 0;
        $points=0;
        $product_ids = [1,2,3,4];
        $order= $client->orders()->create([]);//ر32
         foreach ($request->product_ids as $index=>$product_id){
           $product = Product::find($product_id);
            $stoke_perfume =$request->order =="retail"?$product->retail_stoke:$product->whole_stoke;
             if($request->volume[$index]<=$stoke_perfume){
                $debt=   $request->paid[$index]-(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index]);
                $total_price+=(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index]);
                 $points+=$request->paid[$index];

                 $store_Order_Product=null;
                 if(in_array($product->category->id,$product_ids)){
                    $product_glass = Product::find($request->glass_ids[$index]);
                    if($product_glass!=null)
                    $stoke_glass =$request->order =="retail"?$product_glass->retail_stoke:$product_glass->whole_stoke;
                    else{
                        
                        $order->delete();
                        return redirect()->back()->withErrors(['error'=>__(' اختر نوع الزجاجة')]);
                  } 
                    if($request->quantity[$index]<=$stoke_glass){
                        
                         $store_Order_Product= $this->createOrderProduct($request,$index,$order,$product,$product_glass,$client);
                    }else{
                         $order->delete();
                         return redirect()->back()->withErrors(['error'=>__('الزجاج لا يكفي للكمية المطلوبة')]);
                    }
                 }else{
                    $store_Order_Product= $this->createOrderProduct($request,$index,$order,$product,null,$client);
                 }
                 $payment = new Payment();
                 $payment->paid = $debt;
                 $payment->save();

                 $store_Order_Product->payments()->save($payment);
                 $type_of_sale = 0;
                 if(in_array($product->category->id,$product_ids)){
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
                 }else{
                    if($request->order =="retail"){
                        $product->retail_stoke =  $product->retail_stoke - $request->quantity[$index];
                      
                    }else {
                        $product->whole_stoke =  $product->whole_stoke - $request->quantity[$index];
                        $type_of_sale = 1;
                      
                    }
                 }
             
                 $product->save();

                 $order->total_price=$total_price;
                 $order->type_of_sale=$type_of_sale;
                 $order->save();
                        
             }else{
                 $order->delete();
                 return redirect()->back()->withErrors(['error'=>__('كمية الزيت المطلوبة أكبر من الكمية الموجودة')]);
 
             }
 
             
           
         }
        if($client->points==null){

            $pointObj = new Point();
            $pointObj->point = $points;
            $pointObj->save();
            $client->points()->save($pointObj);
        }else{
            $pointObj = Point::where('client_id',$client->id)->first();
          $pointObj->point += $points;
            $pointObj->save();
        }

         return redirect()->route('dashboard.orders.index')->with('Success', 'تم التعديل بنجاح'); 
   
    }
    private function createOrderProduct($request,$index,$order,$product,$product_glass=null,$client){
                        $debt=   $request->paid[$index]-(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index]);
                        //  $total_price+=(($request->sale_price[$index]*$request->quantity[$index])-$request->discount[$index]);
                        $store_Order_Product = new OrderProduct(); 
                        $store_Order_Product->order_id = $order->id;
                        $store_Order_Product->product_id = $product->id;
                        $store_Order_Product->client_id = $client->id;
                        $store_Order_Product->quantity = $request->quantity[$index];
                        $store_Order_Product->sale_price = $request->sale_price[$index];
                        $store_Order_Product->discount = $request->discount[$index];
                        if($request->volume[$index]!=0)
                        $store_Order_Product->volume = $request->volume[$index];
                        else $store_Order_Product->volume =0;
                        if($product_glass!=null)
                        $store_Order_Product->glass_id = $product_glass->id;
                        else  $store_Order_Product->glass_id = 0;

                        if($debt==0)
                        $store_Order_Product->isDelevery = true;
                        $store_Order_Product->save();
                        return $store_Order_Product;
                      
    }
    public function show_sales(){
        return Datatables::of(OrderProduct::query()->latest())
        
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
             if($glass!=null)
             return $glass->name;
             else return '-';
        
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
