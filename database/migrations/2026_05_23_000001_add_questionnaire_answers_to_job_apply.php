<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Stores the answers each candidate submits to the per-job Mandatory
 * Questionnaire (defined in post_jobs.questionnaire). The blob captures
 * the question label + type alongside the answer so the employer dashboard
 * can render Q&A pairs without needing to re-resolve the original job
 * questionnaire (which may have been edited since the application).
 */
class AddQuestionnaireAnswersToJobApply extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('job_apply', 'questionnaire_answers')) {
            Schema::table('job_apply', function (Blueprint $table) {
                $table->longText('questionnaire_answers')->nullable()->after('coverletter');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('job_apply', 'questionnaire_answers')) {
            Schema::table('job_apply', function (Blueprint $table) {
                $table->dropColumn('questionnaire_answers');
            });
        }
    }
}
