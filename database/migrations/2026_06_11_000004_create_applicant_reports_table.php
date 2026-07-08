<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantReportsTable extends Migration
{
    public function up()
    {
        Schema::create('applicant_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_apply_id');
            $table->unsignedBigInteger('company_id');
            $table->string('reason', 128);
            $table->text('details')->nullable();
            $table->string('status', 32)->default('open');
            $table->timestamps();

            $table->index(['job_apply_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_reports');
    }
}
