<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('product_id');
            $table->integer('order_id');
            $table->double('quantity')->default(0);
            $table->double('sale_price')->default(0);
            $table->double('discount')->default(0);
            // $table->double('paid')->default(0);
            $table->double('volume')->default(0);
            $table->double('glass_id')->default(0);
            $table->boolean('isDelevery')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
    }
}
