<?php

namespace App\Http\Controllers;

use App\Company;
use App\Services\ZnpSubscriptionService;
use App\ZnpCompanySubscription;
use App\ZnpPricingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session as LaravelSession;
use Stripe\Checkout\Session as StripeCheckoutSession;
use Stripe\Stripe;

class ZnpStripeCheckoutController extends Controller
{
    protected ZnpSubscriptionService $subscriptions;

    public function __construct(ZnpSubscriptionService $subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }

    /**
     * Start Stripe Checkout for a ZNP pricing plan.
     */
    public function checkout(Request $request, string $slug)
    {
        if (! Auth::guard('company')->check()) {
            return redirect()
                ->guest(route('employer.znp.checkout', $slug))
                ->with('error', 'Please log in as an employer to purchase a plan.');
        }

        $plan = ZnpPricingPlan::active()->where('slug', $slug)->firstOrFail();

        if (! $plan->isPurchasableOnline()) {
            return redirect($plan->checkoutUrl());
        }

        $company = Auth::guard('company')->user();
        $secret  = $this->stripeSecret();

        if (! $secret) {
            Log::error('ZNP Stripe checkout: missing stripe secret key');

            return redirect()
                ->route('employer.job.pricing')
                ->with('error', 'Payment is temporarily unavailable. Please try again later.');
        }

        Stripe::setApiKey($secret);

        $lineItem = $this->buildLineItem($plan);
        $total    = $plan->totalWithGst();

        try {
            $session = StripeCheckoutSession::create([
                'payment_method_types' => ['card'],
                'mode'                 => 'payment',
                'line_items'           => [$lineItem],
                'success_url'          => route('employer.znp.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'           => route('employer.job.pricing'),
                'customer_email'       => $company->email,
                'metadata'             => [
                    'company_id' => (string) $company->id,
                    'plan_id'    => (string) $plan->id,
                    'plan_slug'  => $plan->slug,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('ZNP Stripe checkout session failed', [
                'company_id' => $company->id,
                'plan_slug'  => $plan->slug,
                'error'      => $e->getMessage(),
            ]);

            return redirect()
                ->route('employer.job.pricing')
                ->with('error', 'Could not start payment. Please try again.');
        }

        return redirect()->away($session->url);
    }

    /**
     * Stripe redirects here after successful payment.
     */
    public function success(Request $request)
    {
        if (! Auth::guard('company')->check()) {
            return redirect()
                ->route('employer.login')
                ->with('error', 'Please log in to complete your purchase.');
        }

        $sessionId = $request->query('session_id');
        if (! $sessionId) {
            return redirect()
                ->route('employer.job.pricing')
                ->with('error', 'Invalid payment session.');
        }

        $company = Auth::guard('company')->user();
        $secret  = $this->stripeSecret();

        if (! $secret) {
            return redirect()
                ->route('employer.job.pricing')
                ->with('error', 'Payment verification failed. Please contact support.');
        }

        Stripe::setApiKey($secret);

        try {
            $session = StripeCheckoutSession::retrieve($sessionId);
        } catch (\Throwable $e) {
            Log::error('ZNP Stripe session retrieve failed', [
                'session_id' => $sessionId,
                'error'      => $e->getMessage(),
            ]);

            return redirect()
                ->route('employer.job.pricing')
                ->with('error', 'Could not verify payment. Please contact support.');
        }

        if ($session->payment_status !== 'paid') {
            return redirect()
                ->route('employer.job.pricing')
                ->with('error', 'Payment was not completed.');
        }

        $metaCompanyId = (int) ($session->metadata['company_id'] ?? 0);
        if ($metaCompanyId !== (int) $company->id) {
            return redirect()
                ->route('employer.dashboard')
                ->with('error', 'Payment session does not match your account.');
        }

        $existing = ZnpCompanySubscription::where('payment_ref', $session->id)->first();
        if ($existing) {
            LaravelSession::put('employer_plan_payment', 'Employer Payment success');

            return redirect()->route('employer.dashboard')
                ->with('success', 'Your plan is already active.');
        }

        $planId = (int) ($session->metadata['plan_id'] ?? 0);
        $plan   = ZnpPricingPlan::find($planId);

        if (! $plan) {
            Log::error('ZNP Stripe success: plan not found', [
                'session_id' => $sessionId,
                'plan_id'    => $planId,
            ]);

            return redirect()
                ->route('employer.job.pricing')
                ->with('error', 'Plan could not be activated. Please contact support.');
        }

        $amountPaid = $session->amount_total ? round($session->amount_total / 100, 2) : $plan->totalWithGst();

        $this->subscriptions->grantPlan(
            $company,
            $plan,
            'stripe',
            $session->id,
            $amountPaid,
            null,
            'Stripe Checkout session ' . $session->id
        );

        LaravelSession::put('employer_plan_payment', 'Employer Payment success');

        return redirect()->route('employer.dashboard')
            ->with('success', 'Payment successful! Your ' . $plan->name . ' plan is now active.');
    }

    protected function stripeSecret(): ?string
    {
        return Config::get('stripe.stripe_secret') ?: config('services.stripe.secret');
    }

    protected function buildLineItem(ZnpPricingPlan $plan): array
    {
        $priceId = $plan->resolveStripePriceId();

        if ($priceId) {
            return [
                'price'    => $priceId,
                'quantity' => 1,
            ];
        }

        $total = $plan->totalWithGst();

        return [
            'price_data' => [
                'currency'     => strtolower($plan->currency ?: 'inr'),
                'unit_amount'  => (int) round($total * 100),
                'product_data' => [
                    'name'        => $plan->name . ' — ZeroNoticePeriod',
                    'description' => $plan->description ?: ($plan->name . ' employer plan'),
                ],
            ],
            'quantity' => 1,
        ];
    }
}
