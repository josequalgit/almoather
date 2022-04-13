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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->longText('link')->nullable();
            $table->date('date')->nullable();
            $table->boolean('is_accepted')->default(0);
            $table->boolean('is_completed')->default(0);
            $table->boolean('influencer_status')->default(0);
            $table->boolean('admin_status')->default(0);
            $table->bigInteger('ad_id')->unsigned()->nullable();
            $table->bigInteger('influencer_id')->unsigned()->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->longText('rejectNote')->nullable();
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
        Schema::dropIfExists('contracts');
    }
};
