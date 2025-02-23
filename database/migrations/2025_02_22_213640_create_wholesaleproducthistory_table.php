<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWholesaleproducthistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wholesaleproducthistory', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('branchid');
            $table->integer('productid');
            $table->decimal('qtyadded', 20, 2);
            $table->string('username');
            $table->string('devicedetails');
            $table->decimal('qtybefore', 20, 2); 
            $table->decimal('qtyafter', 20, 2);
            $table->string('description');
            $table->string('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wholesaleproducthistory');
    }
}
