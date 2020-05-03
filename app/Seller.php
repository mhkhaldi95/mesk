<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected  $casts =['phone'=>'array',];
    protected $fillable = [
        'name', 'phone'
    ];
    public function orders(){
        return $this->hasMany(SellerOrder::class,'seller_id','id');
    }
}
