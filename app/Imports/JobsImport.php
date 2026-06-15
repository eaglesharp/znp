<?php

namespace App\Imports;

use App\Company;
use App\Services\JobBulkUploadService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobsImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    /** @var Company */
    private $company;

    /** @var JobBulkUploadService */
    private $service;

    /** @var int */
    private $successCount = 0;

    /** @var array<int, array{row:int, job_title:?string, errors:array}> */
    private $failures = [];

    public function __construct(Company $company)
    {
        $this->company = $company;
        $this->service = new JobBulkUploadService();
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $excelRow = $index + 2;
            $normalized = $this->service->normalizeRow($row->toArray());

            if ($this->isBlankRow($normalized)) {
                continue;
            }

            $prepared = $this->service->prepareForValidation($normalized);
            $validator = Validator::make($prepared, $this->service->validationRules($prepared), $this->service->validationMessages());

            if ($validator->fails()) {
                $this->failures[] = [
                    'row' => $excelRow,
                    'job_title' => $prepared['job_title'] ?? null,
                    'errors' => $validator->errors()->all(),
                ];
                continue;
            }

            try {
                $this->service->store($this->company, $prepared);
                $this->successCount++;
            } catch (\Throwable $exception) {
                $this->failures[] = [
                    'row' => $excelRow,
                    'job_title' => $prepared['job_title'] ?? null,
                    'errors' => [$exception->getMessage()],
                ];
            }
        }
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getFailures(): array
    {
        return $this->failures;
    }

    private function isBlankRow(array $row): bool
    {
        /* Ignore the company-prefilled columns (countries_presence, awards,
           perks): the template seeds them on every row, so a row that has only
           those filled is an untouched template row and should be skipped. */
        $ignore = JobBulkUploadService::COMPANY_PREFILL_COLUMNS;

        foreach ($row as $key => $value) {
            if (in_array($key, $ignore, true)) {
                continue;
            }

            if ($value !== null && trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }
}
