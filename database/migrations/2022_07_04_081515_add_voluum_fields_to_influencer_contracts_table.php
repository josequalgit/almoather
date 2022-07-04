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
            $table->string('voluum_id')->nullable()->after('id');
            $table->text('campaign_url')->nullable()->after('voluum_id');
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
            $table->dropColumn('voluum_id');
            $table->dropColumn('campaign_url');
        });
    }
};
