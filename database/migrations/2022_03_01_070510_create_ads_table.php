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
            $table->enum('expense_type',['none','pve','pvn'])->default('none');
            $table->string('store');
            $table->bigInteger('budget');
            $table->boolean('is_verified')->default(0);
            $table->date('date');
            $table->longText('ad_script')->nullable();
            $table->longText('scenario')->nullable();
            $table->longText('auth_number')->nullable();
            $table->boolean('onSite')->default(0);
            $table->boolean('has_discount_code')->default(0);
            $table->boolean('hasStore')->default(0);
            $table->longText('discount_code')->nullable();
            $table->longText('website_link');
            $table->longText('about');
            $table->string('delivery_man_name')->nullable();
            $table->longText('delivery_phone_number')->nullable();
            $table->longText('delivery_city_name')->nullable();
            $table->longText('delivery_area_name')->nullable();
            $table->longText('delivery_street_name')->nullable();
            $table->longText('nearest_location')->nullable();
            $table->bigInteger('social_media_id')->unsigned();
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('area_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('media_account_id')->unsigned();
            $table->bigInteger('influncer_id')->unsigned()->nullable();
            $table->longText('reject_note')->nullable();
            $table->softDeletes();
            $table->enum('status',['pending','prepay','fullpayment','progress','influncer_complete','complete','incomplete','rejected','approve','cancelled']);

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
