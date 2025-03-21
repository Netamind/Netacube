<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailbaseproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailbaseproducts', function (Blueprint $table) {
            $table->id();
            $table->string('product')->unique();
            $table->integer('supplier');
            $table->string('unit');
            $table->integer('orderprice');
            $table->integer('sellingprice');
            $table->string('vat')->default('EX');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retailbaseproducts');
    }
}
