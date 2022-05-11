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
        Schema::table('ads_influencer_matches', function (Blueprint $table) {
            $table->enum('status',['basic','not_basic','deleted'])->default('not_basic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads_influencer_matches', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
