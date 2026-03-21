<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewToProfileDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_details', function (Blueprint $table) {
         
            $table->string('expecting_opportunities')->nullable();
            $table->string('expecting_payment')->nullable();
            $table->date('video_date_from')->nullable();
            $table->date('video_date_to')->nullable();
            $table->string('video_time')->nullable();
            $table->string('work_option')->nullable();
            $table->string('night_time')->nullable();
            $table->string('expect_ctc_lakhs')->nullable();
            $table->string('expect_ctc_thousand')->nullable();
            $table->string('expect_ctc_lakhs1')->nullable();
            $table->string('expect_ctc_thousand1')->nullable();
            $table->string('expect_ctc_lakhs2')->nullable();
            $table->string('expect_ctc_thousand2')->nullable();
            $table->string('expect_ctc_lakhs3')->nullable();
            $table->string('expect_ctc_thousand3')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile_details', function (Blueprint $table) {
            //
        });
    }
}
