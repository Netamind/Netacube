<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailfullstocktakingmissingproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailfullstocktakingmissingproducts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('branch');
            $table->integer('productid');  
            $table->string('product'); 
            $table->string('unit'); 
            $table->integer('price'); 
            $table->decimal('quantity'); 
            $table->decimal('rate', 20, 2)->default(1.00);
            $table->unique(['date', 'branch', 'productid'], 'missing_product_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retailfullstocktakingmissingproducts');
    }
}
