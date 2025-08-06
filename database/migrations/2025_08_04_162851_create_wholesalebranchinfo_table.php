<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWholesalebranchinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('wholesalebranchinfo', function (Blueprint $table) {
    $table->id();
    $table->integer('branchid')->unique();
    $table->string('logo')->nullable();
    $table->string('letterhead')->nullable();
    $table->string('postal_address')->nullable();
    $table->string('email_address')->nullable();
    $table->string('primary_contact')->nullable();
    $table->string('secondary_contact')->nullable();
    $table->string('bank_name')->nullable();
    $table->string('account_name')->nullable();
    $table->string('account_number')->nullable();
    $table->string('account_type')->nullable();
    $table->text('invoice_terms')->nullable();
    $table->text('quotation_terms')->nullable();
    $table->text('cashsale_terms')->nullable();
    $table->string('business_number')->nullable();
    $table->string('tin_number')->nullable();
     });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wholesalebranchinfo');
    }
}
