@php
    /** @var string|int $i */
    /** @var array $allowedValues */
    $row = $row ?? [];
    $isTemplate = ($i === '__INDEX__');
    $val = function ($key, $default = '') use ($row, $isTemplate) {
        if ($isTemplate) {
            return $default;
        }
        return $row[$key] ?? $default;
    };
    $arr = function ($key) use ($row, $isTemplate) {
        if ($isTemplate) {
            return [];
        }
        $v = $row[$key] ?? [];
        return is_array($v) ? $v : array_filter(array_map('trim', explode(',', (string) $v)));
    };
    $sel = function ($current, $option) {
        return (string) $current === (string) $option ? 'selected' : '';
    };
@endphp
<div class="portlet light bordered job-card" data-index="{{ $i }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-briefcase"></i>
            <span class="caption-subject bold uppercase">Job <span class="job-card-num"></span></span>
        </div>
        <div class="actions">
            <button type="button" class="btn btn-xs btn-danger remove-card"><i class="fa fa-trash-o"></i> Remove</button>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="bold">Job Title <span style="color:#e7505a">*</span></label>
                <input type="text" name="jobs[{{ $i }}][job_title]" class="form-control" value="{{ $val('job_title') }}" placeholder="e.g. Senior Backend Engineer">
            </div>
            <div class="col-md-3 form-group">
                <label class="bold">Mode of Work <span style="color:#e7505a">*</span></label>
                <select name="jobs[{{ $i }}][work_mode]" class="form-control">
                    <option value="">— Select —</option>
                    @foreach ($allowedValues['work_mode'] as $opt)
                        <option value="{{ $opt }}" {{ $sel($val('work_mode'), $opt) }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label class="bold">Job Type <span style="color:#e7505a">*</span></label>
                <select name="jobs[{{ $i }}][job_type]" class="form-control">
                    <option value="">— Select —</option>
                    @foreach ($allowedValues['job_type'] as $opt)
                        <option value="{{ $opt }}" {{ $sel($val('job_type'), $opt) }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <label class="bold">Job Shift <span style="color:#e7505a">*</span></label>
                <select name="jobs[{{ $i }}][job_shift]" class="form-control">
                    <option value="">— Select —</option>
                    @foreach ($allowedValues['job_shift'] as $opt)
                        <option value="{{ $opt }}" {{ $sel($val('job_shift'), $opt) }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 form-group">
                <label class="bold">Primary Work Language <span style="color:#e7505a">*</span></label>
                <select name="jobs[{{ $i }}][primary_language]" class="form-control">
                    <option value="">— Select —</option>
                    @foreach ($allowedValues['primary_language'] as $opt)
                        <option value="{{ $opt }}" {{ $sel($val('primary_language'), $opt) }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 form-group">
                <label class="bold">Posting Type <span style="color:#e7505a">*</span></label>
                <select name="jobs[{{ $i }}][posting_type]" class="form-control posting-type">
                    <option value="">— Select —</option>
                    @foreach ($allowedValues['posting_type'] as $opt)
                        <option value="{{ $opt }}" {{ $sel($val('posting_type'), $opt) }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row client-fields">
            <div class="col-md-6 form-group">
                <label class="bold">Client Company Name</label>
                <input type="text" name="jobs[{{ $i }}][client_name]" class="form-control" value="{{ $val('client_name') }}" placeholder="Leave blank to show as Confidential">
            </div>
            <div class="col-md-6 form-group">
                <label class="bold">Client Industry <span class="client-req" style="color:#e7505a">*</span></label>
                <select name="jobs[{{ $i }}][client_industry]" class="form-control">
                    <option value="">— Select —</option>
                    @foreach ($allowedValues['client_industry'] as $opt)
                        <option value="{{ $opt }}" {{ $sel($val('client_industry'), $opt) }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 form-group">
                <label class="bold">Min Salary (LPA) <span style="color:#e7505a">*</span></label>
                <input type="number" step="0.1" min="0" name="jobs[{{ $i }}][min_salary]" class="form-control" value="{{ $val('min_salary') }}">
            </div>
            <div class="col-md-3 form-group">
                <label class="bold">Max Salary (LPA) <span style="color:#e7505a">*</span></label>
                <input type="number" step="0.1" min="0" name="jobs[{{ $i }}][max_salary]" class="form-control" value="{{ $val('max_salary') }}">
            </div>
            <div class="col-md-2 form-group">
                <label class="bold">Openings <span style="color:#e7505a">*</span></label>
                <input type="number" min="1" name="jobs[{{ $i }}][no_of_openings]" class="form-control" value="{{ $val('no_of_openings', 1) }}">
            </div>
            <div class="col-md-2 form-group">
                <label class="bold">Min Exp (yrs) <span style="color:#e7505a">*</span></label>
                <input type="number" step="0.5" min="0" name="jobs[{{ $i }}][exp_min]" class="form-control" value="{{ $val('exp_min') }}">
            </div>
            <div class="col-md-2 form-group">
                <label class="bold">Max Exp (yrs)</label>
                <input type="number" step="0.5" min="0" name="jobs[{{ $i }}][exp_max]" class="form-control" value="{{ $val('exp_max') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="bold">Locations <span style="color:#e7505a">*</span> <small class="text-muted">(comma separated, not needed for Remote / WFH)</small></label>
                <input type="text" name="jobs[{{ $i }}][location]" class="form-control" value="{{ is_array($row['location'] ?? null) ? implode(', ', $row['location']) : $val('location') }}" placeholder="e.g. Bangalore, Mumbai">
            </div>
            <div class="col-md-3 form-group">
                <label class="bold">Locality / Area</label>
                <input type="text" name="jobs[{{ $i }}][locality]" class="form-control" value="{{ $val('locality') }}" placeholder="e.g. Andheri East">
            </div>
            <div class="col-md-3 form-group">
                <label class="bold">Website <span style="color:#e7505a">*</span></label>
                <input type="text" name="jobs[{{ $i }}][website_address]" class="form-control" value="{{ $val('website_address') }}" placeholder="https://example.com">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 form-group">
                <label class="bold">Skills Required <span style="color:#e7505a">*</span> <small class="text-muted">(comma separated)</small></label>
                <input type="text" name="jobs[{{ $i }}][keyskills]" class="form-control" value="{{ is_array($row['keyskills'] ?? null) ? implode(', ', $row['keyskills']) : $val('keyskills') }}" placeholder="e.g. PHP, Laravel, MySQL">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="bold">Mode of Interview <span style="color:#e7505a">*</span></label>
                <div class="checkbox-grid">
                    @foreach ($allowedValues['interview_modes'] as $opt)
                        <label class="checkbox-inline" style="display:block;margin-left:0;">
                            <input type="checkbox" name="jobs[{{ $i }}][interview_modes][]" value="{{ $opt }}" {{ in_array($opt, $arr('interview_modes')) ? 'checked' : '' }}> {{ $opt }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label class="bold">Candidate Profile Requirements <span style="color:#e7505a">*</span></label>
                <div class="checkbox-grid">
                    @foreach ($allowedValues['profile_requirements'] as $opt)
                        <label class="checkbox-inline" style="display:block;margin-left:0;">
                            <input type="checkbox" name="jobs[{{ $i }}][profile_requirements][]" value="{{ $opt }}" {{ in_array($opt, $arr('profile_requirements')) ? 'checked' : '' }}> {{ $opt }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <label class="bold">Industry</label>
                <input type="text" name="jobs[{{ $i }}][industry]" class="form-control" value="{{ $val('industry') }}">
            </div>
            <div class="col-md-4 form-group">
                <label class="bold">Headcount</label>
                <input type="text" name="jobs[{{ $i }}][headcount]" class="form-control" value="{{ $val('headcount') }}" placeholder="e.g. 51–200">
            </div>
            <div class="col-md-4 form-group">
                <label class="bold">Office Address</label>
                <input type="text" name="jobs[{{ $i }}][office_address]" class="form-control" value="{{ $val('office_address') }}">
            </div>
        </div>

        <div class="row contract-fields">
            <div class="col-md-4 form-group">
                <label class="bold">Contract Duration</label>
                <select name="jobs[{{ $i }}][contract_duration]" class="form-control">
                    <option value="">— Select —</option>
                    @foreach ($allowedValues['contract_duration'] as $opt)
                        <option value="{{ $opt }}" {{ $sel($val('contract_duration'), $opt) }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 form-group">
                <label class="bold">Day Rate (₹)</label>
                <input type="number" min="0" name="jobs[{{ $i }}][contract_day_rate]" class="form-control" value="{{ $val('contract_day_rate') }}">
            </div>
            <div class="col-md-4 form-group">
                <label class="bold">Extension Possibility</label>
                <select name="jobs[{{ $i }}][contract_extension]" class="form-control">
                    <option value="">— Select —</option>
                    @foreach ($allowedValues['contract_extension'] as $opt)
                        <option value="{{ $opt }}" {{ $sel($val('contract_extension'), $opt) }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="bold">Job Description <span style="color:#e7505a">*</span></label>
                <textarea name="jobs[{{ $i }}][job_description]" rows="4" class="form-control" placeholder="Summary of the role and responsibilities.">{{ $val('job_description') }}</textarea>
            </div>
            <div class="col-md-6 form-group">
                <label class="bold">Job Overview <span style="color:#e7505a">*</span></label>
                <textarea name="jobs[{{ $i }}][job_overview]" rows="4" class="form-control" placeholder="A short overview candidates see first.">{{ $val('job_overview') }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 form-group">
                <label class="bold">About Company <span style="color:#e7505a">*</span></label>
                <textarea name="jobs[{{ $i }}][about_company]" rows="3" class="form-control">{{ $val('about_company') }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 form-group">
                <label class="checkbox-inline" style="margin-left:0;">
                    <input type="hidden" name="jobs[{{ $i }}][compensation_confidential]" value="0">
                    <input type="checkbox" name="jobs[{{ $i }}][compensation_confidential]" value="1" {{ (int) $val('compensation_confidential') === 1 ? 'checked' : '' }}> Keep compensation confidential
                </label>
            </div>
            <div class="col-md-3 form-group">
                <label class="checkbox-inline" style="margin-left:0;">
                    <input type="hidden" name="jobs[{{ $i }}][strict_mode]" value="0">
                    <input type="checkbox" name="jobs[{{ $i }}][strict_mode]" value="1" {{ (int) $val('strict_mode') === 1 ? 'checked' : '' }}> Strict mode
                </label>
            </div>
        </div>
    </div>
</div>
