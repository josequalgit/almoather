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
            $table->string('nick_name');
            $table->longText('bank_name');
            $table->longText('bank_account_number');
            $table->longText('bio');
            $table->boolean('ads_out_country')->default(0);
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('nationality_id')->unsigned();
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
