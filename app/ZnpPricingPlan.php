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
}
