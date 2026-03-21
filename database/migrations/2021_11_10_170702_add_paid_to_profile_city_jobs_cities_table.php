<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToProfileCityJobsCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_city_jobs_cities', function (Blueprint $table) {
            
            $table->string('current_city')->nullable();
            $table->string('prefered_city')->nullable();
            $table->string('current_location')->nullable();
            $table->string('prefered_location')->nullable();
            $table->string('prefered_job')->nullable();
            
            
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
