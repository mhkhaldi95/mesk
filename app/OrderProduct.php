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
    protected $appends=['profit'];

    public function getImagePathAttribute(){
        return asset('/uploads/image_product/'.$this->image);
    }
    public function getProfitAttribute(){
        $product = $this->product;
        $glass = Product::find($this->glass_id);

        $cohol = Product::where('name','كحول')->first();
        if($product->category_id<4){
            $profit =(( $this->sale_price-($this->volume*$product->purchase_price))-($glass->purchase_price*$this->quantity))
                -($cohol->purchase_price*(2*$this->volume))-$this->discount;
        }else if($product->category_id==4){
            $profit =(( $this->sale_price-($this->volume*$product->purchase_price))-($glass->purchase_price*$this->quantity))
               -$this->discount;
        }else{
            $profit =(( $this->sale_price-($this->quantity*$product->purchase_price))-$this->discount);
        }


        return number_format($profit,'2');
    }
    //
}
