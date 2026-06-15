@extends('admin.layouts.admin_layout')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                <li> <a href="{{ route('list.jobs', ['company_id' => $company->id]) }}">Jobs</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Bulk Upload Jobs</span> </li>
            </ul>
        </div>

        <h3 class="page-title">Bulk Upload Jobs <small>{{ $company->name }}</small></h3>

        @include('flash::message')

        @if (session('bulk_import_success'))
            <div class="alert alert-success">
                {{ session('bulk_import_success') }}
            </div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        <div class="row">
            <div class="col-md-8">
                <form action="{{ route('bulk.jobs.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ $company->id }}">

                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">Upload Jobs Spreadsheet</span>
                                <a href="{{ route('bulk.jobs.template', ['company_id' => $company->id]) }}" class="btn btn-xs btn-success">Download Template</a>
                                {{-- Web grid hidden for now — re-enable later
                                <a href="{{ route('jobs.grid', ['company_id' => $company->id]) }}" class="btn btn-xs btn-info">Use Web Grid Instead</a>
                                --}}
                                <a href="{{ route('list.jobs', ['company_id' => $company->id]) }}" class="btn btn-xs btn-default">Back to Manage Jobs</a>
                            </div>
                        </div>

                        <div class="portlet-body">
                            <p class="help-block">
                                Upload an Excel or CSV file using the template. Each row creates one published job for
                                <strong>{{ $company->name }}</strong>. Valid rows are imported immediately; invalid rows are skipped and listed below.
                            </p>

                            <div class="form-group">
                                <label for="file" class="bold">Excel / CSV File</label>
                                <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                            </div>

                            <button type="submit" class="btn btn-large btn-primary">
                                Upload Jobs <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject bold uppercase">Instructions</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <ul style="padding-left:18px;">
                            <li>Download the template and fill one job per row on the <strong>Jobs</strong> sheet.</li>
                            <li>Use comma-separated values for <code>location</code>, <code>keyskills</code>, <code>interview_modes</code>, <code>profile_requirements</code>, <code>countries_presence</code>, <code>awards</code>, and <code>perks</code>.</li>
                            <li>See the <strong>Allowed Values</strong> sheet for valid dropdown options.</li>
                            <li><code>location</code> is required unless <code>work_mode</code> is <strong>Remote / WFH</strong>.</li>
                            <li><code>client_industry</code> is required when <code>posting_type</code> is <strong>client</strong>.</li>
                            <li>Description fields can be plain text; line breaks are converted to paragraphs.</li>
                            <li><code>countries_presence</code>, <code>awards</code>, and <code>perks</code> are pre-filled from <strong>{{ $company->name }}</strong>'s profile — edit them if needed.</li>
                            <li><code>video_question_enabled</code>: set <code>1</code> to include the optional "video introduction" question, or <code>0</code> to hide it. The other two screening questions are always included.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @if (session('bulk_import_failures') && count(session('bulk_import_failures')))
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bold uppercase">Skipped Rows</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Row</th>
                                            <th>Job Title</th>
                                            <th>Errors</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (session('bulk_import_failures') as $failure)
                                            <tr>
                                                <td>{{ $failure['row'] ?? '—' }}</td>
                                                <td>{{ $failure['job_title'] ?? '—' }}</td>
                                                <td>
                                                    <ul style="margin:0;padding-left:18px;">
                                                        @foreach (($failure['errors'] ?? []) as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject bold uppercase">Allowed Values Reference</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            @foreach ($allowedValues as $field => $values)
                                <div class="col-md-4" style="margin-bottom:16px;">
                                    <strong>{{ str_replace('_', ' ', ucfirst($field)) }}</strong>
                                    <ul style="padding-left:18px;margin-top:6px;">
                                        @foreach ($values as $value)
                                            <li>{{ $value }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
