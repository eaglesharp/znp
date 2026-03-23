<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJobStatsToCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counters', function (Blueprint $table) {
            $table->unsignedInteger('active_jobs')->default(0)->after('counter1');
            $table->unsignedInteger('permanent_jobs')->default(0)->after('active_jobs');
            $table->unsignedInteger('contract_jobs')->default(0)->after('permanent_jobs');
            $table->unsignedInteger('fresher_jobs')->default(0)->after('contract_jobs');
        });
    }

    public function down()
    {
        Schema::table('counters', function (Blueprint $table) {
            $table->dropColumn(['active_jobs', 'permanent_jobs', 'contract_jobs', 'fresher_jobs']);
        });
    }
}
