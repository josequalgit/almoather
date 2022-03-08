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
        Schema::create('influncers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name_en');
            $table->string('full_name_ar');
            $table->date('birthday');
            $table->bigInteger('nationality_id')->unsigned();
            $table->string('id_number');
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('region_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('address_id')->unsigned();
            $table->string('phone');
            $table->string('nick_name');
            $table->longText('bank_name');
            $table->longText('bank_account_number');
            $table->longText('bio');
            $table->boolean('ads_out_country')->default(0);
            $table->boolean('is_vat');
            $table->integer('ratting')->default(0);
            $table->integer('ad_price');
            $table->integer('ad_with_vat');
            $table->integer('ad_onsite_price');
            $table->integer('ad_onsite_price_with_vat');
            $table->longText('rejected_note')->nullable();
            $table->enum('status',['pending','accepted','rejected','band'])->default('pending');
            $table->bigInteger('user_id')->unsigned();

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
        Schema::dropIfExists('influncers');
    }
};
