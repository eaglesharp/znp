<?php

namespace App\Exports;

use App\Exports\Sheets\JobsTemplateJobsSheet;
use Maatwebsite\Excel\Concerns\FromArray;

/**
 * Single-sheet CSV variant of the bulk-jobs template.
 *
 * CSV is used for the download because it opens natively in Google Sheets and
 * is resilient to byte-level transport quirks that corrupt binary .xls/.xlsx
 * files on some servers. It reuses the exact header + example rows from
 * JobsTemplateJobsSheet so the column set stays in one place.
 */
class JobsTemplateCsvExport implements FromArray
{
    /** @var array */
    private $countries;

    /** @var array */
    private $awards;

    /** @var array */
    private $perks;

    public function __construct(array $countries = [], array $awards = [], array $perks = [])
    {
        $this->countries = $countries;
        $this->awards = $awards;
        $this->perks = $perks;
    }

    public function array(): array
    {
        return (new JobsTemplateJobsSheet($this->countries, $this->awards, $this->perks))->array();
    }
}
