@php
    $company     = $job->company;
    $companyName = $company->name ?? '';
    $initials    = strtoupper(mb_substr(preg_replace('/[^A-Za-z0-9]/', '', $companyName), 0, 3)) ?: 'JOB';
    $avColors    = ['av-1','av-2','av-3','av-4','av-5','av-6','av-7','av-8'];
    $avClass     = $avColors[rand(0, count($avColors)-1)];
    $jobTypeName = $job->job_type ?? '';
    $typeClass   = (stripos($jobTypeName, 'contract') !== false) ? 't-contract' : 't-full';
    $wm          = $job->work_mode ?? '';
    $workMode    = (stripos($wm, 'remote') !== false) ? 'Remote'
                 : ((stripos($wm, 'hybrid') !== false) ? 'Hybrid' : 'Work from office');
    $workClass   = (stripos($wm, 'remote') !== false) ? 't-remote'
                 : ((stripos($wm, 'hybrid') !== false) ? 't-hybrid' : 't-wfo');
    $expName     = $job->experience ?? '';
    $minSal      = $job->min_salary;
    $maxSal      = $job->max_salary;
    $salaryStr   = ($minSal && $maxSal) ? $minSal . '–' . $maxSal . ' LPA'
                 : ($minSal ? $minSal . '+ LPA' : '');
    // location is sometimes serialized PHP array
    $rawLoc      = $job->location ?? '';
    $locAllParts = (@unserialize($rawLoc) !== false && is_array(@unserialize($rawLoc)))
                 ? @unserialize($rawLoc)
                 : array_map('trim', explode(',', $rawLoc));
    $locAllParts = array_values(array_filter($locAllParts));
    $locDisplay  = (count($locAllParts) > 3)
                 ? implode(', ', array_slice($locAllParts, 0, 3)) . '...'
                 : implode(', ', $locAllParts);
    $isNew       = $job->created_at && $job->created_at->diffInDays(now()) <= 7;
    $cityNormMap2 = ['bangalore' => 'bengaluru', 'bengaluru' => 'bengaluru',
                     'hyderabad' => 'hyderabad', 'secunderabad' => 'hyderabad',
                     'chennai' => 'chennai', 'mumbai' => 'mumbai',
                     'navi mumbai' => 'mumbai', 'andheri' => 'mumbai',
                     'delhi' => 'delhi', 'noida' => 'delhi', 'ncr' => 'delhi',
                     'gurgaon' => 'gurgaon', 'gurugram' => 'gurgaon',
                     'pune' => 'pune', 'kolkata' => 'kolkata'];
    $citySlugs = [];
    $hasNonMetro = false;
    if ($locAllParts) {
        foreach ($locAllParts as $singleLoc) {
            $matchedMetro = false;
            foreach ($cityNormMap2 as $kw => $slug) {
                if (stripos($singleLoc, $kw) !== false) {
                    $citySlugs[] = $slug;
                    $matchedMetro = true;
                }
            }
            if (!$matchedMetro && trim($singleLoc) !== '') $hasNonMetro = true;
        }
    }
    if ($hasNonMetro) $citySlugs[] = 'others';
    $citySlug = implode(' ', array_values(array_unique($citySlugs)));
@endphp
<a class="job-card" href="{{ url('/job/' . $job->slug) }}" data-cat="{{ $citySlug }}">
    <div class="jc-top">
        <div class="jc-avatar {{ $avClass }}">{{ $initials }}</div>
        <div class="jc-meta">
            <div class="jc-title">{{ $job->job_title }}</div>
            <div class="jc-company">{{ $companyName }}</div>
            @if ($locDisplay)<div class="jc-loc">{{ $locDisplay }}</div>@endif
        </div>
    </div>
    <div class="jc-bottom">
        <div class="jc-tags">
            <span class="tag {{ $workClass }}">{{ $workMode }}</span>
            @if ($jobTypeName)
                <span class="tag {{ $typeClass }}">{{ $jobTypeName }}</span>
            @endif
            @if ($isNew)
                <span class="tag t-new">New</span>
            @endif
        </div>
        <div class="jc-footer">
            <span class="jc-exp">
                @if ($expName)<span class="jc-exp-lbl">Exp. required:</span> {{ $expName }} &nbsp;&middot;&nbsp;@endif
                <span class="salary">{{ $salaryStr }}</span>
            </span>
            <button class="btn-apply" type="button" onclick="event.preventDefault(); window.location.href='{{ url('/job/' . $job->slug) }}'">Apply now</button>
        </div>
    </div>
</a>
