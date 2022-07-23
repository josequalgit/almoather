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
            $table->timestamp('contract_send_at')->default(DB::raw('CURRENT_TIMESTAMP'))->after('updated_at');
            $table->timestamp('last_notification_time')->default(DB::raw('CURRENT_TIMESTAMP'))->after('contract_send_at');
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
            $table->dropColumn('contract_send_at');
            $table->dropColumn('last_notification_time');
        });
    }
};
