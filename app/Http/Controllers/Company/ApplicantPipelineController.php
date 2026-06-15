<?php

namespace App\Http\Controllers\Company;

use App\ApplicantEvent;
use App\ApplicantFeedback;
use App\ApplicantNote;
use App\ApplicantReport;
use App\Company;
use App\FavouriteApplicant;
use App\Http\Controllers\Controller;
use App\JobApply;
use App\PostJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantPipelineController extends Controller
{
    private const VERDICT_LABELS = [
        'sy' => 'Strong Yes',
        'y'  => 'Yes',
        'm'  => 'Maybe',
        'n'  => 'No',
        'sn' => 'Strong No',
    ];

    private const OFFER_LABELS = [
        'offered' => 'Offered',
        'joined'  => 'Joined',
        'dropout' => 'Offer Dropout',
    ];

    private const ACTIVITY_ORDER = [
        'applied'      => 10,
        'viewed'       => 20,
        'downloaded'   => 30,
        'note'         => 40,
        'feedback'     => 50,
        'reported'     => 60,
        'shortlisted'  => 70,
        'unshortlisted'=> 71,
        'offer'        => 80,
        'rejected'     => 90,
    ];

    /**
     * @return array{0: Company, 1: PostJob, 2: JobApply}
     */
    private function resolveContext(int $jobId, int $applicationId): array
    {
        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        $job = PostJob::where('id', $jobId)
            ->where('company_id', $company->id)
            ->firstOrFail();

        $application = JobApply::where('id', $applicationId)
            ->where('job_id', $job->id)
            ->firstOrFail();

        return [$company, $job, $application];
    }

    private function ensureAppliedEvent(JobApply $application, PostJob $job, Company $company): void
    {
        $exists = ApplicantEvent::where('job_apply_id', $application->id)
            ->where('type', 'applied')
            ->exists();

        if (! $exists) {
            ApplicantEvent::create([
                'job_apply_id' => $application->id,
                'job_id'       => $job->id,
                'company_id'   => $company->id,
                'type'         => 'applied',
                'label'        => 'Applied',
                'meta'         => null,
                'created_at'   => $application->created_at ?: Carbon::now(),
            ]);
        }
    }

    private function logEvent(
        JobApply $application,
        PostJob $job,
        Company $company,
        string $type,
        string $label,
        array $meta = []
    ): ApplicantEvent {
        $this->ensureAppliedEvent($application, $job, $company);

        return ApplicantEvent::create([
            'job_apply_id' => $application->id,
            'job_id'       => $job->id,
            'company_id'   => $company->id,
            'type'         => $type,
            'label'        => $label,
            'meta'         => $meta ?: null,
            'created_at'   => Carbon::now(),
        ]);
    }

    private function activityFromEvents(int $applicationId): array
    {
        $application = JobApply::find($applicationId);
        $events = ApplicantEvent::where('job_apply_id', $applicationId)
            ->orderBy('created_at')
            ->get();

        if ($events->isEmpty()) {
            return [];
        }

        $eventsByType = [];
        foreach ($events as $event) {
            if ($application && $application->stage === 'rejected' && $event->type === 'offer') {
                continue;
            }
            if ($application && $application->stage === 'offer' && $event->type === 'rejected') {
                continue;
            }
            $eventsByType[$event->type] = $event;
        }

        uasort($eventsByType, function ($a, $b) {
            $ao = self::ACTIVITY_ORDER[$a->type] ?? 999;
            $bo = self::ACTIVITY_ORDER[$b->type] ?? 999;

            return $ao <=> $bo;
        });

        $compactEvents = array_slice(array_values($eventsByType), 0, 7);
        $activity = [];
        $lastIndex = count($compactEvents) - 1;
        foreach ($compactEvents as $i => $event) {
            $activity[] = [
                'label' => $event->label,
                'date'  => $event->created_at ? $event->created_at->format('M j') : '—',
                'state' => $i === $lastIndex ? 'now' : 'done',
            ];
        }

        return $activity;
    }

    public function shortlist(Request $request, int $id, int $app)
    {
        [$company, $job, $application] = $this->resolveContext($id, $app);
        $userId = $application->user_id;

        $existing = FavouriteApplicant::where('user_id', $userId)
            ->where('job_id', $job->id)
            ->where('company_id', $company->id)
            ->first();

        if ($existing) {
            $existing->delete();
            if ($application->stage === 'shortlisted') {
                $application->stage = null;
                $application->save();
            }
            $this->logEvent($application, $job, $company, 'unshortlisted', 'Unshortlisted');

            return response()->json([
                'ok'           => true,
                'shortlisted'  => false,
                'stage'        => $this->deriveStage($application, false, $this->hasInterview($userId)),
                'activity'     => $this->activityFromEvents($application->id),
            ]);
        }

        FavouriteApplicant::create([
            'user_id'    => $userId,
            'job_id'     => $job->id,
            'company_id' => $company->id,
        ]);

        $application->stage = 'shortlisted';
        $application->save();

        $this->logEvent($application, $job, $company, 'shortlisted', 'Shortlisted');

        return response()->json([
            'ok'           => true,
            'shortlisted'  => true,
            'stage'        => 'shortlisted',
            'activity'     => $this->activityFromEvents($application->id),
        ]);
    }

    public function note(Request $request, int $id, int $app)
    {
        [$company, $job, $application] = $this->resolveContext($id, $app);

        $body = trim((string) $request->input('body', ''));
        if ($body === '') {
            return response()->json(['ok' => false, 'message' => 'Note cannot be empty.'], 422);
        }

        $note = ApplicantNote::updateOrCreate(
            ['job_apply_id' => $application->id],
            [
                'job_id'     => $job->id,
                'company_id' => $company->id,
                'user_id'    => $application->user_id,
                'body'       => $body,
            ]
        );

        $this->logEvent($application, $job, $company, 'note', 'Note added');

        return response()->json([
            'ok'   => true,
            'note' => [
                'body'       => $note->body,
                'updated_at' => $note->updated_at ? $note->updated_at->format('M j, Y g:i A') : '—',
            ],
            'activity' => $this->activityFromEvents($application->id),
        ]);
    }

    public function feedback(Request $request, int $id, int $app)
    {
        [$company, $job, $application] = $this->resolveContext($id, $app);

        $verdict = (string) $request->input('verdict', 'y');
        if (! isset(self::VERDICT_LABELS[$verdict])) {
            return response()->json(['ok' => false, 'message' => 'Invalid verdict.'], 422);
        }

        $feedback = ApplicantFeedback::create([
            'job_apply_id' => $application->id,
            'company_id'   => $company->id,
            'verdict'      => $verdict,
            'comments'     => trim((string) $request->input('comments', '')),
        ]);

        $label = self::VERDICT_LABELS[$verdict];
        $this->logEvent($application, $job, $company, 'feedback', 'Feedback: ' . $label, [
            'verdict' => $verdict,
        ]);

        return response()->json([
            'ok'       => true,
            'feedback' => [
                'verdict'       => $verdict,
                'verdict_label' => $label,
                'comments'      => $feedback->comments,
                'created_at'    => $feedback->created_at ? $feedback->created_at->format('M j, Y g:i A') : '—',
            ],
            'activity' => $this->activityFromEvents($application->id),
        ]);
    }

    public function reject(Request $request, int $id, int $app)
    {
        [$company, $job, $application] = $this->resolveContext($id, $app);

        if ($application->stage === 'offer') {
            return response()->json([
                'ok'      => false,
                'message' => 'This candidate is already moved to offer. Rejection is locked.',
            ], 422);
        }

        if ($application->stage === 'rejected') {
            return response()->json([
                'ok'       => true,
                'stage'    => 'rejected',
                'locked'   => true,
                'activity' => $this->activityFromEvents($application->id),
            ]);
        }

        $reason = trim((string) $request->input('reason', 'Skills mismatch'));
        $note   = trim((string) $request->input('note', ''));

        $application->stage = 'rejected';
        $application->offer_status = null;
        $application->rejected_reason = $reason;
        $application->rejected_note = $note !== '' ? $note : null;
        $application->rejected_at = Carbon::now();
        $application->save();

        FavouriteApplicant::where('user_id', $application->user_id)
            ->where('job_id', $job->id)
            ->where('company_id', $company->id)
            ->delete();

        $this->logEvent($application, $job, $company, 'rejected', 'Rejected', [
            'reason' => $reason,
        ]);

        return response()->json([
            'ok'       => true,
            'stage'    => 'rejected',
            'locked'   => true,
            'activity' => $this->activityFromEvents($application->id),
        ]);
    }

    public function report(Request $request, int $id, int $app)
    {
        [$company, $job, $application] = $this->resolveContext($id, $app);

        $reason  = trim((string) $request->input('reason', 'Fake profile / resume'));
        $details = trim((string) $request->input('details', ''));

        ApplicantReport::create([
            'job_apply_id' => $application->id,
            'company_id'   => $company->id,
            'reason'       => $reason,
            'details'      => $details !== '' ? $details : null,
            'status'       => 'open',
        ]);

        $application->reported_at = Carbon::now();
        $application->save();

        $this->logEvent($application, $job, $company, 'reported', 'Reported', [
            'reason' => $reason,
        ]);

        return response()->json([
            'ok'         => true,
            'is_reported'=> true,
            'activity'   => $this->activityFromEvents($application->id),
        ]);
    }

    public function offer(Request $request, int $id, int $app)
    {
        [$company, $job, $application] = $this->resolveContext($id, $app);

        if ($application->stage === 'rejected') {
            return response()->json([
                'ok'      => false,
                'message' => 'This candidate is already rejected. Offer is locked.',
            ], 422);
        }

        $status = (string) $request->input('status', 'offered');
        if (! isset(self::OFFER_LABELS[$status])) {
            return response()->json(['ok' => false, 'message' => 'Invalid offer status.'], 422);
        }

        if ($application->stage === 'offer' && $application->offer_status) {
            $label = self::OFFER_LABELS[$application->offer_status] ?? $application->offer_status;

            return response()->json([
                'ok'           => true,
                'stage'        => 'offer',
                'offer_status' => $application->offer_status,
                'offer_label'  => $label,
                'locked'       => true,
                'activity'     => $this->activityFromEvents($application->id),
            ]);
        }

        $application->stage = 'offer';
        $application->offer_status = $status;
        $application->rejected_reason = null;
        $application->rejected_note = null;
        $application->rejected_at = null;
        $application->save();

        $label = self::OFFER_LABELS[$status];
        $this->logEvent($application, $job, $company, 'offer', $label, [
            'offer_status' => $status,
        ]);

        return response()->json([
            'ok'           => true,
            'stage'        => 'offer',
            'offer_status' => $status,
            'offer_label'  => $label,
            'locked'       => true,
            'activity'     => $this->activityFromEvents($application->id),
        ]);
    }

    public function viewCv(Request $request, int $id, int $app)
    {
        [$company, $job, $application] = $this->resolveContext($id, $app);

        $user = $application->user;
        if (! $user || empty($user->resume)) {
            return response()->json(['ok' => false, 'message' => 'Resume not available.'], 422);
        }

        $application->last_viewed_at = Carbon::now();
        $application->save();

        $this->logEvent($application, $job, $company, 'viewed', 'Viewed');

        $cvUrl = asset('cvs/' . $user->resume);
        $downloadUrl = route('download.resume', $user->id);

        return response()->json([
            'ok'           => true,
            'cv_url'       => $cvUrl,
            'download_url' => $downloadUrl,
            'activity'     => $this->activityFromEvents($application->id),
        ]);
    }

    public function downloadCv(Request $request, int $id, int $app)
    {
        [$company, $job, $application] = $this->resolveContext($id, $app);

        $user = $application->user;
        if (! $user || empty($user->resume)) {
            return response()->json(['ok' => false, 'message' => 'Resume not available.'], 422);
        }

        $this->logEvent($application, $job, $company, 'downloaded', 'Downloaded');

        return response()->json([
            'ok'           => true,
            'download_url' => route('download.resume', $user->id),
            'activity'     => $this->activityFromEvents($application->id),
        ]);
    }

    public function retireJob(Request $request, int $id)
    {
        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        $job = PostJob::where('id', $id)
            ->where('company_id', $company->id)
            ->firstOrFail();

        $job->is_active = 0;
        $job->save();

        return response()->json(['ok' => true, 'message' => 'Job retired successfully.']);
    }

    private function hasInterview($userId): bool
    {
        $today = Carbon::now()->format('Y-m-d');

        return \App\Interview::where('user_id', $userId)
            ->where('date', '>=', $today)
            ->exists();
    }

    private function deriveStage(JobApply $application, bool $isShortlisted, bool $hasInterview): string
    {
        if ($application->stage && in_array($application->stage, ['rejected', 'offer', 'resumedb'], true)) {
            return $application->stage;
        }

        if ($hasInterview) {
            return 'interview';
        }

        if ($isShortlisted || $application->stage === 'shortlisted') {
            return 'shortlisted';
        }

        return 'new';
    }
}
