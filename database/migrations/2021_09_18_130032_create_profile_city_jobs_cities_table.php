<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileCityJobsCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_city_jobs_cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('current_ctc')->nullable();
            $table->string('expect_ctc')->nullable();
            $table->string('current_company')->nullable();
         
            $table->string('current_industry')->nullable();
            $table->string('current_desigination')->nullable();
            $table->string('current_reason')->nullable();
            $table->text('current_responsibilities')->nullable();
            $table->string('current_salary_revision')->nullable();
            $table->string('previous_company')->nullable();
        
            $table->string('previous_industry')->nullable();
            $table->string('previous_desigination')->nullable();
            $table->string('previous_reason')->nullable();
            $table->text('previous_responsibilities')->nullable();
            $table->string('previous_salary_revision')->nullable();
            $table->string('preferred_job')->nullable();
          
            $table->integer('other_offers')->nullable();
            $table->integer('no_offers')->nullable();
        
            $table->string('ctc_offer_1')->nullable();
            $table->date('date_of_join_1')->nullable();
            $table->string('job_location1')->nullable();
            $table->string('ctc_offer_2')->nullable();
            $table->date('date_of_join_2')->nullable();
            $table->string('job_location2')->nullable();
            $table->string('ctc_offer_3')->nullable();
            $table->date('date_of_join_3')->nullable();
            $table->string('job_location3')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_city_jobs_cities');
    }
}
