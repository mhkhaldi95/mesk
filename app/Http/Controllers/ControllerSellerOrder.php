<?php

namespace App\Http\Controllers;

use App\Client;
use App\Order;
use App\OrderProduct;
use App\Payment;
use App\Seller;
use App\SellerOrder;
use App\SellerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerSellerOrder extends Controller
{
    public function index(Request $request)
    {
        $orders = SellerOrder::orderBy('created_at', 'DESC')->get();

        return view('adminlte.dashboardview.SellerOrders.index',compact('orders'));
    }
    public function create(Seller $seller)
    {



        return view('adminlte.dashboardview.Sellers.Orders.create',compact('seller'));

    }
    public function old_orders(Seller $seller){

        $orders = $seller->orders()->orderBy('created_at', 'DESC')->paginate(5);
        return view('adminlte.dashboardview.Sellers.Orders.old_orders',compact('seller','orders'));
    }

    public function store(Request $request,Seller $seller){

       $seller_order =  SellerOrder::create($request->all());
        $seller->orders()->save($seller_order);
        $payment = new SellerPayment();
        $payment->paid = $request->paid-$request->total_price;
        $payment->save();
        if($request->paid-$request->total_price == 0){
            $seller_order->isDelevery = 1;
            $seller_order->save();
        }
        $seller_order->payments()->save($payment);
        return redirect()->back()->with('Success', 'تمت الاضافة بنجاح');

    }
    public function seller_debt_view(Seller $seller,SellerOrder $order){
        $debt = DB::select("select SUM(paid) as total_payments from seller_payments where seller_order_id=".$order->id);

        return view('adminlte.dashboardview.Sellers.Orders.paid_debt',compact('seller','order','debt'));

    }
    public function edit_seller_debt(Request $request,Seller $seller,SellerOrder $order){

        $flag=0;
        $payment_id=0;
        $order = SellerOrder::where('isDelevery','0')->where('seller_id',$seller->id)
            ->where('id',$order->id)->first();


        $Subtract=$request->refund;



            foreach($order->payments as $payment){
                $sum = DB::select("select SUM(paid) as total_payments,seller_order_id from seller_payments where seller_order_id=".$order->id);


                $new_payment = new SellerPayment();
                if($payment->paid<0)
                {

                    if($Subtract >= (-$sum[0]->total_payments)){
                        $new_payment->paid =-$sum[0]->total_payments;
                        $Subtract = $Subtract+$sum[0]->total_payments;

                        $order->isDelevery = true;
                        $order->update([
                            'isDelevery'=>true,
                        ]);

                        $new_payment->save();
                        $order->payments()->save($new_payment);

                    }else{

                        if($Subtract+$sum[0]->total_payments<0){
                            $new_payment->paid = ($Subtract);
                            $Subtract = $Subtract+$sum[0]->total_payments;
                            $new_payment->save();
                            $order->payments()->save($new_payment);


                        }

                        if($sum[0]->total_payments ==0){
                            $order->isDelevery = true;
                            $order->update([
                                'isDelevery'=>true,
                            ]);
                        }

                    }
                }

            }
            if($Subtract<=0){
                $Subtract=0;


            }


        return back();

    }
    public function showPayments(Seller $seller,SellerOrder $order){
        $payments_order = SellerOrder::where('seller_id',$seller->id)->where('id',$order->id)->first();
        return response()->json(['status'=>'200','payments_order'=>$payments_order,'payments'=>$payments_order->payments]);
    }

}
