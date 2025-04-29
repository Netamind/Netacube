<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailpartialstoctakingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailpartialstoctaking', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('branch'); 
            $table->integer('productid'); 
            $table->string('product'); 
            $table->string('unit');
            $table->integer('price'); 
            $table->decimal('expected'); 
            $table->decimal('found');
            $table->integer('counter');  
            $table->decimal('rate'); 
            $table->string('rectfied')->default('No');
            $table->unique(['date','branch', 'productid']);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retailpartialstoctaking');
    }
}
