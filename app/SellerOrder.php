<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SellerOrder extends Model
{
    protected $fillable=['total_price'];
    public function seller(){
        return $this->hasOne(Seller::class,'id','seller_id');
    }
    public function payments(){
        return $this->hasMany(SellerPayment::class,'seller_order_id','id');
    }
    protected $appends=['total_paid'];
    public function getTotalPaidAttribute(){


            $obj = SellerOrder::find($this->id);

            $paid = SellerPayment::where('seller_order_id',$obj->id)->sum('paid');
            $total_paid =$this->total_price+$paid;

        return $total_paid ;

    }
}
