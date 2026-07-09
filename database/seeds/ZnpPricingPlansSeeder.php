<?php

use Illuminate\Database\Seeder;
use App\ZnpPricingPlan;

/**
 * Seeds the three default plans shown on resources/views/znp/job-pricing.blade.php:
 *
 *   1. quick_job — Single job, ₹2,999, 1 post, 30-day validity, 30-day post lifespan
 *   2. flex     — 10 posts, ₹25,000 (was ₹29,990), 90-day validity, 30-day post lifespan
 *   3. pro      — Enterprise, custom price, "unlimited" (min 250) posts, 365-day validity
 *
 * Run once via:   php artisan db:seed --class=ZnpPricingPlansSeeder
 *
 * Re-runnable: uses updateOrCreate on `slug`, so it will refresh copy/prices
 * for the seeded slugs without duplicating rows. Custom plans created by the
 * team in the DB are NOT touched.
 */
class ZnpPricingPlansSeeder extends Seeder
{
    public function run()
    {
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
                'cta_url'          => '/post-job',
                'price_subtext'    => 'per job post · shown across all metros · valid 30 days · + GST',
                'billing_note'     => 'Billed monthly — pay only when you post',
                'highlights'       => [
                    ['label' => '1 active job post · shown across all metros', 'note' => 'Goes live within 30 minutes of review', 'included' => true],
                    ['label' => 'Applications from immediate joiners & serving notice', 'note' => 'Verified zero & short notice period candidates only', 'included' => true],
                    ['label' => 'Applications from contractors', 'note' => 'Access freelance & contract talent on day-rate', 'included' => true],
                    ['label' => 'Verification of notice period', 'note' => "Every applicant's notice period is independently verified", 'included' => true],
                    ['label' => 'KYC verification required', 'note' => 'One-time employer verification before going live', 'included' => true],
                    ['label' => 'Applicant dashboard', 'note' => 'View, shortlist and manage applications', 'included' => true],
                    ['label' => 'Email support', 'note' => '', 'included' => true],
                ],
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
                'cta_url'          => '/post-job',
                'price_subtext'    => '10 job posts · ₹2,500 per post · valid 90 days · each post active 30 days · + GST',
                'billing_note'     => 'Billed monthly — activate posts anytime within 90 days',
                'highlights'       => [
                    ['label' => '10 job posts · shown across all metros', 'note' => 'Each post stays active for 30 days · activate anytime within 90 days of purchase', 'included' => true],
                    ['label' => 'Applications from immediate joiners & serving notice', 'note' => 'Verified zero & short notice period candidates only', 'included' => true],
                    ['label' => 'Applications from contractors', 'note' => 'Access freelance & contract talent on day-rate', 'included' => true],
                    ['label' => 'Verification of notice period', 'note' => "Every applicant's notice period is independently verified", 'included' => true],
                    ['label' => 'KYC verification required', 'note' => 'One-time employer verification before going live', 'included' => true],
                    ['label' => 'Applicant dashboard', 'note' => 'View, shortlist and manage applications', 'included' => true],
                    ['label' => 'Dedicated recruiter support', 'note' => 'A ZeroNoticePeriod recruiter assists your hiring', 'included' => true],
                    ['label' => 'Priority listing', 'note' => 'Your jobs appear at the top of search results', 'included' => true],
                ],
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
                'highlights'       => [
                    ['label' => 'Minimum 250 job posts per year', 'note' => 'No cap — post as many as your plan allows', 'included' => true],
                    ['label' => 'Applications from immediate joiners & serving notice', 'note' => 'Verified zero & short notice period candidates', 'included' => true],
                    ['label' => 'Applications from contractors', 'note' => 'Find both permanent and contract talent', 'included' => true],
                    ['label' => 'Verification of notice period', 'note' => "Every applicant's notice period is independently verified", 'included' => true],
                    ['label' => 'AI fitment analysis', 'note' => 'Auto-rank every applicant instantly', 'included' => true],
                    ['label' => 'Dedicated account manager', 'note' => 'Named contact, not a support queue', 'included' => true],
                    ['label' => 'Priority listing + featured employer', 'note' => 'Your brand prominently displayed to candidates', 'included' => true],
                    ['label' => 'Custom reporting & analytics', 'note' => 'Hiring funnel data and team-level insights', 'included' => true],
                ],
                'is_active'        => 1,
                'display_order'    => 30,
            ],
        ];

        foreach ($plans as $row) {
            ZnpPricingPlan::updateOrCreate(
                ['slug' => $row['slug']],
                $row
            );
        }

        $this->command->info('Seeded ' . count($plans) . ' ZNP pricing plans (idempotent).');
    }
}
