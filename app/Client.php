<?php

namespace App;
use App\Product;
use App\Order;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'address', 'phone',
    ];
    protected  $casts =['phone'=>'array',];
    public function orders(){
        return $this->hasMany(Order::class,'client_id','id');
    }
    public function debts(){//products sales
        return $this->hasMany(OrderProduct::class,'client_id','id');
    }
        // public function products(){
        // return $this->belongsToMany(Product::class,'product_client');
        // }
}
