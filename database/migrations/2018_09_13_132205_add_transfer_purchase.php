<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransferPurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        // Schema::table('purchases', function (Blueprint $table) {
        //     $table->enum('payment_type',['1','2','3'])->comment('1: MercadoPago, 2: PayPal, 3: Transferencia')->change();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('purchases', function (Blueprint $table) {
        //     $table->dropColumn('payment_type');
        // });
    }
}
