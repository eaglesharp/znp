<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddV2SignupFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Note: this project has historical migrations; use hasColumn guards
            // in case columns already exist in a given environment.
            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('users', 'industry_domain')) {
                $table->string('industry_domain')->nullable()->after('mode_of_separation');
            }
            if (!Schema::hasColumn('users', 'hide_cv_from_current_employer')) {
                $table->boolean('hide_cv_from_current_employer')->default(1)->after('industry_domain');
            }
            if (!Schema::hasColumn('users', 'accuracy_confirmed')) {
                $table->boolean('accuracy_confirmed')->default(0)->after('hide_cv_from_current_employer');
            }
            if (!Schema::hasColumn('users', 'pref_job_alerts')) {
                $table->boolean('pref_job_alerts')->default(1)->after('accuracy_confirmed');
            }
            if (!Schema::hasColumn('users', 'pref_platform_tips')) {
                $table->boolean('pref_platform_tips')->default(1)->after('pref_job_alerts');
            }
            if (!Schema::hasColumn('users', 'pref_promotions')) {
                $table->boolean('pref_promotions')->default(1)->after('pref_platform_tips');
            }
            if (!Schema::hasColumn('users', 'terms_accepted_at')) {
                $table->timestamp('terms_accepted_at')->nullable()->after('pref_promotions');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $cols = [
                'date_of_birth',
                'industry_domain',
                'hide_cv_from_current_employer',
                'accuracy_confirmed',
                'pref_job_alerts',
                'pref_platform_tips',
                'pref_promotions',
                'terms_accepted_at',
            ];
            foreach ($cols as $c) {
                if (Schema::hasColumn('users', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
}

