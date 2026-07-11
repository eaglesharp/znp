<?php

namespace App\Services;

use App\Company;
use App\ZnpCompanySubscription;
use App\ZnpPricingPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ZnpSubscriptionService
{
    /**
     * Cancel any active subscription and grant a fresh one from the plan catalogue.
     */
    public function grantPlan(
        Company $company,
        ZnpPricingPlan $plan,
        string $assignmentSource = 'admin_manual',
        ?string $paymentRef = null,
        float $amountPaid = 0,
        ?int $adminId = null,
        ?string $notes = null
    ): ZnpCompanySubscription {
        ZnpCompanySubscription::where('company_id', $company->id)
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        $now = Carbon::now();

        if ($adminId === null && Auth::guard('admin')->check()) {
            $adminId = (int) Auth::guard('admin')->user()->id;
        }

        return ZnpCompanySubscription::create([
            'company_id'           => $company->id,
            'plan_id'              => $plan->id,
            'plan_slug'            => $plan->slug,
            'plan_name'            => $plan->name,
            'posts_limit'          => (int) $plan->job_posts_limit,
            'posts_used'           => 0,
            'validity_days'        => (int) $plan->validity_days,
            'post_active_days'     => (int) $plan->post_active_days,
            'starts_at'            => $now,
            'expires_at'           => $now->copy()->addDays((int) $plan->validity_days),
            'status'               => 'active',
            'amount_paid'          => $amountPaid,
            'currency'             => $plan->currency ?: 'INR',
            'assignment_source'    => $assignmentSource,
            'payment_ref'          => $paymentRef,
            'assigned_by_admin_id' => $adminId,
            'notes'                => $notes,
        ]);
    }
}
