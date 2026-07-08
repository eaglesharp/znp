<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::create('applicant_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_apply_id');
            $table->unsignedBigInteger('company_id');
            $table->string('verdict', 8);
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->index(['job_apply_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_feedbacks');
    }
}
