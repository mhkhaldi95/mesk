<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'paid','created_at',
    ];
    protected $table='order_product';
    public function payments(){
        return $this->hasMany(Payment::class,'orderproduct_id','id');
    }
    public function client(){
        return $this->hasOne(Client::class,'id','client_id');
    }
    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
    //
}
