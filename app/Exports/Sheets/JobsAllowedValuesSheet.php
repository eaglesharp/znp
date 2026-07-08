<?php

namespace App\Exports\Sheets;

use App\Services\JobBulkUploadService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class JobsAllowedValuesSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $rows = [
            ['Field', 'Allowed Value'],
        ];

        foreach (JobBulkUploadService::allowedValues() as $field => $values) {
            foreach ($values as $value) {
                $rows[] = [$field, $value];
            }
        }

        $rows[] = ['notes', 'Use comma-separated values for location, keyskills, interview_modes, profile_requirements, countries_presence, awards, and perks.'];
        $rows[] = ['notes', 'compensation_confidential, strict_mode and video_question_enabled accept 0/1, yes/no, or true/false.'];
        $rows[] = ['notes', 'video_question_enabled: 1 includes the optional video-introduction question, 0 hides it. The other two screening questions are always included.'];
        $rows[] = ['notes', 'countries_presence, awards and perks are pre-filled from the company profile; edit them if needed.'];
        $rows[] = ['notes', 'posting_type must be direct or client. client_industry is required when posting_type=client.'];
        $rows[] = ['notes', 'location is optional only when work_mode is Remote / WFH.'];

        return $rows;
    }

    public function title(): string
    {
        return 'Allowed Values';
    }
}
