<?php

namespace App\Http\Controllers;

use App\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\Datatables\Datatables;
use App\Client;
use App\Order;
use App\Product;
use App\OrderProduct;
use App\Payment;
use Illuminate\Support\Facades\DB;
class ControllerClient extends Controller
{
    public function __construct()
    {

        $this->middleware(['auth']);

    }
    public function anyData()
    {
        return Datatables::of(Client::query())
        
        ->setRowId('tr_{{$id}}') 
        ->addColumn('add',function(Client $client) {
            return '<a class="btn btn-info btn-sm" href="/dashboard/clients/orders/create/'.$client->id.'"  ><i class="fa fa-plus" aria-hidden="true"></i> </a>';
        } )
        ->addColumn('show',function(Client $client) {
            return '<a class="btn btn-info btn-sm" href="/dashboard/clients/showSales/'.$client->id.'"  >عرض</a>';
        })
        ->addColumn('action',function(Client $client) {
            return 
        '<a  id="delete" data-value="'.$client->id.'" class="btn btn-danger  remove-project">
            <i class="fa fa-trash" aria-hidden="true"></i>خذف
        </a>
        <a href="/dashboard/clients/edit/'.$client->id.'"  class="btn btn-info editu" >
           <i class="fa fa-edit" aria-hidden="true"></i>تعديل
        </a>';
        })
        ->rawColumns(['add','show','action'])
        ->toJson();
        
        
    }  
    


    public function index(Request $request)
    {


        return view('adminlte.dashboardview.Clients.index');
        //
    }
    public function delivery_points(Client $client){
        $pointObj = Point::where('client_id',$client->id)->first();
        $pointObj->point = $pointObj->point%150;
        $pointObj->save();
        return back();


    }
    public function create()
    {

        return view('adminlte.dashboardview.Clients.create');
    }
    public function store(Request $request)
    {


        if($request->phone[1]!=null)
            $this->rule+=['phone.1'=>'numeric'];
        $request->validate($this->rule);

       Client::create($request->all());
       return redirect()->back()->with('Success', 'تمت الاضافة بنجاح');  

        // return redirect()->route('dashboard.clients.index');
    }
    public function edit(Client $client)
    {
        return view('adminlte.dashboardview.Clients.create',compact('client'));

    }

    public function update(Request $request, Client $client)
    {

        
        if($request->phone[1]!=null)
        $this->rule+=['phone.1'=>'numeric'];
        $request->validate($this->rule);

        $client->update($request->all());
        return redirect()->route('dashboard.clients.index')->with('Success', 'تمت التعديل بنجاح');  

    }


