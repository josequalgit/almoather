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
        Schema::create('marketing_ad_ratings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ad_id')->unsigned();
            $table->bigInteger('influencer_id')->unsigned();
            $table->enum('rate',[0,1,2]);
            $table->longText('note');
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
        Schema::dropIfExists('marketing_ad_ratings');
    }
};
