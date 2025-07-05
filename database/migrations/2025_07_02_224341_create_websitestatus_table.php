<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsitestatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websitestatus', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('is_zero_description');
            $table->string('is_one_description');
        });

        DB::table('websitestatus')->insert([
            'status' => '0',
            'is_zero_description' => 'Website status is disabled. The landing page will redirect to the login page.',
            'is_one_description' => 'Website status is enabled. The landing page will display the website with dynamic content. Ensure all content is entered under the website section.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('websitestatus');
    }
}
