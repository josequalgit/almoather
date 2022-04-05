<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['service','product']);
            $table->enum('ad_type',['onsite','online']);
            $table->enum('expense_type',['none','pve','pvn'])->default('none');
            $table->string('store');
            $table->string('marouf_num')->nullable();
            $table->string('store_link')->nullable();
            $table->string('cr_num')->nullable();
            $table->longText('about');
            $table->longText('scenario')->nullable();
            $table->bigInteger('budget');
            $table->longText('discount_code')->nullable();
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('area_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('influncer_id')->unsigned()->nullable();
            $table->longText('reject_note')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_accepted')->default(0); // check if the customer accept the contract
            $table->date('date')->nullable(); // starting date
            $table->softDeletes();
            $table->enum('status',['pending','prepay','fullpayment','progress','influncer_complete','complete','incomplete','rejected','approve','cancelled'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
};
