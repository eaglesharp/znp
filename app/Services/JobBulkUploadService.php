<?php

namespace App\Services;

use App\Company;
use App\JobSkill;
use App\JobSkillManager;
use App\PostJob;
use Illuminate\Support\Str;

class JobBulkUploadService
{
    public const WORK_MODES = [
        'Work from Office',
        'Hybrid',
        'Remote / WFH',
        'Temp WFH',
    ];

    public const JOB_TYPES = [
        'Full Time / Permanent',
        'Contract',
        'Contract to Hire',
        'Internship',
        'Fresher',
        'Part Time',
    ];

    public const JOB_SHIFTS = [
        'General Shift (9 AM – 6 PM)',
        'Rotational Shift',
        'US Shift (6 PM +)',
        'UK Shift (1:30 PM +)',
        'APAC Shift (6 AM +)',
        '6 Days / Week',
        'Flexible Hours',
    ];

    public const PRIMARY_LANGUAGES = [
        'English',
        'Hindi',
        'English & Hindi',
        'Tamil',
        'Telugu',
        'Kannada',
        'Malayalam',
        'Marathi',
        'Bengali',
        'Gujarati',
        'Other',
    ];

    public const POSTING_TYPES = [
        'direct',
        'client',
    ];

    public const CLIENT_INDUSTRIES = [
        'Information Technology',
        'Banking & Financial Services',
        'Healthcare & Pharma',
        'E-commerce & Retail',
        'Manufacturing',
        'Consulting',
        'Other',
    ];

    public const CONTRACT_DURATIONS = [
        '1 Month',
        '2 Months',
        '3 Months',
        '6 Months',
        '9 Months',
        '12 Months',
        '18 Months',
        '24 Months',
        'Open-ended',
    ];

    public const CONTRACT_EXTENSIONS = [
        'Likely',
        'Possible',
        'None',
    ];

    public const INTERVIEW_MODES = [
        'CV Screening',
        'Video Interview',
        'Technical Assessment',
        'HR Interview',
        'Coding Test',
        'Client Interview',
        'Case Study Challenge',
        'White Paper Challenge',
        'Walk-in',
        'AI Assessment',
        'AI Interview',
    ];

    public const PROFILE_REQUIREMENTS = [
        'Current CTC',
        'Expected CTC',
        'Notice Period',
    ];

    public const TEMPLATE_COLUMNS = [
        'job_title',
        'work_mode',
        'job_type',
        'job_shift',
        'min_salary',
        'max_salary',
        'compensation_confidential',
        'no_of_openings',
        'exp_min',
        'exp_max',
        'primary_language',
        'posting_type',
        'client_name',
        'client_industry',
        'location',
        'locality',
        'keyskills',
        'interview_modes',
        'job_description',
        'job_overview',
        'about_company',
        'website_address',
        'industry',
        'headcount',
        'office_address',
        'contract_duration',
        'contract_day_rate',
        'contract_extension',
        'profile_requirements',
        'strict_mode',
        'countries_presence',
        'awards',
        'perks',
        'video_question_enabled',
    ];

    /** Company-profile columns that are prefilled from the company row on template download. */
    public const COMPANY_PREFILL_COLUMNS = [
        'countries_presence',
        'awards',
        'perks',
    ];

    public static function allowedValues(): array
    {
        return [
            'work_mode' => self::WORK_MODES,
            'job_type' => self::JOB_TYPES,
            'job_shift' => self::JOB_SHIFTS,
            'primary_language' => self::PRIMARY_LANGUAGES,
            'posting_type' => self::POSTING_TYPES,
            'client_industry' => self::CLIENT_INDUSTRIES,
            'contract_duration' => self::CONTRACT_DURATIONS,
            'contract_extension' => self::CONTRACT_EXTENSIONS,
            'interview_modes' => self::INTERVIEW_MODES,
            'profile_requirements' => self::PROFILE_REQUIREMENTS,
        ];
    }

