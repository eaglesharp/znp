<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProcessToProfileSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_summaries', function (Blueprint $table) {
            $table->string('latestcom')->nullable();
            $table->string('latestdesg')->nullable();
            $table->string('currentshift')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile_summaries', function (Blueprint $table) {
            //
        });
    }
}
