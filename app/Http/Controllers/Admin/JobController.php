<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Job;
use App\PostJob;
use App\Company;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Controllers\Controller;
use App\Traits\JobTrait;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Exports\JobsTemplateExport;
use App\Exports\JobsTemplateCsvExport;
use App\Exports\JobsTemplateXlsxBuilder;
use App\Imports\JobsImport;
use App\Services\JobBulkUploadService;
use GeoIp2\Record\Postal;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class JobController extends Controller
{

    use JobTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexJobs(Request $request)
    {
        
        $jobs = PostJob::withCount('appliedUsers')->where('company_id',$request->company_id)->get();
        
        $countries = DataArrayHelper::defaultCountriesArray();
       
        return view('admin.job.index')
                        ->with('jobs', $jobs)
                        ->with('countries', $countries);
                        

                        
    }

    public function bulkJobsUpload(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $company = Company::findOrFail($request->company_id);

        return view('admin.job.bulk', [
            'company' => $company,
            'allowedValues' => JobBulkUploadService::allowedValues(),
        ]);
    }

    public function downloadJobsTemplate(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $company = Company::findOrFail($request->company_id);

        $countries = $this->decodeCompanyJsonList($company->countries_presence);
        $awards = $this->decodeCompanyJsonList($company->awards);
        $perks = $this->decodeCompanyJsonList($company->perks);

        /* Build the .xlsx with native ZipArchive (not PhpSpreadsheet's writer) so
           it works on PHP 7.4/8.0, keeps the dropdown data-validation the client
           needs, and opens cleanly in Google Sheets/Excel. */
        $path = (new JobsTemplateXlsxBuilder($countries, $awards, $perks))->build();

        return $this->streamBinaryDownload($path, 'bulk-jobs-template.xlsx');
    }

    /**
     * Stream a binary file to the browser in a way that survives shared/cPanel
     * servers which would otherwise corrupt the download.
     *
     * The root cause of the earlier "garbled on server" downloads was a stray
     * leading newline emitted into every response (a blank line before <?php in
     * a route file, since fixed). As a defensive belt-and-suspenders against any
     * other stray output (e.g. a PHP 7.4 notice) or server-side gzip mangling a
     * payload that is already a zip, we disable output compression and discard
     * any pending output buffers immediately before streaming the raw bytes.
     */
    private function streamBinaryDownload(string $path, string $downloadName)
    {
        $size = (int) filesize($path);

        return response()->streamDownload(function () use ($path) {
            @ini_set('zlib.output_compression', 'Off');

            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            readfile($path);
            @unlink($path);
        }, $downloadName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Length' => (string) $size,
            'Cache-Control' => 'must-revalidate, no-store, no-cache, private',
            'Pragma' => 'public',
            'Expires' => '0',
        ]);
    }

    private function decodeCompanyJsonList($value): array
    {
        if (is_array($value)) {
            return array_values(array_filter(array_map('trim', $value), 'strlen'));
        }

        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);
        if (! is_array($decoded)) {
            return [];
        }

        return array_values(array_filter(array_map(function ($item) {
            return trim((string) $item);
        }, $decoded), 'strlen'));
    }

    public function bulkJobsImport(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'file' => 'required|file|mimes:xlsx,xls,csv,txt',
        ], [
            'file.required' => 'Please upload an Excel or CSV file.',
            'file.mimes' => 'The file must be an Excel or CSV file.',
        ]);

        $company = Company::findOrFail($request->company_id);
        $import = new JobsImport($company);

        Excel::import($import, $request->file('file'));

        $successCount = $import->getSuccessCount();
        $failures = $import->getFailures();

        $message = $successCount . ' job' . ($successCount === 1 ? '' : 's') . ' imported successfully.';
        if (count($failures)) {
            $message .= ' ' . count($failures) . ' row' . (count($failures) === 1 ? '' : 's') . ' skipped.';
        }

        return redirect()
            ->route('bulk.jobs.upload', ['company_id' => $company->id])
            ->with('bulk_import_success', $message)
            ->with('bulk_import_success_count', $successCount)
            ->with('bulk_import_failures', $failures);
    }

    public function jobsGrid(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $company = Company::findOrFail($request->company_id);

        return view('admin.job.grid', [
            'company' => $company,
            'allowedValues' => JobBulkUploadService::allowedValues(),
        ]);
    }

    public function storeJobsGrid(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $company = Company::findOrFail($request->company_id);
        $service = new JobBulkUploadService();

        $rows = (array) $request->input('jobs', []);
        $successCount = 0;
        $failures = [];

        foreach (array_values($rows) as $index => $rawRow) {
            if (! is_array($rawRow)) {
                continue;
            }

            $normalized = $service->normalizeRow($rawRow);
            if ($this->isBlankGridRow($normalized)) {
                continue;
            }

            $prepared = $service->prepareForValidation($normalized);
            $validator = \Validator::make(
                $prepared,
                $service->validationRules($prepared),
                $service->validationMessages()
            );

            if ($validator->fails()) {
                $failures[] = [
                    'row' => $index + 1,
                    'job_title' => $prepared['job_title'] ?? null,
                    'errors' => $validator->errors()->all(),
                ];
                continue;
            }

            try {
                $service->store($company, $prepared);
                $successCount++;
            } catch (\Throwable $exception) {
                $failures[] = [
                    'row' => $index + 1,
                    'job_title' => $prepared['job_title'] ?? null,
                    'errors' => [$exception->getMessage()],
                ];
            }
        }

        if ($successCount === 0 && count($failures)) {
            return redirect()
                ->route('jobs.grid', ['company_id' => $company->id])
                ->withInput()
                ->with('grid_failures', $failures)
                ->with('grid_error', 'No jobs were saved. Please fix the highlighted rows and try again.');
        }

        $message = $successCount . ' job' . ($successCount === 1 ? '' : 's') . ' created successfully.';
        if (count($failures)) {
            $message .= ' ' . count($failures) . ' row' . (count($failures) === 1 ? '' : 's') . ' skipped.';
        }

        return redirect()
            ->route('list.jobs', ['company_id' => $company->id])
            ->with('bulk_import_success', $message)
            ->with('bulk_import_failures', $failures);
    }

    private function isBlankGridRow(array $row): bool
    {
        foreach ($row as $value) {
            if (is_array($value)) {
                if (count(array_filter($value, static function ($item) {
                    return trim((string) $item) !== '';
                }))) {
                    return false;
                }
                continue;
            }

            if ($value !== null && trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    public function fetchJobsData(Request $request)
    {
      //  dd($request->all());
        $jobs = PostJob::get();
      //  dd($jobs);
        return Datatables::of($jobs)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('company_id') && !empty($request->company_id)) {
                                $query->where('jobs.company_id', '=', "{$request->get('company_id')}");
                            }
                            if ($request->has('title') && !empty($request->title)) {
                                $query->where('jobs.job_title', 'like', "%{$request->get('title')}%");
                            }
                            if ($request->has('description') && !empty($request->description)) {
                                $query->where('jobs.job_description', 'like', "%{$request->get('description')}%");
                            }
                          
                          
                            // if ($request->has('status') && $request->status != -1) {
                            //     $query->where('jobs.status', '=', "{$request->get('status')}");
                            // }
                          
                        })
                        ->addColumn('company_id', function ($jobs) {
                            return $jobs->getCompany('name');
                        })
                       
                        ->addColumn('description', function ($jobs) {
                            return strip_tags(Str::limit($jobs->description, 50, '...'));
                        })
                        ->addColumn('action', function ($jobs) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $jobs->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $jobs->status == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $jobs->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            $featuredTxt = 'Make Featured';
                            $featuredHref = 'makeFeatured(' . $jobs->id . ');';
                            $featuredIcon = 'square-o';
                            if ((int) $jobs->is_featured == 1) {
                                $featuredTxt = 'Make Not Featured';
                                $featuredHref = 'makeNotFeatured(' . $jobs->id . ');';
                                $featuredIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.job', ['id' => $jobs->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteJob(' . $jobs->id . ', ' . $jobs->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $jobs->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $featuredHref . '" id="onclickFeatured' . $jobs->id . '"><i class="fa fa-' . $featuredIcon . '" aria-hidden="true"></i>' . $featuredTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'company_id', 'city_id', 'description'])
                        ->setRowId(function($jobs) {
                            return 'jobDtRow' . $jobs->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_active = 1;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_active = 0;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeFeaturedJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_featured = 1;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotFeaturedJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_featured = 0;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

}
