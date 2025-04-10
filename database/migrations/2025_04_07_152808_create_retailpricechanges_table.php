<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailpricechangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailpricechanges', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('productid'); 
            $table->string('unit'); 
            $table->integer('oldprice'); 
            $table->integer('newprice'); 
            $table->unique(['date', 'productid']);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retailpricechanges');
    }
}
