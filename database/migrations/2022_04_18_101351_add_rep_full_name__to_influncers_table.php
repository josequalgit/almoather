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
            $table->dropColumn('rep_full_name');
            $table->string('rep_first_name')->nullable();
            $table->string('rep_middle_name')->nullable();
            $table->string('rep_last_name')->nullable();

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
            $table->string('rep_full_name');
            $table->dropColumn('rep_first_name');
            $table->dropColumn('rep_middle_name');
            $table->dropColumn('rep_last_name');
        });
    }
};
