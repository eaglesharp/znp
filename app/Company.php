<?php



namespace App;



use Auth;

use App;

use Carbon\Carbon;

use App\Traits\Active;

use App\Traits\Featured;

use App\Traits\JobTrait;

use App\Traits\CountryStateCity;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;

use App\Notifications\CompanyResetPassword;

use Illuminate\Foundation\Auth\User as Authenticatable;



class Company extends Authenticatable

{



    use Active;

    use Featured;

    use Notifiable;

    use JobTrait;

    use CountryStateCity;



    protected $table = 'companies';

    public $timestamps = true;

    protected $guarded = ['id'];

    //protected $dateFormat = 'U';

    protected $dates = ['created_at', 'updated_at', 'package_start_date', 'package_end_date'];

    protected $fillable = [

        'name', 'email', 'password','designation','email_verified','no_of_downloads'

    ];

    protected $hidden = [

        'password', 'remember_token',

    ];



    public function sendPasswordResetNotification($token)

    {

        $this->notify(new CompanyResetPassword($token));

    }



    public function printCompanyImage($width = 0, $height = 0)

    {

        $logo = (string)$this->logo;

        $logo = (null!==($logo)) ? $logo : 'no-no-image.gif';
        return \ImgUploader::print_image("company_logos/$logo", $width, $height, '/admin_assets/no-image.png', $this->name);

    }



    public function jobs()

    {

        return $this->hasMany('App\PostJob', 'company_id', 'id');

    }

    public function kycdocuments()

    {

        return $this->hasMany('App\KYC', 'company_id', 'id');

    }




    public function openJobs()

    {

        return PostJob::where('company_id', '=', $this->id)->notExpire();

    }



    public function getOpenJobs()

    {

        return $this->openJobs()->get();

    }



    public function countOpenJobs()

    {

        return $this->openJobs()->count();

    }



    public function industry()

    {

        return $this->belongsTo('App\Industry', 'industry_id', 'id');

    }



    public function getIndustry($field = '')

    {

        $industry = $this->industry()->lang()->first();

        if (null === $industry) {

            $industry = $this->industry()->first();

        }

        if (null !== $industry) {

            if (!empty($field)) {

                return $industry->$field;

            } else {

                return $industry;

            }

        }

    }



    public function ownershipType()

    {

        return $this->belongsTo('App\OwnershipType', 'ownership_type_id', 'id');

    }



    public function getOwnershipType($field = '')

    {

        $ownershipType = $this->ownershipType()->lang()->first();

        if (null === $ownershipType) {

            $ownershipType = $this->ownershipType()->first();

        }

        if (null !== $ownershipType) {

            if (!empty($field)) {

                return $ownershipType->$field;

            } else {

                return $ownershipType;

            }

        }

    }



    public function countFollowers()

    {

        return FavouriteCompany::where('company_slug', 'like', $this->slug)->count();

    }



    public function getFollowerIdsArray()

    {

        return FavouriteCompany::where('company_slug', 'like', $this->slug)->pluck('user_id')->toArray();

    }



    public function countCompanyMessages()

    {

        return CompanyMessage::where('company_id', '=', $this->id)->where('status', '=', 'unviewed')->where('type', '=', 'reply')->count();

    }

    public function countMessages($id)

    {

        return CompanyMessage::where('company_id', '=', $this->id)->where('seeker_id', '=', $id)->where('type', 'reply')->where('status', '=', 'unviewed')->count();

    }



    public function getSocialNetworkHtml()

    {

        $html = '';

        if (!empty($this->facebook))

            $html .= '<a href="' . $this->facebook . '" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>';



        if (!empty($this->twitter))

            $html .= '<a href="' . $this->twitter . '" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>';



        if (!empty($this->linkedin))

            $html .= '<a href="' . $this->linkedin . '" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>';



        if (!empty($this->google_plus))

            $html .= '<a href="' . $this->google_plus . '" target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>';



        if (!empty($this->pinterest))

            $html .= '<a href="' . $this->pinterest . '" target="_blank"><i class="fa fa-pinterest-square" aria-hidden="true"></i></a>';



        return $html;

    }



    public function isFavouriteApplicant($user_id, $job_id, $company_id)

    {

        $return = false;

        if (Auth::guard('company')->check()) {

            $count = FavouriteApplicant::where('user_id', $user_id)

                ->where('job_id', $job_id)

                ->where('company_id', $company_id)

                ->count();

            if ($count > 0)

                $return = true;

        }

        return $return;

    }



    public function package()

    {

        return $this->hasOne('App\Package', 'id', 'package_id');

    }



    public function getPackage($field = '')

    {

        $package = $this->package()->first();

        if (null !== $package) {

            if (!empty($field)) {

                return $package->$field;

            } else {

                return $package;

            }

        }

    }

