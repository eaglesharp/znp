<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPipelineColumnsToJobApply extends Migration
{
    public function up()
    {
        Schema::table('job_apply', function (Blueprint $table) {
            $table->string('stage', 32)->nullable()->after('job_id');
            $table->string('offer_status', 32)->nullable()->after('stage');
            $table->string('rejected_reason', 128)->nullable()->after('offer_status');
            $table->text('rejected_note')->nullable()->after('rejected_reason');
            $table->timestamp('rejected_at')->nullable()->after('rejected_note');
            $table->timestamp('reported_at')->nullable()->after('rejected_at');
            $table->timestamp('last_viewed_at')->nullable()->after('reported_at');
        });
    }

    public function down()
    {
        Schema::table('job_apply', function (Blueprint $table) {
            $table->dropColumn([
                'stage',
                'offer_status',
                'rejected_reason',
                'rejected_note',
                'rejected_at',
                'reported_at',
                'last_viewed_at',
            ]);
        });
    }
}
