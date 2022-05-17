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
        Schema::create('influencer_contracts', function (Blueprint $table) {
            $table->id();
            $table->longText('content');
            $table->boolean('is_accepted');
            $table->bigInteger('influencer_id')->unsigned();
            $table->foreign('influencer_id')->references('id')->on('influncers')->onDelete('cascade');
            $table->bigInteger('ad_id')->unsigned();
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
            $table->boolean('status')->default(0);
            $table->boolean('admin_status')->default(0);
            $table->date('date')->nullable();
            $table->longText('rejectNote')->nullable();
            $table->longText('link')->nullable();
            $table->bigInteger('af');
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
        Schema::dropIfExists('influencer_contracts');
    }
};
