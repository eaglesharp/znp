<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewToProfileCityJobsCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_city_jobs_cities', function (Blueprint $table) {
            $table->string('current_start_date')->nullable();
            $table->string('current_till_date')->nullable();
            $table->string('current_work_type')->nullable();
            $table->string('current_project_details')->nullable();
            $table->string('current_ctc_start')->nullable();
            $table->string('current_ctc_end')->nullable();
            $table->string('previous_start_date')->nullable();
            $table->string('previous_till_date')->nullable();
            $table->string('previous_work_type')->nullable();
            $table->string('previous_project_details')->nullable();
            $table->string('previous_ctc_start')->nullable();
            $table->string('previous_ctc_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile_city_jobs_cities', function (Blueprint $table) {
            //
        });
    }
}
