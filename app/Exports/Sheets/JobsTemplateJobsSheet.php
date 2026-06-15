<?php

namespace App\Exports\Sheets;

use App\Services\JobBulkUploadService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class JobsTemplateJobsSheet implements FromArray, WithTitle, WithEvents
{
    /** Number of rows the dropdown validation is applied to. */
    private const VALIDATION_ROWS = 200;

    /** @var string Comma-joined company countries of presence (prefilled). */
    private $countries;

    /** @var string Comma-joined company awards (prefilled). */
    private $awards;

    /** @var string Comma-joined company perks (prefilled). */
    private $perks;

    public function __construct(array $countries = [], array $awards = [], array $perks = [])
    {
        $this->countries = implode(', ', $countries);
        $this->awards = implode(', ', $awards);
        $this->perks = implode(', ', $perks);
    }

    public function array(): array
    {
        $headers = JobBulkUploadService::TEMPLATE_COLUMNS;

        $exampleOne = [
            'Senior Backend Engineer',
            'Hybrid',
            'Full Time / Permanent',
            'General Shift (9 AM – 6 PM)',
            12,
            18,
            0,
            2,
            3,
            7,
            'English',
            'direct',
            '',
            '',
            'Bangalore, Mumbai',
            'Andheri East',
            'PHP, Laravel, MySQL',
            'CV Screening, Video Interview, Technical Assessment',
            'Build and maintain backend services for a high-traffic hiring platform.',
            'Own API design, database performance, and production reliability.',
            'We are a fast-growing product company focused on zero-notice hiring.',
            'https://example.com',
            'Information Technology',
            '51–200',
            '123 Tech Park, Bangalore',
            '',
            '',
            '',
            'Current CTC, Expected CTC, Notice Period',
            0,
            $this->countries,
            $this->awards,
            $this->perks,
            1,
        ];

        $exampleTwo = [
            'Contract Java Developer',
            'Remote / WFH',
            'Contract',
            'US Shift (6 PM +)',
            10,
            14,
            0,
            1,
            4,
            8,
            'English & Hindi',
            'client',
            'Acme Corp',
            'Banking & Financial Services',
            '',
            '',
            'Java, Spring Boot, Microservices',
            'CV Screening, Client Interview',
            'Support banking APIs and microservices delivery for a client project.',
            '6-month renewable contract with strong extension possibility.',
            'We are a staffing firm placing engineers with enterprise clients.',
            'https://staffing.example.com',
            'Consulting',
            '201–500',
            '',
            '6 Months',
            3500,
            'Likely',
            'Notice Period, Current CTC',
            1,
            $this->countries,
            $this->awards,
            $this->perks,
            0,
        ];

        return [
            $headers,
            $exampleOne,
            $exampleTwo,
        ];
    }

    public function title(): string
    {
        return 'Jobs';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $columns = JobBulkUploadService::TEMPLATE_COLUMNS;
                $dropdowns = JobBulkUploadService::dropdownColumns();
                $lastRow = self::VALIDATION_ROWS + 1;

                foreach ($dropdowns as $field => $values) {
                    $position = array_search($field, $columns, true);
                    if ($position === false) {
                        continue;
                    }

                    $letter = Coordinate::stringFromColumnIndex($position + 1);
                    $list = '"' . implode(',', array_map('strval', $values)) . '"';

                    $validation = new DataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(true);
                    $validation->setShowDropDown(true);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setErrorTitle('Invalid value');
                    $validation->setError('Please choose a value from the dropdown list.');
                    $validation->setPromptTitle(str_replace('_', ' ', ucfirst($field)));
                    $validation->setPrompt('Choose a value from the list.');
                    $validation->setFormula1($list);

                    $sheet->setDataValidation($letter . '2:' . $letter . $lastRow, $validation);
                }
            },
        ];
    }
}
