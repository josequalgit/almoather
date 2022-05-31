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
        Schema::table('influncers', function (Blueprint $table) {
            // $table->dropColumn('bank_account_name');
            // $table->string('bank_account_first_name')->nullable();
            // $table->string('bank_account_middle_name')->nullable();
            // $table->string('bank_account_last_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('influncers', function (Blueprint $table) {
            $table->dropColumn('bank_account_first_name');
            $table->dropColumn('bank_account_middle_name');
            $table->dropColumn('bank_account_last_name');
        });
    }
};
