<?php

namespace App;
use App\Product;
use App\Order;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'address', 'phone','BOD'
    ];
    protected  $casts =['phone'=>'array',];
    public function orders(){
        return $this->hasMany(Order::class,'client_id','id');
    }
    public function debts(){//products sales
        return $this->hasMany(OrderProduct::class,'client_id','id');
    }
    public function points(){//products sales
        return $this->hasOne(Point::class);
    }
    protected $appends=['first_name'];
    public function getFirstNameAttribute(){
       $name =  explode(" ",$this->name) ;
       return $name[0];
    }
        // public function products(){
        // return $this->belongsToMany(Product::class,'product_client');
        // }
}
