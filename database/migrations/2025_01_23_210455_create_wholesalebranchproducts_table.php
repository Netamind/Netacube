<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWholesalebranchproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wholesalebranchproducts', function (Blueprint $table) {
            $table->id();
            $table->integer('branch');
            $table->integer('product');
            $table->decimal('quantity', 20, 2)->default(0.00);
            $table->integer('branchprice')->nullable();
            $table->date('branchexpiry')->nullable();
            $table->string('shelfnumber')->nullable();
            $table->string('branchbatch')->nullable();
            $table->string('priceststatus')->default("false");
            $table->string('expirystatus')->default("false");
            $table->string('batchstatus')->default("false");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wholesalebranchproducts');
    }
}
