<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSkillsToProfileSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_skills', function (Blueprint $table) {
            $table->string('project_title')->nullable();
            $table->string('version')->nullable();
            $table->string('no_of_projects')->nullable();
            $table->string('last_used_year')->nullable();
            $table->string('job_experience')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile_skills', function (Blueprint $table) {
            //
        });
    }
}
