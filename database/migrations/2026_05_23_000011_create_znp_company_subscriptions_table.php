<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-company subscription record for the new ZNP pricing system.
 *
 * One company can have many rows here (history). The "currently active" plan
 * for an employer is the most recent row with status='active' AND expires_at
 * in the future — this is what gates job posting.
 *
 * Snapshot pattern: we copy plan_name / posts_limit / etc. onto the row at
 * assignment time so editing a plan in znp_pricing_plans later does NOT alter
 * the quota the employer already paid for.
 *
 * Assignment sources:
 *   - 'admin_manual' → assigned via /admin/edit-company/{id} (current default
 *     until Razorpay is integrated; no payment captured)
 *   - 'razorpay'     → set by future Razorpay webhook
 *   - 'stripe'       → set by future Stripe webhook
 *   - 'system'       → trial / grant / migration
 */
class CreateZnpCompanySubscriptionsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('znp_company_subscriptions')) {
            return;
        }

        Schema::create('znp_company_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('plan_id')->nullable();

            /* Snapshot fields (immutable once written). */
            $table->string('plan_slug', 64);
            $table->string('plan_name', 120);
            $table->unsignedInteger('posts_limit')->default(0);   /* 0 = unlimited */
            $table->unsignedInteger('posts_used')->default(0);
            $table->unsignedInteger('validity_days')->default(30);
            $table->unsignedInteger('post_active_days')->default(30);

            /* Lifecycle. */
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('status', 16)->default('active');      /* active | expired | cancelled */

            /* Money trail (kept even for manual grants for future audit). */
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->char('currency', 3)->default('INR');
            $table->string('assignment_source', 32)->default('admin_manual');
            $table->string('payment_ref', 191)->nullable();        /* razorpay payment_id, stripe charge id, … */
            $table->unsignedBigInteger('assigned_by_admin_id')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'expires_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('znp_company_subscriptions');
    }
}
