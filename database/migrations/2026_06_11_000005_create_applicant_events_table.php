<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantEventsTable extends Migration
{
    public function up()
    {
        Schema::create('applicant_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_apply_id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('company_id');
            $table->string('type', 32);
            $table->string('label', 64);
            $table->json('meta')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['job_apply_id', 'created_at']);
            $table->index(['job_id', 'company_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_events');
    }
}
