<?php

namespace App\Exports;

use App\Exports\Sheets\JobsAllowedValuesSheet;
use App\Exports\Sheets\JobsTemplateJobsSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class JobsTemplateExport implements WithMultipleSheets
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

    public function sheets(): array
    {
        return [
            new JobsTemplateJobsSheet($this->countries, $this->awards, $this->perks),
            new JobsAllowedValuesSheet(),
        ];
    }
}
