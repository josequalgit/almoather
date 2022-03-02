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
            $table->string('store');
            $table->bigInteger('budget');
            $table->longText('ad_script')->nullable();
            $table->longText('auth_number')->nullable();
            $table->boolean('onSite')->default(0);
            $table->longText('about');
            $table->longText('website_link');
            $table->bigInteger('social_media_id')->unsigned();
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('area_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('influncer_id')->unsigned()->nullable();
            $table->longText('reject_note')->nullable();
            $table->enum('status',['pending','prepay','fullpayment','progress','influncer_complete','complete','incomplete','rejected','waiting_for_payment']);

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
