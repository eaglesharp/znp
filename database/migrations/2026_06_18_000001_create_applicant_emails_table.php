<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantEmailsTable extends Migration
{
    public function up()
    {
        Schema::create('applicant_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_apply_id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('user_id');
            $table->string('recipient_email')->nullable();
            $table->string('subject');
            $table->longText('body');
            $table->unsignedBigInteger('template_id')->nullable();
            $table->string('send_scope', 32)->default('single');
            $table->string('status', 32)->default('sent');
            $table->text('error')->nullable();
            $table->timestamps();

            $table->index(['job_apply_id']);
            $table->index(['job_id', 'company_id']);
            $table->index(['status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_emails');
    }
}
