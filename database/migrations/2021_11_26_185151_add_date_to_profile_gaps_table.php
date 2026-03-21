<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateToProfileGapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_gaps', function (Blueprint $table) {
            $table->string('gap_from_year')->nullable();
            $table->string('gap_from_month')->nullable();
            $table->string('gap_to_year')->nullable();
            $table->string('gap_to_month')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile_gaps', function (Blueprint $table) {
            //
        });
    }
}
