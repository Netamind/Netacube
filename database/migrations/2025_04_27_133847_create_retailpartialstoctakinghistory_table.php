<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailpartialstoctakinghistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailpartialstoctakinghistory', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('branch'); 
            $table->integer('expected')->default(0);
            $table->integer('found')->default(0);
            $table->string('document')->nullable();
            $table->unique(['date', 'branch'], 'rpstocktaking_history_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retailpartialstoctakinghistory');
    }
}
