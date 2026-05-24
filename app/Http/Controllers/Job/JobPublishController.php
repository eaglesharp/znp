<?php

namespace App\Http\Controllers\Job;

use App\Collection;
use App\PostJob;
use App\Unlocked_users;
use App\User;
use Auth;
use DB;
use Input;
use Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Traits\JobTrait;

class JobPublishController extends Controller
{

    use JobTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('company');
    }
    public function viewApplicantProfile(Request $request)
    {
        $job_id = $request->job_id;
        $user_id = $request->id;

        $jobData = PostJob::where('id', $job_id)->first();

        
        if($jobData->resume_view){
            $data = json_decode($jobData->resume_view,true);
        }else{
            $data =[$user_id => $user_id];
        }
        if (count($data) < 3 || in_array($user_id, $data)) {

            $unlocked = Unlocked_users::where('company_id',Auth::guard('company')->user()->id)
            ->where('unlocked_users_ids',$user_id)->exists();
            $data [$user_id] = $user_id;
            $jobData->resume_view= json_encode($data);
            $jobData->save();
            $user = User::findOrFail($user_id );

            $profileCv = $user->getDefaultCv();
            $collections= Collection::where('user_id',Auth::guard('company')->user()->id)->get();



            return view('user.applicant_profile')

                        ->with('user', $user)
                        
                        ->with('unlocked', $unlocked)

                        ->with('profileCv', $profileCv)

                        ->with('page_title', $user->getName())

                        ->with('form_title', 'Contact ' . $user->getName())

                        ->with('collections',$collections);
        }else{
            return redirect('/employer/buy-cv/'. $user_id );
        }

    }

    /**
     * ZNP — My Job Postings page (new design).
     *
     * Renders the employer's posted jobs in the new design at /my-jobs.
     * UI is in resources/views/znp/my-jobs.blade.php (scoped to .znp-myjobs).
     *
     * What the controller provides to the view:
     *  - $company           : the authenticated company row.
     *  - $companyInitials   : 2-char avatar text (e.g. "FS").
     *  - $plan              : ['label','tone','used','limit','percent'] for the plan chip + usage bar.
     *  - $jobs              : Collection of PostJob rows, each decorated with derived fields:
     *        derived = [
     *            status_key       => 'active'|'inactive'|'expired',
     *            status_label     => 'Active'|'Inactive'|'Expired',
     *            posted_label     => 'Posted Apr 2, 2025',
     *            expires_label    => 'Expires in 5 days' | 'Expired'  (null = never expires),
     *            expires_tone     => ''|'soon'|'exp',
     *            expires_ts       => unix timestamp of expiry (null = never),
     *            location_label   => 'Bengaluru' or 'Bengaluru, Pune',
     *            locations        => ['Bengaluru', 'Pune']  (for client-side filter),
     *            mode_key         => 'wfo'|'hybrid'|'remote' (or '' if unknown),
     *            type_key         => 'permanent'|'contract' (or '' if unknown),
     *            exp_label        => '5 yrs exp' or '3 – 5 yrs exp',
     *            salary_label     => '₹14–22 LPA' | 'Confidential',
     *            skills_label     => '.NET · C# · Azure',
     *            applicants_total => int,
     *            applicants_new   => int (last 7 days),
     *            applicants_viewed=> int (resume_view unlocks),
     *            applicants_pending => int (total - viewed, never negative),
     *        ]
     *  - $statusCounts      : ['all'=>N, 'active'=>N, 'inactive'=>N, 'expired'=>N].
     *  - $modeCounts        : ['wfo'=>N, 'hybrid'=>N, 'remote'=>N].
     *  - $typeCounts        : ['permanent'=>N, 'contract'=>N].
     *  - $locationCounts    : ['Bengaluru'=>N, ...] (sorted by frequency).
     *
     * All filtering / search / sort happens client-side on the rendered rows
     * (data attributes on .job-row drive the JS in znp.my-jobs).
     */
    public function myJobsZNP()
    {
        $company = \Auth::guard('company')->user();

        $rawJobs = PostJob::withCount('appliedUsers')
            ->where('company_id', $company->id)
            ->where('is_draft', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $statusCounts   = ['all' => 0, 'active' => 0, 'inactive' => 0, 'expired' => 0];
        $modeCounts     = ['wfo' => 0, 'hybrid' => 0, 'remote' => 0];
        $typeCounts     = ['permanent' => 0, 'contract' => 0];
        $locationCounts = [];

        // Job lifespan in days — single source of truth used for "Expires in N days".
        $jobLifespanDays = 30;

        $jobs = $rawJobs->map(function ($job) use (&$statusCounts, &$modeCounts, &$typeCounts, &$locationCounts, $jobLifespanDays) {

            // ── Status (Active / Inactive / Expired) ───────────────────────
            $createdAt = $job->created_at ?: \Carbon\Carbon::now();
            $expiresAt = $createdAt->copy()->addDays($jobLifespanDays);
            $now = \Carbon\Carbon::now();

            if ((int) $job->status === 0) {
                $statusKey   = 'inactive';
                $statusLabel = 'Inactive';
                $expiresLabel = null;
                $expiresTone  = '';
            } elseif ($expiresAt->lt($now)) {
                $statusKey   = 'expired';
                $statusLabel = 'Expired';
                $expiresLabel = 'Expired';
                $expiresTone  = 'exp';
            } else {
                $statusKey   = 'active';
                $statusLabel = 'Active';
                $daysLeft    = (int) ceil($now->diffInHours($expiresAt, false) / 24);
                $expiresLabel = $daysLeft <= 1
                    ? 'Expires today'
                    : 'Expires in ' . $daysLeft . ' days';
                $expiresTone  = $daysLeft <= 7 ? 'soon' : '';
            }

            $statusCounts['all']++;
            $statusCounts[$statusKey]++;

            // ── Locations (php-serialized array on PostJob.location) ───────
            $locations = [];
            if (!empty($job->location)) {
                $decoded = @unserialize($job->location);
                if (is_array($decoded)) {
                    $locations = array_values(array_filter(array_map('trim', $decoded)));
                } elseif (is_string($job->location) && trim($job->location) !== '') {
                    $locations = [trim($job->location)];
                }
            }
            foreach ($locations as $loc) {
                $locationCounts[$loc] = ($locationCounts[$loc] ?? 0) + 1;
            }

            // ── Work mode key ──────────────────────────────────────────────
            $modeKey = '';
            $rawMode = strtolower((string) $job->work_mode);
            if (str_contains($rawMode, 'office')) {
                $modeKey = 'wfo';
            } elseif (str_contains($rawMode, 'hybrid')) {
                $modeKey = 'hybrid';
            } elseif (str_contains($rawMode, 'remote') || str_contains($rawMode, 'wfh')) {
                $modeKey = 'remote';
            }
            if ($modeKey !== '') $modeCounts[$modeKey]++;

            // ── Job type key (Permanent vs Contract) ───────────────────────
            $typeKey = '';
            $rawType = strtolower((string) $job->job_type);
            if (str_contains($rawType, 'contract')) {
                $typeKey = 'contract';
            } elseif (str_contains($rawType, 'permanent') || str_contains($rawType, 'full')) {
                $typeKey = 'permanent';
            }
            if ($typeKey !== '') $typeCounts[$typeKey]++;

            // ── Experience label ───────────────────────────────────────────
            $expLabel = '';
            $minExp = $job->exp_min !== null ? (float) $job->exp_min : null;
            $maxExp = $job->exp_max !== null ? (float) $job->exp_max : null;
            $fmt = function ($v) {
                $s = number_format((float) $v, 2, '.', '');
                return rtrim(rtrim($s, '0'), '.');
            };
            if ($minExp !== null && $maxExp !== null) {
                $expLabel = $minExp == $maxExp
                    ? $fmt($minExp) . ' yrs exp'
                    : $fmt($minExp) . '–' . $fmt($maxExp) . ' yrs exp';
            } elseif ($minExp !== null) {
                $expLabel = $fmt($minExp) . '+ yrs exp';
            } elseif (!empty($job->experience)) {
                $expLabel = $job->experience;
            }

            // ── Salary label ───────────────────────────────────────────────
            if ((int) $job->compensation_confidential === 1) {
                $salaryLabel = 'Confidential';
            } elseif ($job->min_salary && $job->max_salary) {
                $salaryLabel = '₹' . $job->min_salary . '–' . $job->max_salary . ' LPA';
            } elseif ($job->min_salary) {
                $salaryLabel = '₹' . $job->min_salary . '+ LPA';
            } else {
                $salaryLabel = '';
            }

            // ── Skills label (top 3 skills joined) ─────────────────────────
            $skillsLabel = '';
            try {
                $skills = $job->jobSkills()->limit(3)->get();
                $names = [];
                foreach ($skills as $s) {
                    $skill = $s->getJobSkill();
                    if ($skill && !empty($skill->job_skill)) {
                        $names[] = $skill->job_skill;
                    }
                }
                if (!empty($names)) {
                    $skillsLabel = implode(' · ', $names);
                }
            } catch (\Throwable $e) {
                // skills table missing — silently skip
            }

            // ── Applicant counts ───────────────────────────────────────────
            $total = (int) ($job->applied_users_count ?? 0);
            $newCount = $total > 0
                ? \App\JobApply::where('job_id', $job->id)
                    ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))
                    ->count()
                : 0;

            $viewedCount = 0;
            if (!empty($job->resume_view)) {
                $viewArr = json_decode($job->resume_view, true);
                if (is_array($viewArr)) $viewedCount = count($viewArr);
            }
            $pendingCount = max(0, $total - $viewedCount);

            $job->derived = [
                'status_key'        => $statusKey,
                'status_label'     => $statusLabel,
                'posted_label'     => 'Posted ' . $createdAt->format('M j, Y'),
                'expires_label'    => $expiresLabel,
                'expires_tone'     => $expiresTone,
                'expires_ts'       => $statusKey === 'inactive' ? null : $expiresAt->getTimestamp(),
                'location_label'   => empty($locations) ? '—' : implode(', ', $locations),
                'locations'        => $locations,
                'mode_key'         => $modeKey,
                'mode_label'       => $job->work_mode ?: '',
                'type_key'         => $typeKey,
                'type_label'       => $job->job_type ?: '',
                'exp_label'        => $expLabel,
                'salary_label'     => $salaryLabel,
                'skills_label'     => $skillsLabel,
                'applicants_total' => $total,
                'applicants_new'   => $newCount,
                'applicants_viewed'=> $viewedCount,
                'applicants_pending'=> $pendingCount,
            ];

            return $job;
        });

        // ── Sort location facets by frequency desc, then alpha ─────────────
        arsort($locationCounts);

        // ── Plan / posts-used info ─────────────────────────────────────────
        // Source of truth: the ZNP plan view-model on Company. It already
        // handles unlimited / out-of-quota / expired states with copy that
        // matches the dashboard. Here we just shape it for the legacy keys
        // the my-jobs blade was already consuming and add a few extras.
        $vm = $company->znpPlanViewModel();

        // Tone alignment: my-jobs blade uses '' / 'warn' / 'full' for the chip.
        $myJobsTone = $vm['tone'] === 'default' ? '' : ($vm['tone'] === 'expired' ? 'full' : $vm['tone']);

        $plan = [
            'label'           => $vm['has_plan'] ? $vm['status_line'] : 'No active plan',
            'tone'            => $myJobsTone,
            'used'            => $vm['posts_used'],
            'limit'           => $vm['posts_limit'],
            'percent'         => $vm['percent'],
            // ── New keys for richer messaging in the sidebar + buy nudge ──
            'name'            => $vm['plan_name'],
            'has_plan'        => $vm['has_plan'],
            'is_expired'      => $vm['is_expired'],
            'is_unlimited'    => $vm['is_unlimited'],
            'can_post'        => $vm['can_post'],
            'remaining'       => $vm['posts_remaining'],
            'expires_label'   => $vm['expires_label'],
            'days_remaining'  => $vm['days_remaining'],
            'sub_line'        => $vm['sub_line'],
            'cta_label'       => $vm['cta_label'],
            'cta_url'         => $vm['cta_url'],
            'pricing_url'     => $vm['pricing_url'],
        ];

        // Legacy fallback for accounts that pre-date ZNP plans: if there is
        // no ZNP subscription but the old jobs_quota counters look populated,
        // surface that instead of an empty "No active plan" chip.
        if (! $vm['has_plan']) {
            $legacyQuota   = (int) ($company->jobs_quota ?? 0);
            $legacyAvailed = (int) ($company->availed_jobs_quota ?? 0);
            $legacyLive    = $statusCounts['all'];
            $legacyUsed    = max($legacyAvailed, $legacyLive);
            if ($legacyQuota > 0 || $legacyUsed > 0) {
                $plan['used']    = $legacyUsed;
                $plan['limit']   = $legacyQuota;
                $plan['percent'] = $legacyQuota > 0 ? (int) round(($legacyUsed / $legacyQuota) * 100) : 0;
                $plan['label']   = ($legacyQuota === 1 ? 'Quick Job' : 'Plan')
                    . ' · ' . $legacyUsed . ($legacyQuota > 0 ? ' of ' . $legacyQuota : '') . ' used';
                if ($legacyQuota > 0 && $legacyUsed >= $legacyQuota) {
                    $plan['tone'] = 'full';
                } elseif ($plan['percent'] >= 80) {
                    $plan['tone'] = 'warn';
                }
            }
        }

        // Upsell options for the "Buy more" nudge — show the other active
        // plans (excluding the user's current one) ranked by display order.
        $upsellPlans = \App\ZnpPricingPlan::active()->ordered()->get()
            ->reject(function ($p) use ($vm) {
                return $vm['has_plan'] && $vm['plan_slug'] === $p->slug;
            })
            ->values();

        // ── Avatar initials (max 2 chars from company name) ────────────────
        $companyName = trim((string) ($company->name ?? ''));
        $initials = '';
        if ($companyName !== '') {
            $parts = preg_split('/\s+/', $companyName);
            $initials = strtoupper(substr($parts[0] ?? '', 0, 1) . substr($parts[1] ?? '', 0, 1));
            if ($initials === '') $initials = strtoupper(substr($companyName, 0, 2));
        }
        if ($initials === '') $initials = 'EM';

        return view('znp.my-jobs', [
            'company'          => $company,
            'companyInitials'  => $initials,
            'plan'             => $plan,
            'upsellPlans'      => $upsellPlans,
            'jobs'             => $jobs,
            'statusCounts'     => $statusCounts,
            'modeCounts'       => $modeCounts,
            'typeCounts'       => $typeCounts,
            'locationCounts'   => $locationCounts,
        ]);
    }

}
