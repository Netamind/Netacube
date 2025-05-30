<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetaildeliverynotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retaildeliverynotes', function (Blueprint $table) {
            $table->id();
            $table->integer('branchid');
            $table->integer('productid');
            $table->date('date');
            $table->decimal('quantity', 20, 2);
            $table->string('productname');
            $table->string('unit');
            $table->integer('price');
            $table->decimal('errorvalue',20,2)->default(0.00);
            $table->string('errorstate')->default("Pending");
            $table->string('erroruser')->nullable();
            $table->string('added_to_branch')->default("No");
            $table->unique(['branchid', 'productid', 'date', 'added_to_branch'], 'bpda_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retaildeliverynotes');
    }
}
