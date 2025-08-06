<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanygeneralInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companygeneral_info', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->nullable();
            $table->string('business_license_number')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('business_description')->nullable();
            $table->string('business_mission')->nullable();
            $table->string('business_vision')->nullable();
        });

         DB::table('companygeneral_info')->insert(['id' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companygeneral_info');
    }
}
