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
        Schema::table('contracts', function (Blueprint $table) {
            $table->boolean('influencer_status')->default(0);
            $table->boolean('admin_status')->default(0);
            $table->longText('link')->nullable();
            $table->boolean('is_completed')->default(0);
            $table->longText('rejectNote')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('influencer_status');
            $table->dropColumn('admin_status');
            $table->dropColumn('link');
            $table->dropColumn('is_completed');
            $table->dropColumn('rejectNote');
        });
    }
};
