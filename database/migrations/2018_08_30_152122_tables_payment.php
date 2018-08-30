<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablesPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('payment_type', ['1', '2'])->comment('1: MercadoPago; 2: Paypal;');
            $table->integer('user_id')->unsigned();
            $table->string('transaction_code', 255)->nullable();
            $table->string('transaction', 255)->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::create('purchase_deatils', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id')->unsigned();
            $table->integer('product_amount_id')->unsigned();
            $table->double('price', 10,2);
            $table->double('price_usd', 10,2);
            $table->timestamps();
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->foreign('product_amount_id')->references('id')->on('product_amount');
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('purchase_deatils');
    }
}
