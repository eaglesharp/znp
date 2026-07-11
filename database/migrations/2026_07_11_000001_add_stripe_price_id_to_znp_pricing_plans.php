<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStripePriceIdToZnpPricingPlans extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('znp_pricing_plans')) {
            return;
        }

        Schema::table('znp_pricing_plans', function (Blueprint $table) {
            if (! Schema::hasColumn('znp_pricing_plans', 'stripe_price_id')) {
                $table->string('stripe_price_id', 191)->nullable()->after('currency');
            }
        });
    }

    public function down()
    {
        if (! Schema::hasTable('znp_pricing_plans')) {
            return;
        }

        Schema::table('znp_pricing_plans', function (Blueprint $table) {
            if (Schema::hasColumn('znp_pricing_plans', 'stripe_price_id')) {
                $table->dropColumn('stripe_price_id');
            }
        });
    }
}
