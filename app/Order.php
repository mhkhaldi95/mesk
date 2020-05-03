<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['total_price','type_of_sale'];
    public function clients(){
        return $this->hasOne(Client::class,'id','client_id');
    }
    public function products(){
        return $this->belongsToMany(Product::class,'order_product')->withPivot('id','quantity','client_id','sale_price','glass_id','volume','discount','created_at');
    }
    protected $appends=['total_paid'];
    public function getTotalPaidAttribute(){
        $total_paid=0;
        foreach($this->products as $product){
            $obj = OrderProduct::where('order_id',$this->id)
            ->where('client_id',$product->pivot->client_id)
            -> where('product_id',$product->id)
            ->first();
            $paid = Payment::where('orderproduct_id',$obj->id)->sum('paid');
            $total_paid =$this->total_price+$paid;
        }
        return $total_paid ;
        
    }


}
