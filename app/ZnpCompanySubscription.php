<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Per-company subscription row. The "currently active" subscription for an
 * employer is the most recent row with:
 *   - status = 'active'
 *   - expires_at IS NULL or > now()
 *
 * Quota is tracked here via posts_used / posts_limit (posts_limit = 0 means
 * unlimited, used for Enterprise/Pro). The Company model has thin helpers
 * (`activeZnpSubscription`, `canPostJob`, `consumeOnePost`) that wrap this.
 */
class ZnpCompanySubscription extends Model
{
    protected $table = 'znp_company_subscriptions';

    protected $guarded = ['id'];

    protected $dates = ['starts_at', 'expires_at', 'created_at', 'updated_at'];

    protected $casts = [
        'posts_limit'      => 'integer',
        'posts_used'       => 'integer',
        'validity_days'    => 'integer',
        'post_active_days' => 'integer',
        'amount_paid'      => 'decimal:2',
    ];

    /* ── Relationships ── */

    public function plan()
    {
        return $this->belongsTo(ZnpPricingPlan::class, 'plan_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /* ── Scopes ── */

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', Carbon::now());
            });
    }

    /* ── Computed helpers ── */

    public function isUnlimited(): bool
    {
        return (int) $this->posts_limit === 0;
    }

    public function postsRemaining(): int
    {
        if ($this->isUnlimited()) {
            return PHP_INT_MAX;
        }
        return max(0, (int) $this->posts_limit - (int) $this->posts_used);
    }

    public function hasQuotaLeft(): bool
    {
        return $this->isUnlimited() || $this->postsRemaining() > 0;
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->lt(Carbon::now());
    }

    public function isLive(): bool
    {
        return $this->status === 'active' && ! $this->isExpired();
    }
}
