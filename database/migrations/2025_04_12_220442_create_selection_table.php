<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selection', function (Blueprint $table) {
            $table->id();
            $table->integer('user')->unique();
            $table->string('sector')->nullable();
            $table->string('homesector')->default('Retail');
            $table->string('homecategory')->default('All');
            $table->string('rcategory')->nullable();
            $table->string('wcategory')->nullable();
            $table->string('wbranch')->nullable();
            $table->string('rbranch')->nullable();
            $table->string('startdate')->nullable();
            $table->string('enddate')->nullable();
            $table->string('rdate')->nullable();
            $table->string('wdate')->nullable();
            $table->string('rproduct')->nullable();
            $table->string('wproduct')->nullable();
            $table->string('rsupplier')->nullable();
            $table->string('wsupplier')->nullable();
            $table->string('rfstockdate')->nullable(); 
            $table->string('rfstockbranch')->nullable();
            $table->string('rpstockdate')->nullable();
            $table->string('rpstockbranch')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('selection');
    }
}