    /**
     * Single-value enum columns that should render as an Excel dropdown.
     * Multi-value columns (location/keyskills/interview_modes/profile_requirements)
     * are intentionally excluded — they hold comma-separated lists.
     *
     * @return array<string, array<int, string|int>>
     */
    public static function dropdownColumns(): array
    {
        return [
            'work_mode' => self::WORK_MODES,
            'job_type' => self::JOB_TYPES,
            'job_shift' => self::JOB_SHIFTS,
            'compensation_confidential' => [0, 1],
            'primary_language' => self::PRIMARY_LANGUAGES,
            'posting_type' => self::POSTING_TYPES,
            'client_industry' => self::CLIENT_INDUSTRIES,
            'contract_duration' => self::CONTRACT_DURATIONS,
            'contract_extension' => self::CONTRACT_EXTENSIONS,
            'strict_mode' => [0, 1],
            'video_question_enabled' => [0, 1],
        ];
    }

    /**
     * Normalize the multi-value columns into arrays so the same row can be
     * validated and persisted whether it came from Excel (comma strings) or
     * the web grid (arrays/strings).
     */
    public function prepareForValidation(array $row): array
    {
        $row['keyskills'] = $this->parseList($row['keyskills'] ?? null);
        $row['interview_modes'] = $this->parseList($row['interview_modes'] ?? null);
        $row['profile_requirements'] = $this->parseList($row['profile_requirements'] ?? null);
        $row['location'] = $this->parseList($row['location'] ?? null);

        return $row;
    }

    /**
     * Validation rules shared by the Excel import and the web grid. Mirrors the
     * publish rules in CompanyController@storeJobZNP.
     */
    public function validationRules(array $row): array
    {
        $rules = [
            'job_title' => 'required|max:255',
            'work_mode' => 'required|in:' . implode(',', self::WORK_MODES),
            'job_type' => 'required|in:' . implode(',', self::JOB_TYPES),
            'job_shift' => 'required|in:' . implode(',', self::JOB_SHIFTS),
            'min_salary' => 'required|numeric|min:0',
            'max_salary' => 'required|numeric|min:0',
            'no_of_openings' => 'required|integer|min:1',
            'exp_min' => 'required|numeric|min:0',
            'primary_language' => 'required|in:' . implode(',', self::PRIMARY_LANGUAGES),
            'posting_type' => 'required|in:' . implode(',', self::POSTING_TYPES),
            'keyskills' => 'required|array|min:1',
            'interview_modes' => 'required|array|min:1',
            'interview_modes.*' => 'in:' . implode(',', self::INTERVIEW_MODES),
            'profile_requirements' => 'required|array|min:1',
            'profile_requirements.*' => 'in:' . implode(',', self::PROFILE_REQUIREMENTS),
            'job_description' => 'required',
            'job_overview' => 'required',
            'about_company' => 'required',
            'website_address' => 'required',
            'compensation_confidential' => 'nullable',
            'strict_mode' => 'nullable',
            'contract_duration' => 'nullable|in:' . implode(',', self::CONTRACT_DURATIONS),
            'contract_extension' => 'nullable|in:' . implode(',', self::CONTRACT_EXTENSIONS),
        ];

        $workMode = (string) ($row['work_mode'] ?? '');
        if (! in_array($workMode, ['Remote / WFH', 'Remote/WFH'], true)) {
            $rules['location'] = 'required|array|min:1';
        }

        if (($row['posting_type'] ?? '') === 'client') {
            $rules['client_industry'] = 'required|in:' . implode(',', self::CLIENT_INDUSTRIES);
        }

        return $rules;
    }

    public function validationMessages(): array
    {
        return [
            'job_title.required' => 'Job title is required.',
            'work_mode.in' => 'Work mode must match one of the allowed values.',
            'job_type.in' => 'Job type must match one of the allowed values.',
            'job_shift.in' => 'Job shift must match one of the allowed values.',
            'primary_language.in' => 'Primary language must match one of the allowed values.',
            'posting_type.in' => 'Posting type must be direct or client.',
            'location.required' => 'Location is required unless work mode is Remote / WFH.',
            'client_industry.required' => 'Client industry is required when posting type is client.',
            'interview_modes.*.in' => 'One or more interview modes are invalid.',
            'profile_requirements.*.in' => 'One or more profile requirements are invalid.',
        ];
    }

