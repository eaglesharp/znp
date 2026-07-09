<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateZnpPricingPlanCtaUrls extends Migration
{
    public function up()
    {
        if (!\Schema::hasTable('znp_pricing_plans')) {
            return;
        }

        DB::table('znp_pricing_plans')
            ->where('cta_url', '/post-job-page')
            ->update(['cta_url' => '/post-job']);
    }

    public function down()
    {
        if (!\Schema::hasTable('znp_pricing_plans')) {
            return;
        }

        DB::table('znp_pricing_plans')
            ->where('cta_url', '/post-job')
            ->update(['cta_url' => '/post-job-page']);
    }
}
