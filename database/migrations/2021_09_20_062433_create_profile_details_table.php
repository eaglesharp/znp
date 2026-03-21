<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('shifts')->nullable();
            $table->string('work_type')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('case_of_contract')->nullable();
            $table->string('duration_contract')->nullable();
            $table->string('contract_company')->nullable();
            $table->string('pay_contract')->nullable();
            $table->string('candidate_wfh')->nullable();
            
            $table->date('telephonic_date_from')->nullable();
            $table->date('telephonic_date_to')->nullable();
            $table->string('telephonic_time_from')->nullable();
            $table->string('telephonic_time_to')->nullable();

            $table->string('video_time_from')->nullable();
            $table->string('video_time_to')->nullable();
            $table->string('night_interview')->nullable();
            $table->date('night_telephonic_date_from')->nullable();
            $table->date('night_telephonic_date_to')->nullable();
            $table->string('night_telephonic_time_form')->nullable();
            $table->string('night_telephonic_time_to')->nullable();

            $table->string('night_video_time_from')->nullable();
            $table->string('night_video_time_to')->nullable();
            $table->string('bgv_name1')->nullable();
            $table->string('bgv_email1')->nullable();
            $table->string('bgv_mobile1')->nullable();
            $table->string('bgv_name2')->nullable();
            $table->string('bgv_email2')->nullable();
            $table->string('bgv_mobile2')->nullable();

            $table->string('pricing_details')->nullable();
            $table->string('pricing_type')->nullable();
            $table->string('visa_country')->nullable();
            $table->string('visa_validity')->nullable();
            $table->string('wfo')->nullable();
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
        Schema::dropIfExists('profile_details');
    }
}