    public function store(Company $company, array $row): PostJob
    {
        $locations = $this->parseList($row['location'] ?? null);
        $interviewModes = $this->parseList($row['interview_modes'] ?? null);
        $profileRequirements = $this->parseList($row['profile_requirements'] ?? null);
        $skills = $this->parseList($row['keyskills'] ?? null);

        $job = new PostJob();
        $job->company_id = $company->id;

        $job->job_title = trim((string) ($row['job_title'] ?? ''));
        $job->work_mode = $this->normalizeWorkMode($row['work_mode'] ?? null);
        $job->job_type = $this->normalizeJobType($row['job_type'] ?? null);
        $job->job_shift = trim((string) ($row['job_shift'] ?? ''));

        $job->duration = $this->nullableString($row['contract_duration'] ?? null);
        $job->contract_day_rate = $this->nullableNumeric($row['contract_day_rate'] ?? null);
        $job->contract_extension = $this->nullableString($row['contract_extension'] ?? null);

        $job->min_salary = $row['min_salary'];
        $job->max_salary = $row['max_salary'];
        $job->compensation_confidential = $this->toBool($row['compensation_confidential'] ?? 0);
        $job->no_of_openings = (int) $row['no_of_openings'];

        $job->exp_min = $row['exp_min'];
        $job->exp_max = $this->nullableNumeric($row['exp_max'] ?? null);
        $job->experience = $row['exp_min'] !== null && $row['exp_min'] !== ''
            ? trim((string) $row['exp_min'] . ' Years')
            : null;

        $job->primary_language = trim((string) ($row['primary_language'] ?? ''));
        $job->posting_type = trim((string) ($row['posting_type'] ?? ''));
        $job->client_name = $this->nullableString($row['client_name'] ?? null);
        $job->client_industry = $this->nullableString($row['client_industry'] ?? null);

        $job->location = $locations ? serialize($locations) : null;
        $job->locality = $this->nullableString($row['locality'] ?? null);

        $normalizedModes = array_map([$this, 'normalizeInterviewMode'], $interviewModes);
        $job->interview_modes = implode(',', array_filter($normalizedModes));

        $job->job_description = $this->sanitizeRichHtml($this->plainTextToHtml($row['job_description'] ?? null));
        $job->job_overview = $this->sanitizeRichHtml($this->plainTextToHtml($row['job_overview'] ?? null));
        $job->roles_responsibility = null;

        $job->about_company = trim((string) ($row['about_company'] ?? ''));
        $job->website_address = trim((string) ($row['website_address'] ?? ''));
        $job->industry = $this->nullableString($row['industry'] ?? null);
        $job->headcount = $this->nullableString($row['headcount'] ?? null);
        $job->office_address = $this->nullableString($row['office_address'] ?? null);
        $job->countries_presence = json_encode($this->parseList($row['countries_presence'] ?? null));
        $job->awards = json_encode($this->parseList($row['awards'] ?? null));
        $job->perks = json_encode($this->parseList($row['perks'] ?? null));

        $videoRaw = $row['video_question_enabled'] ?? null;
        $videoEnabled = ($videoRaw === null || trim((string) $videoRaw) === '')
            ? true /* default: enabled when the cell is left blank */
            : $this->toBool($videoRaw) === 1;
        $job->questionnaire = json_encode($this->defaultQuestionnaire($videoEnabled));
        $job->profile_requirements = json_encode($profileRequirements);
        $job->strict_mode = $this->toBool($row['strict_mode'] ?? 0);
        $job->is_draft = 0;
        $job->status = 1;

        $job->save();

        $job->slug = Str::slug($job->job_title, '-') . '-' . $job->id;
        $job->update();

        $this->storeSkills($job->id, $skills);
        $job->load('jobSkills');
        $this->updateFullTextSearch($job, $locations, $row);

        return $job->fresh();
    }

    public function normalizeRow(array $raw): array
    {
        $row = [];

        foreach (self::TEMPLATE_COLUMNS as $column) {
            $row[$column] = $this->extractColumnValue($raw, $column);
        }

        return $row;
    }

    private function extractColumnValue(array $raw, string $column)
    {
        if (array_key_exists($column, $raw)) {
            return $raw[$column];
        }

        $slug = Str::slug($column, '_');
        if (array_key_exists($slug, $raw)) {
            return $raw[$slug];
        }

        return null;
    }

