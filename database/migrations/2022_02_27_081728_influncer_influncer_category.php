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
        Schema::create('influncer_influncer_category', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('influncer_category_id')->unsigned();
            $table->bigInteger('influncer_id')->unsigned();
    
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
