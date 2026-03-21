<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRolesToProfileProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_projects', function (Blueprint $table) {
            $table->string('role_in_project')->nullable();
            $table->string('client')->nullable();
            $table->string('domain')->nullable();
            $table->string('duration')->nullable();
            $table->string('project_type')->nullable();
            $table->string('tech_used')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile_projects', function (Blueprint $table) {
            //
        });
    }
}
