<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantNotesTable extends Migration
{
    public function up()
    {
        Schema::create('applicant_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_apply_id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('user_id');
            $table->text('body');
            $table->timestamps();

            $table->index(['job_apply_id']);
            $table->index(['job_id', 'company_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_notes');
    }
}
