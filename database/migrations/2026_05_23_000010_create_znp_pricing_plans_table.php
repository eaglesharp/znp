<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ZNP job-posting pricing catalogue.
 *
 * Each row drives one card on the public pricing page (resources/views/znp/job-pricing.blade.php)
 * AND backs the plan dropdown on /admin/edit-company/{id} (until Razorpay is live).
 *
 * Everything user-tunable (price, post quota, validity window, GST %, CTA copy)
 * lives on this row — no need to redeploy to change a price.
 *
 * Convention: rows are managed directly from the DB for now (or via a small
 * internal page later). They are NEVER hard-deleted by the application — the
 * `is_active` flag toggles visibility on the public pricing page.
 */
class CreateZnpPricingPlansTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('znp_pricing_plans')) {
            return;
        }

        Schema::create('znp_pricing_plans', function (Blueprint $table) {
            $table->bigIncrements('id');

            /* Stable machine name used in code (e.g. 'quick_job', 'flex', 'pro'). */
            $table->string('slug', 64)->unique();

            /* Display copy (matches HTML on job-pricing.blade.php). */
            $table->string('name', 120);                  /* e.g. "Quick Job" */
            $table->string('tag_label', 64)->nullable();  /* e.g. "Single Job", "Enterprise" */
            $table->text('description')->nullable();      /* short blurb under the name */

            /* Pricing. price=0 with is_custom_price=1 means "Custom" / Talk to sales. */
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('original_price', 12, 2)->nullable(); /* shown crossed-out */
            $table->boolean('is_custom_price')->default(0);
            $table->decimal('gst_percent', 5, 2)->default(18.00);
            $table->char('currency', 3)->default('INR');

            /* Quota & validity (the two things that matter for posting). */
            $table->unsignedInteger('job_posts_limit')->default(1);   /* 0 = unlimited */
            $table->unsignedInteger('validity_days')->default(30);    /* purchase window */
            $table->unsignedInteger('post_active_days')->default(30); /* each post lifespan */

            /* Card display flags. */
            $table->boolean('is_featured')->default(0);   /* shows the "Most Popular" pill */
            $table->string('variant', 16)->default('default'); /* default | featured | enterprise */

            /* CTA on the public pricing card. */
            $table->string('cta_label', 64)->default('Get Started');
            $table->string('cta_url', 255)->nullable();   /* relative path or full URL */

            /* JSON array of feature rows for the card.
               Shape: [ {label: "...", note: "...", included: true}, ... ] */
            $table->json('highlights')->nullable();

            /* Optional per-card metric copy (kept on the row so DB edits update UI). */
            $table->string('price_subtext', 191)->nullable();  /* e.g. "per job post · …" */
            $table->string('billing_note', 191)->nullable();   /* e.g. "Billed monthly — …" */

            $table->boolean('is_active')->default(1);
            $table->unsignedInteger('display_order')->default(0);

            $table->timestamps();

            $table->index(['is_active', 'display_order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('znp_pricing_plans');
    }
}