    public function destroy($id)
    {
       
       
        try{
            $client = Client::findOrFail($id);
            $client->orders()->delete();
            $client->points()->delete();
            foreach ($client->debts as $orderproduct){
                $orderproduct->payments()->delete();
            }
            $client->debts()->delete();
            $client->delete();
        }catch (ModelNotFoundException $exception){
            return redirect()->route('dashboard.clients.index')->withErrors(['error'=>__('غير موجود')]);

        }
    }
    public function showSales(Client $client){
        $orders = $client->orders;
        $index=0;
        $products_sales = array();
        foreach($orders as $order){
            foreach($order->products as $product){//product row in pivot table
                $products_sales[$index]=OrderProduct::where('client_id',$client->id)->where('order_id',$order->id)->where('product_id',$product->id)->first();

                $glasses[$index] = Product::find($product->pivot->glass_id);

                $index++;
            }
        }

        return view('adminlte.dashboardview.Clients.showSales',compact('client','products_sales','glasses'));

    }
    public function showPayments(Client $client,Order $order,Product $product){
      $product_sale = OrderProduct::where('client_id',$client->id)->where('order_id',$order->id)->where('product_id',$product->id)->first();
        return response()->json(['status'=>'200','product_sale'=>$product_sale,'payments'=>$product_sale->payments]); 
    }
    public function clients_debts(Request $request){

        $Orders_Products = OrderProduct::where('isDelevery',0)->get();
      
        $client_ids= $Orders_Products->pluck('client_id')->toArray();
        $client_ids = array_unique($client_ids);
        $client_debts=array();
        $Debtors=[];
        
        $total_debts = 0;
        foreach ($client_ids as $index=>$id){
            $Debtors[$index] = Client::find($id);
            $client_debt=0;
           
            foreach ($Debtors[$index]->debts as $j=>$debt){//$debt == OrderProduct
               
                
                    foreach($debt->payments as $payment ){
                        $client_debt+=$payment->paid;
                        $total_debts+=$payment->paid;
                    }
                   
                    }
                    $client_debts[$index]=$client_debt;

                   }
                 
       
       
    
       


        
      
   
        return view('adminlte.dashboardview.Clients.debt.index',compact('Debtors','client_debts','total_debts'));
    }
    public function showDebts(Client $client){
        $product_debts = OrderProduct::where('isDelevery','0')->where('client_id',$client->id)->get();
        $product_debts_ids = $product_debts->pluck('id')->toArray();
        $total_debts_unit=array();
        foreach($product_debts as $index=>$product_debt){
            $products[$index] =Product::find($product_debt->product_id);
            $product_debts_objs[$index] = OrderProduct::find($product_debt->product_id);
            $total_debts_unit[$index] = Payment::where('paid','!=' ,'0')->where('orderproduct_id',$product_debts_ids[$index])->sum('paid');

           
            $glasses[$index] = Product::find($product_debt->glass_id);
            }
        
          

        
        return view('adminlte.dashboardview.Clients.debt.showDebtsClient',compact('client','product_debts','products','glasses','total_debts_unit'));

    }
    public function editDebts(Request $request,Client $client){
        $flag=0;
        $payment_id=0;
        $order_products = OrderProduct::where('isDelevery','0')->where('client_id',$client->id)->get();
       
        $Subtract=$request->refund;

        foreach($order_products as $product){

            foreach($product->payments as $payment){  
                $sum = DB::select("select SUM(paid) as total_payments from payments where orderproduct_id=".$product->id);

                $new_payment = new Payment();
                if($payment->paid<0)
                    {

                        if($Subtract >= (-$sum[0]->total_payments)){
                            $new_payment->paid =-$sum[0]->total_payments;
                            $Subtract = $Subtract+$sum[0]->total_payments;
                          
                            $product->isDelevery = true;
                            $product->update([
                                'isDelevery'=>true,
                            ]);
                            
                            $new_payment->save();
                            $product->payments()->save($new_payment);
                        
                        }else{

                            if($Subtract+$sum[0]->total_payments<0){
                                $new_payment->paid = ($Subtract);
                                $Subtract = $Subtract+$sum[0]->total_payments;
                                $new_payment->save();
                                $product->payments()->save($new_payment);
                               
                              
                            }
                            // else{
                            //     $new_payment->paid = $Subtract+$sum[0]->total_payments;
                            //     $Subtract = $Subtract+$sum[0]->total_payments;
                            //     $new_payment->save();
                            //     $product->payments()->save($new_payment);
                            // }
                            if($sum[0]->total_payments ==0){
                                $product->isDelevery = true;
                                $product->update([
                                    'isDelevery'=>true,
                                ]); 
                                }
                        
                        }
                    }
            
            }
            if($Subtract<=0){
                $Subtract=0;
              
            break;
            }
        }
        
        return back();
       
        
        

        // $newOrder->total_paid = $total_paid;
        // $newOrder->client_id = $client->id;
        // $newOrder->remaining = $Subtract;
        // $newOrder->save();
    }

      

  
       



       

    private $rule=[
        'name'=>'required',
        'address'=>'required',
        'phone.0'=>'required|numeric',
    ];
    // private function rulesedit($client){
    //     return [
    //         'name'=>'required',
    //         'address'=>'required',
    //         'phone.0'=>'required|numeric',
                      
    
    //     ];
    // }
    
    
    
    // private function rules(){
    //     return [
    //         'name'=>'required',
    //         'address'=>'required',
    //         'phone.0'=>'required|numeric',
    //     ];
    // }
    
    private function messages(){
        return [
    //            'name.required'=>'name is required',
    //            'name.min'=>' name length is too short',
    //            'password.required'=>'password is required',
    //            'password.min'=>'password length is too short',
    //            'passwordc.required'=>'password is required',
    //            'passwordc.confirmed'=>'password must confirmed',
        ];
    }
    
}
