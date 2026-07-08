<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the fields required by the new ZNP "Post a Job" page (znp.post-job).
 *
 * - Adds Section 1 (Job Basics) extensions to post_jobs.
 * - Adds Sections 4 / 5 / 6 / 7 (awards, perks, questionnaire, profile reqs)
 *   to post_jobs AND mirrors the auto-saved bits on companies, so that the
 *   employer's last-used values pre-fill on the next job creation.
 *
 * Uses `Schema::hasColumn` guards because both tables were originally created
 * via raw SQL and we do not want to fail re-runs on existing installs.
 */
class AddZnpPostJobFields extends Migration
{
    public function up()
    {
        Schema::table('post_jobs', function (Blueprint $table) {
            /* ── Section 1 — Job Basics ── */
            if (! Schema::hasColumn('post_jobs', 'contract_day_rate')) {
                $table->decimal('contract_day_rate', 12, 2)->nullable()->after('duration');
            }
            if (! Schema::hasColumn('post_jobs', 'contract_extension')) {
                $table->string('contract_extension', 32)->nullable()->after('contract_day_rate');
            }
            if (! Schema::hasColumn('post_jobs', 'compensation_confidential')) {
                $table->boolean('compensation_confidential')->default(0)->after('max_salary');
            }
            if (! Schema::hasColumn('post_jobs', 'exp_min')) {
                $table->decimal('exp_min', 5, 2)->nullable()->after('experience');
            }
            if (! Schema::hasColumn('post_jobs', 'exp_max')) {
                $table->decimal('exp_max', 5, 2)->nullable()->after('exp_min');
            }
            if (! Schema::hasColumn('post_jobs', 'primary_language')) {
                $table->string('primary_language', 64)->nullable()->after('exp_max');
            }
            if (! Schema::hasColumn('post_jobs', 'posting_type')) {
                $table->string('posting_type', 16)->nullable()->after('primary_language');
            }
            if (! Schema::hasColumn('post_jobs', 'client_name')) {
                $table->string('client_name', 191)->nullable()->after('posting_type');
            }
            if (! Schema::hasColumn('post_jobs', 'client_industry')) {
                $table->string('client_industry', 191)->nullable()->after('client_name');
            }
            if (! Schema::hasColumn('post_jobs', 'locality')) {
                $table->string('locality', 191)->nullable()->after('client_industry');
            }

            /* ── Section 3 snapshot (auto-saved values copied onto each job) ── */
            if (! Schema::hasColumn('post_jobs', 'about_company')) {
                $table->longText('about_company')->nullable()->after('locality');
            }
            if (! Schema::hasColumn('post_jobs', 'industry')) {
                $table->string('industry', 191)->nullable()->after('about_company');
            }
            if (! Schema::hasColumn('post_jobs', 'headcount')) {
                $table->string('headcount', 32)->nullable()->after('industry');
            }
            if (! Schema::hasColumn('post_jobs', 'office_address')) {
                $table->text('office_address')->nullable()->after('headcount');
            }
            if (! Schema::hasColumn('post_jobs', 'countries_presence')) {
                $table->json('countries_presence')->nullable()->after('office_address');
            }

            /* ── Section 4 / 5 / 6 / 7 ── */
            if (! Schema::hasColumn('post_jobs', 'awards')) {
                $table->json('awards')->nullable();
            }
            if (! Schema::hasColumn('post_jobs', 'perks')) {
                $table->json('perks')->nullable();
            }
            if (! Schema::hasColumn('post_jobs', 'questionnaire')) {
                $table->json('questionnaire')->nullable();
            }
            if (! Schema::hasColumn('post_jobs', 'profile_requirements')) {
                $table->json('profile_requirements')->nullable();
            }
            if (! Schema::hasColumn('post_jobs', 'strict_mode')) {
                $table->boolean('strict_mode')->default(0);
            }
            if (! Schema::hasColumn('post_jobs', 'is_draft')) {
                $table->boolean('is_draft')->default(0);
            }
        });

        Schema::table('companies', function (Blueprint $table) {
            /* Auto-saved on the company so each new post pre-fills. */
            if (! Schema::hasColumn('companies', 'office_address')) {
                $table->text('office_address')->nullable();
            }
            if (! Schema::hasColumn('companies', 'countries_presence')) {
                $table->json('countries_presence')->nullable();
            }
            if (! Schema::hasColumn('companies', 'awards')) {
                $table->json('awards')->nullable();
            }
            if (! Schema::hasColumn('companies', 'perks')) {
                $table->json('perks')->nullable();
            }
            if (! Schema::hasColumn('companies', 'headcount')) {
                $table->string('headcount', 32)->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('post_jobs', function (Blueprint $table) {
            $cols = [
                'contract_day_rate', 'contract_extension', 'compensation_confidential',
                'exp_min', 'exp_max', 'primary_language', 'posting_type',
                'client_name', 'client_industry', 'locality',
                'about_company', 'industry', 'headcount', 'office_address', 'countries_presence',
                'awards', 'perks', 'questionnaire', 'profile_requirements',
                'strict_mode', 'is_draft',
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('post_jobs', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('companies', function (Blueprint $table) {
            $cols = ['office_address', 'countries_presence', 'awards', 'perks', 'headcount'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('companies', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}