    public function cvs_package()
    {
        return $this->hasOne('App\Package', 'id', 'cvs_package_id');
    }

    public function cvs_getPackage($field = '')

    {
        $package = $this->cvs_package()->first();
        if (null !== $package) {
            if (!empty($field)) {
                return $package->$field;
            } else {
                return $package;
            }
        }
    }

    /* ════════════════════════════════════════════════════════════════════
     *  ZNP pricing plan helpers
     *
     *  These wrap the new `znp_company_subscriptions` table that powers
     *  the Quick Job / Flex / Pro plans defined in `znp_pricing_plans`.
     *  Job posting (storeJobZNP) gates on `canPostZnpJob()` and calls
     *  `consumeOneZnpPost()` after a successful publish.
     * ════════════════════════════════════════════════════════════════════ */

    public function znpSubscriptions()
    {
        return $this->hasMany(\App\ZnpCompanySubscription::class, 'company_id', 'id');
    }

    /**
     * Returns the company's currently-active ZNP subscription (or null).
     *
     * "Active" = status='active' AND (expires_at is null OR > now). When
     * multiple active rows exist (shouldn't, but possible after a manual
     * regrant), the newest one wins. Used by the quota gates that decide
     * whether the employer can publish a new job.
     */
    public function activeZnpSubscription()
    {
        return $this->znpSubscriptions()
            ->active()
            ->orderByDesc('id')
            ->first();
    }

    /**
     * Returns the most-recent subscription regardless of whether it's still
     * within its validity window. Used by the plan view-model so we can show
     * an "Expired — renew" state instead of the colder "No plan yet" state
     * when the employer had a plan that lapsed.
     */
    public function latestZnpSubscription()
    {
        return $this->znpSubscriptions()
            ->where('status', 'active')
            ->orderByDesc('id')
            ->first();
    }

    /**
     * Convenience: true if the employer has a live ZNP plan with quota left.
     */
    public function canPostZnpJob(): bool
    {
        $sub = $this->activeZnpSubscription();
        return $sub && $sub->isLive() && $sub->hasQuotaLeft();
    }

    /**
     * Atomically increment the active subscription's `posts_used` after a
     * successful job publish. No-op if there is no active subscription
     * (caller is expected to gate on `canPostZnpJob()` first).
     */
    public function consumeOneZnpPost(): void
    {
        $sub = $this->activeZnpSubscription();
        if (! $sub) {
            return;
        }
        \DB::table('znp_company_subscriptions')
            ->where('id', $sub->id)
            ->increment('posts_used');
    }

