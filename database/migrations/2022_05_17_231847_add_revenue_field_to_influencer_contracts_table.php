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
        Schema::table('influencer_contracts', function (Blueprint $table) {
            $table->bigInteger('revenue')->nullable()->default(0)->after('af');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('influencer_contracts', function (Blueprint $table) {
            $table->dropColumn('revenue');
        });
    }
};
