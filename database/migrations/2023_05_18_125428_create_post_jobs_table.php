<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('post_jobs', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('job_title',256)->nullable();
        //     $table->string('industry',100)->nullable();
        //     $table->string('job_type',10)->nullable();
        //     $table->text('job_skills',256)->nullable();
        //     $table->bigInteger('min_salary')->nullable();
        //     $table->bigInteger('max_salary')->nullable();
        //     $table->string('experience')->nullable();
        //     $table->integer('no_of_openings')->nullable();
        //     $table->string('location')->nullable();
        //     $table->longText('job_description')->nullable();
        //     $table->longText('job_overview')->nullable();
        //     $table->longText('roles_responsibility')->nullable();                                                             
        //     $table->unsignedBigInteger('company_id');
        //     $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_jobs');
    }
}