    public function parseList($value): array
    {
        if (is_array($value)) {
            return array_values(array_filter(array_map('trim', $value), static function ($item) {
                return $item !== '';
            }));
        }

        if ($value === null || trim((string) $value) === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', (string) $value)), static function ($item) {
            return $item !== '';
        }));
    }

    private function defaultQuestionnaire(bool $videoEnabled = true): array
    {
        /* Q1 and Q2 are always enabled (no opt-out); only Q3 (video) is toggleable. */
        return [
            ['key' => 'years_relevant', 'label' => 'How many years of experience do you have relevant to this role?', 'type' => 'number', 'required' => true, 'enabled' => true],
            ['key' => 'why_hire', 'label' => 'Why should we hire you?', 'type' => 'text', 'required' => true, 'enabled' => true],
            ['key' => 'video_intro', 'label' => 'Share a link to your video introduction', 'type' => 'url', 'required' => false, 'enabled' => $videoEnabled],
        ];
    }

    private function storeSkills(int $jobId, array $skills): void
    {
        JobSkillManager::where('job_id', '=', $jobId)->delete();

        foreach ($skills as $skillName) {
            $skillName = trim((string) $skillName);
            if ($skillName === '') {
                continue;
            }

            $manager = new JobSkillManager();
            $manager->job_id = $jobId;

            if (is_numeric($skillName)) {
                $manager->job_skill_id = (int) $skillName;
            } else {
                $existing = JobSkill::where('job_skill', $skillName)->first();
                if ($existing) {
                    $manager->job_skill_id = $existing->id;
                } else {
                    $new = new JobSkill();
                    $new->job_skill = $skillName;
                    $new->save();
                    $manager->job_skill_id = $new->id;
                }
            }

            $manager->save();
        }
    }

    private function updateFullTextSearch(PostJob $job, array $locations, array $row): void
    {
        $locStr = $locations ? implode(' ', $locations) : '';

        $str  = ' ' . $job->job_title;
        $str .= ' ' . $job->locality;
        $str .= ' ' . ($row['exp_min'] ?? '');
        $str .= ' ' . $job->getJobSkillsStr();
        $str .= ' ' . $locStr;
        $str .= ' ' . $job->job_type;
        $str .= ' ' . $job->job_shift;
        $str .= ' ' . $job->work_mode;
        $str .= ' ' . $job->industry;
        $str .= ' ' . $job->client_name;

        $job->search = $str;
        $job->update();
    }

    private function normalizeWorkMode(?string $mode): ?string
    {
        $map = [
            'Work from Office' => 'Work From Office',
            'Remote / WFH' => 'Remote/WFH',
        ];

        return $map[$mode] ?? $mode;
    }

    private function normalizeJobType(?string $type): ?string
    {
        $map = [
            'Full Time / Permanent' => 'Full time/Permanent',
            'Contract to Hire' => 'Contract To Hire',
            'Part Time' => 'Part Time',
        ];

        return $map[$type] ?? $type;
    }

    private function normalizeInterviewMode(string $mode): string
    {
        $map = [
            'Video Interview' => 'Video Interviews',
            'Walk-in' => 'Walkin',
        ];

        return $map[$mode] ?? $mode;
    }

    private function plainTextToHtml(?string $text): ?string
    {
        if ($text === null || trim($text) === '') {
            return $text;
        }

        if (preg_match('/<[a-z][\s\S]*>/i', $text)) {
            return $text;
        }

        $paragraphs = preg_split('/\r\n|\r|\n/', $text);
        $html = '';

        foreach ($paragraphs as $paragraph) {
            $paragraph = trim($paragraph);
            if ($paragraph !== '') {
                $html .= '<p>' . htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8') . '</p>';
            }
        }

        return $html !== '' ? $html : $text;
    }

    private function sanitizeRichHtml(?string $html): ?string
    {
        if ($html === null || $html === '') {
            return $html;
        }

        $allowed = '<p><br><strong><b><em><i><u><ul><ol><li>';
        $clean = strip_tags($html, $allowed);
        $clean = preg_replace('#<([a-z]+)\b[^>]*>#i', '<$1>', $clean) ?? $clean;
        $clean = str_replace('&nbsp;', ' ', $clean);
        $clean = preg_replace('/\s{2,}/u', ' ', $clean) ?? $clean;
        $clean = preg_replace('#<p>\s*</p>#i', '', $clean) ?? $clean;

        return trim($clean);
    }

    private function toBool($value): int
    {
        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        $normalized = strtolower(trim((string) $value));

        return in_array($normalized, ['1', 'true', 'yes', 'y', 'on'], true) ? 1 : 0;
    }

    private function nullableString($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function nullableNumeric($value)
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        return $value;
    }
}
