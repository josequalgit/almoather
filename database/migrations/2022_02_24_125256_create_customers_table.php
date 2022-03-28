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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('id_number');
            $table->integer('ratting')->default(0);
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('region_id')->unsigned();
            $table->bigInteger('nationality_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->longText('commercial_registration_no');
            $table->longText('tax_registration_number');
            $table->date('starting_date')->nullable();
            $table->enum('status',['active','band'])->default('active');
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
        Schema::dropIfExists('customers');
    }
};