    /**
     * Build a single, denormalised view-model describing this company's ZNP
     * plan state. Both the employer dashboard (znp.employer-dashboard) and
     * the my-jobs page (znp.my-jobs) consume this so the messaging stays in
     * sync across the app.
     *
     * Shape:
     *   [
     *     'has_plan'        => bool,
     *     'is_expired'      => bool,
     *     'is_unlimited'    => bool,
     *     'can_post'        => bool,
     *     'plan_name'       => string,  // e.g. "Flex" or "No active plan"
     *     'plan_slug'       => string|null,
     *     'tag_label'       => string|null,
     *     'posts_limit'     => int,     // 0 means unlimited
     *     'posts_used'      => int,
     *     'posts_remaining' => int,
     *     'percent'         => int,     // 0..100
     *     'tone'            => 'default'|'warn'|'full'|'expired'|'none',
     *     'expires_at'      => Carbon|null,
     *     'expires_label'   => string|null,  // "21 Aug 2026"
     *     'days_remaining'  => int|null,
     *     'status_line'     => string,  // headline copy ("Flex · 6 of 10 used")
     *     'sub_line'        => string,  // secondary copy ("4 posts remaining · expires …")
     *     'cta_label'       => string,  // "Post a Job" / "Buy a Plan" / "Renew"
     *     'cta_url'         => string,
     *     'pricing_url'     => string,
     *   ]
     */
    public function znpPlanViewModel(): array
    {
        $pricingUrl = route('employer.job.pricing');
        $postUrl    = route('employer.post.job.page');

        /* Use the latest non-cancelled subscription (whether or not it's still
           within its validity window) so we can show a dedicated "Expired —
           renew" state. The quota gates elsewhere use `activeZnpSubscription`
           which already filters out expired rows. */
        $sub = $this->latestZnpSubscription();

        /* ── State A: no subscription on file ── */
        if (! $sub) {
            return [
                'has_plan'        => false,
                'is_expired'      => false,
                'is_unlimited'    => false,
                'can_post'        => false,
                'plan_name'       => 'No active plan',
                'plan_slug'       => null,
                'tag_label'       => null,
                'posts_limit'     => 0,
                'posts_used'      => 0,
                'posts_remaining' => 0,
                'percent'         => 0,
                'tone'            => 'none',
                'expires_at'      => null,
                'expires_label'   => null,
                'days_remaining'  => null,
                'status_line'     => 'No active plan',
                'sub_line'        => 'Choose a plan to start posting jobs.',
                'cta_label'       => 'Post a Job',
                'cta_url'         => $pricingUrl,
                'pricing_url'     => $pricingUrl,
            ];
        }

        $now           = \Carbon\Carbon::now();
        $isExpired     = $sub->expires_at && $sub->expires_at->lt($now);
        $isUnlimited   = (int) $sub->posts_limit === 0;
        $postsUsed     = (int) $sub->posts_used;
        $postsLimit    = (int) $sub->posts_limit;
        $postsRemain   = $isUnlimited ? PHP_INT_MAX : max(0, $postsLimit - $postsUsed);
        $isOutOfQuota  = ! $isUnlimited && $postsRemain === 0;
        $expiresLabel  = $sub->expires_at ? $sub->expires_at->format('j M Y') : null;
        $daysRemaining = $sub->expires_at ? (int) ceil($now->diffInHours($sub->expires_at, false) / 24) : null;

        /* ── State B: subscription expired ── */
        if ($isExpired) {
            return [
                'has_plan'        => true,
                'is_expired'      => true,
                'is_unlimited'    => $isUnlimited,
                'can_post'        => false,
                'plan_name'       => $sub->plan_name,
                'plan_slug'       => $sub->plan_slug,
                'tag_label'       => null,
                'posts_limit'     => $postsLimit,
                'posts_used'      => $postsUsed,
                'posts_remaining' => 0,
                'percent'         => $isUnlimited ? 0 : 100,
                'tone'            => 'expired',
                'expires_at'      => $sub->expires_at,
                'expires_label'   => $expiresLabel,
                'days_remaining'  => $daysRemaining,
                'status_line'     => $sub->plan_name . ' · expired',
                'sub_line'        => 'Your plan expired on ' . $expiresLabel . '. Renew To Post Jobs.',
                'cta_label'       => 'Post a Job',
                'cta_url'         => $pricingUrl,
                'pricing_url'     => $pricingUrl,
            ];
        }

        /* ── State C: active subscription ── */
        $percent = $isUnlimited
            ? 0
            : (int) round(($postsUsed / max(1, $postsLimit)) * 100);

        if ($isUnlimited) {
            $tone = 'default';
        } elseif ($isOutOfQuota) {
            $tone = 'full';
        } elseif ($percent >= 80) {
            $tone = 'warn';
        } else {
            $tone = 'default';
        }

        if ($isUnlimited) {
            $statusLine = $sub->plan_name . ' · ' . $postsUsed . ' posted';
            $subLine    = 'Unlimited posts · expires ' . $expiresLabel
                . ($daysRemaining !== null ? ' (' . $daysRemaining . ' days left)' : '');
            $ctaLabel   = 'Post a Job';
            $ctaUrl     = $postUrl;
        } elseif ($isOutOfQuota) {
            $statusLine = $sub->plan_name . ' · ' . $postsUsed . ' of ' . $postsLimit . ' used';
            $subLine    = 'All ' . $postsLimit . ' posts used. Buy another pack to post more.';
            $ctaLabel   = 'Buy More Posts';
            $ctaUrl     = $pricingUrl;
        } else {
            $statusLine = $sub->plan_name . ' · ' . $postsUsed . ' of ' . $postsLimit . ' used';
            $subLine    = $postsRemain . ' post' . ($postsRemain === 1 ? '' : 's') . ' remaining'
                . ($expiresLabel ? ' · expires ' . $expiresLabel : '');
            $ctaLabel   = 'Post a Job';
            $ctaUrl     = $postUrl;
        }

        return [
            'has_plan'        => true,
            'is_expired'      => false,
            'is_unlimited'    => $isUnlimited,
            'can_post'        => $isUnlimited || ! $isOutOfQuota,
            'plan_name'       => $sub->plan_name,
            'plan_slug'       => $sub->plan_slug,
            'tag_label'       => optional($sub->plan)->tag_label,
            'posts_limit'     => $postsLimit,
            'posts_used'      => $postsUsed,
            'posts_remaining' => $isUnlimited ? 0 : $postsRemain,
            'percent'         => $percent,
            'tone'            => $tone,
            'expires_at'      => $sub->expires_at,
            'expires_label'   => $expiresLabel,
            'days_remaining'  => $daysRemaining,
            'status_line'     => $statusLine,
            'sub_line'        => $subLine,
            'cta_label'       => $ctaLabel,
            'cta_url'         => $ctaUrl,
            'pricing_url'     => $pricingUrl,
        ];
    }

}

