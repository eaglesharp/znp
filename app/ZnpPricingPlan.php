<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Catalogue row that drives one card on the public ZNP pricing page and is
 * referenced by per-company subscriptions in `znp_company_subscriptions`.
 *
 * Source of truth for: price, post quota, validity window, GST %, CTA copy.
 * Until the admin UI is built, rows are edited directly via DB / Tinker.
 */
class ZnpPricingPlan extends Model
{
    protected $table = 'znp_pricing_plans';

    protected $guarded = ['id'];

    protected $casts = [
        'price'             => 'decimal:2',
        'original_price'    => 'decimal:2',
        'gst_percent'       => 'decimal:2',
        'is_custom_price'   => 'boolean',
        'is_featured'       => 'boolean',
        'is_active'         => 'boolean',
        'job_posts_limit'   => 'integer',
        'validity_days'     => 'integer',
        'post_active_days'  => 'integer',
        'display_order'     => 'integer',
        'highlights'        => 'array',
    ];

    /* ── Scopes ── */

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('id');
    }

    /* ── Display helpers (used by job-pricing blade) ── */

    /**
     * Pretty-formatted price for the card (e.g. "2,999" or "25,000"),
     * or the literal "Custom" tag for is_custom_price plans.
     */
    public function getDisplayPriceAttribute(): string
    {
        if ($this->is_custom_price) {
            return 'Custom';
        }
        return number_format((float) $this->price, 0, '.', ',');
    }

    public function getDisplayOriginalPriceAttribute(): ?string
    {
        if (! $this->original_price || (float) $this->original_price <= (float) $this->price) {
            return null;
        }
        return '₹' . number_format((float) $this->original_price, 0, '.', ',');
    }

    public function getDisplaySaveAmountAttribute(): ?string
    {
        if (! $this->original_price || (float) $this->original_price <= (float) $this->price) {
            return null;
        }
        $diff = (float) $this->original_price - (float) $this->price;
        return '₹' . number_format($diff, 0, '.', ',');
    }

    /** GST-inclusive total in major currency units (e.g. INR rupees). */
    public function totalWithGst(): float
    {
        $base = (float) $this->price;
        $gst  = $base * (float) $this->gst_percent / 100;

        return round($base + $gst, 2);
    }

    /** Stripe Price ID from DB column or config/env fallback. */
    public function resolveStripePriceId(): ?string
    {
        if ($this->stripe_price_id) {
            return $this->stripe_price_id;
        }

        return config("znp.stripe_prices.{$this->slug}") ?: null;
    }

    /** Whether this plan can be purchased online (not custom / talk-to-sales). */
    public function isPurchasableOnline(): bool
    {
        return ! $this->is_custom_price && (float) $this->price > 0;
    }

    /** Checkout URL for paid plans; falls back to cta_url for enterprise. */
    public function checkoutUrl(): string
    {
        if ($this->isPurchasableOnline()) {
            return route('employer.znp.checkout', $this->slug);
        }

        $cta = $this->cta_url ?: 'contact-us';

        return preg_match('#^https?://#', $cta) ? $cta : url($cta);
    }
}
