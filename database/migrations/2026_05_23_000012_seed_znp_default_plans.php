<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Data-migration that ships the three default ZNP pricing plans:
 *   - quick_job  · ₹2,999  · 1 post   · 30-day validity
 *   - flex       · ₹25,000 · 10 posts · 90-day validity
 *   - pro        · custom  · unlimited · 365-day validity
 *
 * Why a migration and not just a seeder?
 *   The staging deploy (.github/workflows/staging-deploy.yml) runs
 *   `php artisan migrate --force` but NOT `db:seed`, so without this file
 *   the pricing page renders the empty-state ("No plans are currently
 *   available") on a fresh deploy. By making it a migration it runs once
 *   per environment automatically, and is recorded in `migrations` so it
 *   won't re-run on subsequent deploys.
 *
 * Idempotent: uses upsert on `slug`, so manual tweaks to a plan via the DB
 * are safe — re-running the migration won't override your edits because
 * it only runs on environments where it hasn't been recorded yet.
 *
 * Down: leaves the plan rows alone. Dropping plans would orphan any active
 * company subscriptions that reference them.
 */
class SeedZnpDefaultPlans extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('znp_pricing_plans')) {
            return;
        }

        $now = now();
        $plans = [
            [
                'slug'             => 'quick_job',
                'name'             => 'Quick Job',
                'tag_label'        => 'Single Job',
                'description'      => 'Perfect for occasional hiring. Pay per job — no commitment, no subscription.',
                'price'            => 2999.00,
                'original_price'   => null,
                'is_custom_price'  => 0,
                'gst_percent'      => 18.00,
                'currency'         => 'INR',
                'job_posts_limit'  => 1,
                'validity_days'    => 30,
                'post_active_days' => 30,
                'is_featured'      => 0,
                'variant'          => 'default',
                'cta_label'        => 'Get Started →',
                'cta_url'          => '/post-job-page',
                'price_subtext'    => 'per job post · shown across all metros · valid 30 days · + GST',
                'billing_note'     => 'Billed monthly — pay only when you post',
                'highlights'       => json_encode([
                    ['label' => '1 active job post · shown across all metros', 'note' => 'Goes live within 30 minutes of review', 'included' => true],
                    ['label' => 'Applications from immediate joiners & serving notice', 'note' => 'Verified zero & short notice period candidates only', 'included' => true],
                    ['label' => 'Applications from contractors', 'note' => 'Access freelance & contract talent on day-rate', 'included' => true],
                    ['label' => 'Verification of notice period', 'note' => "Every applicant's notice period is independently verified", 'included' => true],
                    ['label' => 'KYC verification required', 'note' => 'One-time employer verification before going live', 'included' => true],
                    ['label' => 'Applicant dashboard', 'note' => 'View, shortlist and manage applications', 'included' => true],
                    ['label' => 'Email support', 'note' => '', 'included' => true],
                ]),
                'is_active'        => 1,
                'display_order'    => 10,
            ],
            [
                'slug'             => 'flex',
                'name'             => 'Flex',
                'tag_label'        => 'Most Popular',
                'description'      => 'For teams hiring regularly. 10 posts at a significant discount with premium features included.',
                'price'            => 25000.00,
                'original_price'   => 29990.00,
                'is_custom_price'  => 0,
                'gst_percent'      => 18.00,
                'currency'         => 'INR',
                'job_posts_limit'  => 10,
                'validity_days'    => 90,
                'post_active_days' => 30,
                'is_featured'      => 1,
                'variant'          => 'featured',
                'cta_label'        => 'Start Hiring →',
                'cta_url'          => '/post-job-page',
                'price_subtext'    => '10 job posts · ₹2,500 per post · valid 90 days · each post active 30 days · + GST',
                'billing_note'     => 'Billed monthly — activate posts anytime within 90 days',
                'highlights'       => json_encode([
                    ['label' => '10 job posts · shown across all metros', 'note' => 'Each post stays active for 30 days · activate anytime within 90 days of purchase', 'included' => true],
                    ['label' => 'Applications from immediate joiners & serving notice', 'note' => 'Verified zero & short notice period candidates only', 'included' => true],
                    ['label' => 'Applications from contractors', 'note' => 'Access freelance & contract talent on day-rate', 'included' => true],
                    ['label' => 'Verification of notice period', 'note' => "Every applicant's notice period is independently verified", 'included' => true],
                    ['label' => 'KYC verification required', 'note' => 'One-time employer verification before going live', 'included' => true],
                    ['label' => 'Applicant dashboard', 'note' => 'View, shortlist and manage applications', 'included' => true],
                    ['label' => 'Dedicated recruiter support', 'note' => 'A ZeroNoticePeriod recruiter assists your hiring', 'included' => true],
                    ['label' => 'Priority listing', 'note' => 'Your jobs appear at the top of search results', 'included' => true],
                ]),
                'is_active'        => 1,
                'display_order'    => 20,
            ],
            [
                'slug'             => 'pro',
                'name'             => 'Pro',
                'tag_label'        => 'Enterprise',
                'description'      => 'For large teams with high-volume hiring. Minimum 250 job postings, everything unlimited, white-glove support.',
                'price'            => 0,
                'original_price'   => null,
                'is_custom_price'  => 1,
                'gst_percent'      => 18.00,
                'currency'         => 'INR',
                /* 0 = unlimited within the quota system; the "min 250" is a sales-side commitment. */
                'job_posts_limit'  => 0,
                'validity_days'    => 365,
                'post_active_days' => 30,
                'is_featured'      => 0,
                'variant'          => 'enterprise',
                'cta_label'        => 'Talk to Sales →',
                'cta_url'          => '/contact-us',
                'price_subtext'    => 'Annual plan · minimum 250 job postings · + GST',
                'billing_note'     => 'Billed annually — tailored to your team size',
                'highlights'       => json_encode([
                    ['label' => 'Minimum 250 job posts per year', 'note' => 'No cap — post as many as your plan allows', 'included' => true],
                    ['label' => 'Applications from immediate joiners & serving notice', 'note' => 'Verified zero & short notice period candidates', 'included' => true],
                    ['label' => 'Applications from contractors', 'note' => 'Find both permanent and contract talent', 'included' => true],
                    ['label' => 'Verification of notice period', 'note' => "Every applicant's notice period is independently verified", 'included' => true],
                    ['label' => 'AI fitment analysis', 'note' => 'Auto-rank every applicant instantly', 'included' => true],
                    ['label' => 'Dedicated account manager', 'note' => 'Named contact, not a support queue', 'included' => true],
                    ['label' => 'Priority listing + featured employer', 'note' => 'Your brand prominently displayed to candidates', 'included' => true],
                    ['label' => 'Custom reporting & analytics', 'note' => 'Hiring funnel data and team-level insights', 'included' => true],
                ]),
                'is_active'        => 1,
                'display_order'    => 30,
            ],
        ];

        foreach ($plans as $row) {
            $slug = $row['slug'];
            $exists = DB::table('znp_pricing_plans')->where('slug', $slug)->exists();

            if ($exists) {
                /* Don't clobber rows that an operator has tweaked in the DB.
                   Only top up missing columns if any (no-op in practice). */
                continue;
            }

            DB::table('znp_pricing_plans')->insert(array_merge($row, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }

    public function down()
    {
        /* Intentionally left blank: deleting plan rows would orphan any
           active subscriptions in znp_company_subscriptions that reference
           them, and re-running the up() repopulates the defaults anyway. */
    }
}
