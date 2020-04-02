<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','sequenceNo','purchase_price','whole_stoke','retail_stoke','stoke','category_id'];

    
    protected $guarded = array();

    public function category(){
        return $this->hasOne('App\Category','id','category_id');
    }
    public function orders(){
        return $this->belongsToMany(Order::class,'order_product');
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
    // public function clients(){
    //     return $this->belongsToMany(Client::class,'product_client');
    // }
    // protected $appends=['profit_percent'];

    // public function getProfitPercentAttribute(){
    //     $profit = $this->sale_price-$this->purchase_price;
    //     $profit = $profit*100/$this->purchase_price;
    //     return number_format($profit,'2');
    // }

    //
}
