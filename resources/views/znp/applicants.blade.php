@extends('layouts.znp')

@section('page_title', ($job->job_title ?? 'Job') . ' — Applicants | ZeroNoticePeriod')

@php
    $words = preg_split('/\s+/', trim($company->name ?? 'ZNP'));
    $companyInitials = '';
    foreach (array_slice($words, 0, 2) as $w) {
        $companyInitials .= $w !== '' ? strtoupper(mb_substr($w, 0, 1)) : '';
    }
    $companyInitials = $companyInitials ?: 'ZN';

    $jobLocations = [];
    if (! empty($job->location)) {
        $u = @unserialize($job->location);
        $jobLocations = is_array($u) ? array_values($u) : [(string) $job->location];
    }
    $jobLocationLabel = ! empty($jobLocations) ? implode(', ', array_slice($jobLocations, 0, 2)) : ($job->locality ?? '—');

    $salaryLabel = '—';
    if ($job->compensation_confidential ?? false) {
        $salaryLabel = 'Confidential';
    } elseif ($job->min_salary || $job->max_salary) {
        $salaryLabel = '₹' . ($job->min_salary ?? '?') . '–' . ($job->max_salary ?? '?') . ' LPA';
    }

    $expLabel = ($job->exp_min !== null && $job->exp_max !== null)
        ? rtrim(rtrim(number_format((float) $job->exp_min, 1), '0'), '.') . '–' . rtrim(rtrim(number_format((float) $job->exp_max, 1), '0'), '.') . ' yrs exp'
        : ($job->experience ?? '');

    $workModeLabel = $job->work_mode ?? '';
    $postedLabel = $job->created_at ? $job->created_at->format('M j, Y') : '—';
    $filterCounts = $filterCounts ?? [];
    $jobListing = $jobListing ?? ['days_left' => 0, 'listing_days' => 90, 'label' => ''];
    $znpPlan = $znpPlan ?? [];
    $planSubLabel = '';
    if (! empty($znpPlan['has_plan']) && empty($znpPlan['is_unlimited'])) {
        $planSubLabel = ($znpPlan['plan_name'] ?? 'Plan') . ' · ' . ($znpPlan['posts_remaining'] ?? 0) . ' posts remaining';
    } elseif (! empty($znpPlan['plan_name'])) {
        $planSubLabel = $znpPlan['plan_name'];
    }

    $apStageTabs = [
        'all'         => 'All',
        'new'         => 'New',
        'shortlisted' => 'Shortlisted',
        'interview'   => 'Interview',
        'offer'       => 'Offer',
        'contractor'  => 'Contractors',
        'rejected'    => 'Rejected',
    ];
@endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
.znp-ap,.znp-ap *{box-sizing:border-box;font-family:'Manrope',sans-serif;-webkit-font-smoothing:antialiased}
.znp-ap{--blue:#3B5CCC;--blue-d:#2d47a3;--blue-50:#EEF1FB;--blue-100:#D6DEFC;--orange:#F2994A;--green:#15803d;--green-50:#f0fdf4;--green-100:#dcfce7;--red:#dc2626;--red-50:#fef2f2;--amber:#d97706;--amber-50:#fffbeb;--purple:#7c3aed;--purple-50:#f5f3ff;--bg:#F7F8FC;--surface:#fff;--border:#E7EAF3;--text:#2F3443;--t2:#4A5068;--t3:#717A96;--t4:#A0AABF;--r:12px;--r-sm:8px;--sh:0 1px 3px rgba(59,92,204,.05);--sh-md:0 4px 16px rgba(59,92,204,.08);background:var(--bg);color:var(--text);font-size:12.5px;min-height:100vh}
.znp-ap a{text-decoration:none;color:inherit}
.znp-ap .nav{background:var(--surface);border-bottom:1px solid var(--border);padding:0 28px;height:56px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;box-shadow:var(--sh)}
.znp-ap .logo{font-size:16px;font-weight:800;letter-spacing:-.3px}
.znp-ap .la,.znp-ap .lc{color:var(--blue)}.znp-ap .lb{color:var(--orange)}
.znp-ap .nav-r{display:flex;align-items:center;gap:8px}
.znp-ap .nbtn{padding:6px 16px;border-radius:50px;font-size:12px;font-weight:600;cursor:pointer;border:none;font-family:inherit;transition:all .15s}
.znp-ap .nb-ghost{background:transparent;border:1.5px solid var(--border);color:var(--t2)}
.znp-ap .nb-primary{background:var(--orange);color:#fff}
.znp-ap .nav-av{width:30px;height:30px;border-radius:50%;background:var(--blue);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.znp-ap .nav-av-wrap{position:relative}
.znp-ap .av-menu{display:none;position:absolute;top:calc(100% + 8px);right:0;background:var(--surface);border:1px solid var(--border);border-radius:var(--r-sm);box-shadow:0 8px 24px rgba(15,23,42,.12);min-width:190px;z-index:200;overflow:hidden}
.znp-ap .nav-av-wrap.open .av-menu{display:block}
.znp-ap .av-menu-company{padding:10px 14px 8px;font-size:11.5px;font-weight:700;color:var(--text);border-bottom:1px solid var(--border)}
.znp-ap .av-menu-company span{display:block;font-size:10.5px;font-weight:500;color:var(--t3);margin-top:1px}
.znp-ap .av-menu-item{padding:9px 14px;font-size:12.5px;font-weight:500;color:var(--t2);cursor:pointer;display:flex;align-items:center;gap:8px}
.znp-ap .av-menu-item:hover{background:var(--bg);color:var(--text)}
.znp-ap .av-menu-item.logout{color:var(--red);border-top:1px solid var(--border)}
.znp-ap .jb-repost{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:600;color:#92400e;background:#fffbeb;border:1px solid var(--amber-100);border-radius:50px;padding:2px 10px}
.znp-ap .metric-item{padding:11px 20px;border-right:1px solid var(--border);text-align:center;flex-shrink:0;min-width:96px;cursor:pointer;transition:background .15s}
.znp-ap .metric-item:hover{background:var(--blue-50)}
.znp-ap .metric-item.active{border-bottom:2px solid var(--blue);background:var(--blue-50)}
.znp-ap .crumb{background:var(--surface);border-bottom:1px solid var(--border);padding:6px 28px;font-size:11.5px;color:var(--t4)}
.znp-ap .crumb-inner{max-width:1360px;margin:0 auto;display:flex;align-items:center;gap:5px}
.znp-ap .crumb a{color:var(--blue);font-weight:600}
.znp-ap .job-banner{background:var(--surface);border-bottom:1px solid var(--border);padding:14px 28px}
.znp-ap .jb-inner{max-width:1360px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
.znp-ap .jb-left{display:flex;align-items:flex-start;gap:14px}
.znp-ap .jb-av{width:44px;height:44px;border-radius:10px;background:var(--blue-50);border:1px solid var(--blue-100);color:var(--blue);font-size:14px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.znp-ap .jb-title{font-size:15px;font-weight:800;margin-bottom:6px}
.znp-ap .jb-pills{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:5px}
.znp-ap .jb-pill{display:inline-flex;font-size:11.5px;font-weight:500;padding:3px 10px;border-radius:50px;border:1px solid var(--border);background:var(--bg);color:var(--t2)}
.znp-ap .jb-pill.blue{background:var(--blue-50);color:var(--blue);border-color:var(--blue-100)}
.znp-ap .jb-pill.green{background:var(--green-50);color:var(--green);border-color:var(--green-100)}
.znp-ap .jb-actions{display:flex;gap:7px;flex-wrap:wrap}
.znp-ap .act-btn{padding:7px 14px;border-radius:50px;font-size:12px;font-weight:600;cursor:pointer;border:1.5px solid var(--border);background:var(--surface);color:var(--t2)}
.znp-ap .act-btn.share{background:var(--blue-50);color:var(--blue);border-color:var(--blue-100)}
.znp-ap .act-btn.viewjob{background:var(--green-50);color:var(--green);border-color:var(--green-100)}
.znp-ap .act-btn.retire{background:var(--red-50);color:var(--red);border-color:var(--red-100)}
.znp-ap .metrics-bar{background:var(--surface);border-bottom:1px solid var(--border);padding:0 28px}
.znp-ap .metrics-inner{max-width:1360px;margin:0 auto;display:flex;overflow-x:auto}
.znp-ap .m-num{font-size:17px;font-weight:800;line-height:1.2}
.znp-ap .m-num.blue{color:var(--blue)}.znp-ap .m-num.green{color:var(--green)}.znp-ap .m-num.red{color:var(--red)}
.znp-ap .m-label{font-size:10.5px;color:var(--t4);font-weight:500;margin-top:3px}
.znp-ap .page{max-width:1360px;margin:0 auto;padding:18px 28px 56px;display:grid;grid-template-columns:236px 1fr;gap:18px;align-items:start}
.znp-ap .sidebar{position:sticky;top:112px;background:var(--surface);border:1px solid var(--border);border-radius:var(--r);overflow:hidden;box-shadow:var(--sh)}
.znp-ap .sb-head{padding:12px 16px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center}
.znp-ap .sb-title{font-size:13px;font-weight:700}
.znp-ap .sb-clear{font-size:11.5px;color:var(--blue);cursor:pointer;font-weight:600}
.znp-ap .sb-sec{padding:12px 16px;border-bottom:1px solid var(--border)}
.znp-ap .sb-sec-title{font-size:10px;font-weight:700;color:var(--t4);text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px}
.znp-ap .filter-opt{display:flex;align-items:center;gap:8px;padding:5px 0;cursor:pointer}
.znp-ap .fo-check{width:15px;height:15px;border:1.5px solid var(--blue-100);border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:9px;color:transparent}
.znp-ap .filter-opt.checked .fo-check{background:var(--blue);border-color:var(--blue);color:#fff}
.znp-ap .fo-label{font-size:12px;color:var(--t3);flex:1;font-weight:500}
.znp-ap .filter-opt.checked .fo-label{color:var(--text);font-weight:600}
.znp-ap .fo-count{font-size:11px;color:var(--t4);background:var(--bg);border-radius:50px;padding:1px 7px}
.znp-ap .range-row{display:flex;align-items:center;gap:6px;margin-bottom:6px}
.znp-ap .range-inp,.znp-ap .sb-search{flex:1;border:1px solid var(--border);border-radius:var(--r-sm);padding:6px 8px;font-size:12px;font-family:inherit;color:var(--text);outline:none;width:100%}
.znp-ap .toolbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:10px}
.znp-ap .tbtn,.znp-ap .sort-sel{padding:7px 16px;border-radius:50px;font-size:12px;font-weight:600;cursor:pointer;border:1.5px solid var(--blue-100);background:var(--blue-50);color:var(--blue);font-family:inherit}
.znp-ap .sort-sel{background:var(--surface);border-color:var(--border);color:var(--t2)}
.znp-ap .stage-tabs{display:flex;gap:6px;margin-bottom:14px;overflow-x:auto;padding-bottom:2px}
.znp-ap .stab{padding:5px 14px;border-radius:50px;font-size:12px;font-weight:600;border:1.5px solid var(--border);background:var(--surface);color:var(--t3);cursor:pointer;white-space:nowrap}
.znp-ap .stab.active{background:var(--blue-50);color:var(--blue);border-color:var(--blue-100)}
.znp-ap .stab-n{background:var(--border);border-radius:50px;padding:1px 7px;font-size:11px;margin-left:4px;font-weight:700}
.znp-ap .stab.active .stab-n{background:var(--blue);color:#fff}
.znp-ap .cands-grid{display:flex;flex-direction:column;gap:10px}
.znp-ap .ccard{background:var(--surface);border:1px solid var(--border);border-radius:var(--r);overflow:hidden;box-shadow:var(--sh);transition:all .18s}
.znp-ap .ccard:hover{box-shadow:var(--sh-md);border-color:var(--blue-100)}
.znp-ap .ccard.top{border-left:3px solid #a8bcf0}.znp-ap .ccard.good{border-left:3px solid #86d3a8}.znp-ap .ccard.watch{border-left:3px solid #f5c97a}.znp-ap .ccard.contract{border-left:3px solid #c4b5f5}
.znp-ap .card-main{padding:14px 16px;display:flex;align-items:flex-start;gap:12px}
.znp-ap .av-wrap{display:flex;flex-direction:column;align-items:center;gap:5px;flex-shrink:0}
.znp-ap .cav{width:40px;height:40px;border-radius:50%;font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center}
.znp-ap .fit-score{font-size:10px;font-weight:700;padding:2px 7px;border-radius:50px;border:1px solid}
.znp-ap .fs-high{background:var(--green-50);color:var(--green);border-color:var(--green-100)}
.znp-ap .fs-mid{background:var(--blue-50);color:var(--blue);border-color:var(--blue-100)}
.znp-ap .fs-low{background:var(--amber-50);color:var(--amber);border-color:var(--amber-100)}
.znp-ap .cbody{flex:1;min-width:0}
.znp-ap .card-top{display:flex;justify-content:space-between;gap:10px;margin-bottom:8px}
.znp-ap .cname{font-size:13.5px;font-weight:700}
.znp-ap .ccurrent{font-size:11.5px;color:var(--blue);margin-top:2px;font-weight:500}
.znp-ap .cbadges{display:flex;gap:5px;flex-wrap:wrap;flex-shrink:0}
.znp-ap .cbadge{display:inline-flex;padding:3px 9px;border-radius:50px;font-size:10.5px;font-weight:600;border:1px solid}
.znp-ap .cb-imm{background:var(--green-50);color:#2a6644;border-color:var(--green-100)}
.znp-ap .cb-contract{background:var(--purple-50);color:#4a3a8a;border-color:#ede9fe}
.znp-ap .info-grid{display:flex;flex-wrap:nowrap;border:1px solid var(--border);border-radius:var(--r-sm);margin-bottom:9px;overflow:hidden}
.znp-ap .ig-item{flex:1;min-width:0;padding:6px 9px;border-right:1px solid var(--border)}
.znp-ap .ig-item:last-child{border-right:none}
.znp-ap .ig-label{font-size:9.5px;font-weight:700;color:var(--t4);text-transform:uppercase;letter-spacing:.06em;margin-bottom:2px}
.znp-ap .ig-val{font-size:12px;font-weight:600;color:var(--text)}
.znp-ap .ig-val.hi{color:var(--blue)}.znp-ap .ig-val.ok{color:var(--green)}.znp-ap .ig-val.imm{color:var(--green)}
.znp-ap .skills-row{display:flex;gap:4px;flex-wrap:wrap;margin-bottom:9px}
.znp-ap .sk-tag{border:1px solid var(--border);border-radius:5px;padding:2px 8px;font-size:10.5px;color:var(--t3);font-weight:500}
.znp-ap .sk-tag.match{border-color:var(--blue-100);color:var(--blue);font-weight:600;background:var(--blue-50)}
.znp-ap .qa-wrap{background:#f8fafc;border:1px solid var(--border);border-radius:var(--r-sm);padding:10px 13px;margin-bottom:2px}
.znp-ap .qa-head{font-size:9.5px;font-weight:700;color:var(--t4);text-transform:uppercase;letter-spacing:.08em;margin-bottom:9px}
.znp-ap .qa-item{display:grid;grid-template-columns:minmax(110px,140px) 1fr;gap:8px 12px;margin-bottom:6px;align-items:baseline}
.znp-ap .qa-item:last-child{margin-bottom:0}
.znp-ap .qa-label{font-size:11px;font-weight:700;color:var(--text)}
.znp-ap .qa-answer{font-size:12px;color:var(--text);font-weight:600;line-height:1.5;word-break:break-word}
.znp-ap .qa-answer.is-quote{font-weight:500}
.znp-ap .qa-answer.is-empty{color:var(--t4);font-weight:500;font-style:italic}
.znp-ap .qa-video-link{display:inline-flex;align-items:center;gap:5px;color:var(--blue);font-weight:600;text-decoration:none}
.znp-ap .qa-video-link:hover{text-decoration:underline}
.znp-ap .qa-video-link svg{width:12px;height:12px;flex-shrink:0}
.znp-ap .act-bar{display:flex;align-items:center;padding:6px 14px;border-top:1px solid var(--border);background:var(--bg);overflow-x:auto;gap:0}
.znp-ap .act-dot{width:8px;height:8px;border-radius:50%;background:#d1dae8;flex-shrink:0}
.znp-ap .act-dot.done{background:var(--blue)}.znp-ap .act-dot.now{background:var(--orange)}
.znp-ap .act-label{font-size:10.5px;font-weight:600;color:var(--t4);margin-left:5px;white-space:nowrap}
.znp-ap .act-label.done{color:var(--blue)}.znp-ap .act-label.now{color:var(--orange);font-weight:700}
.znp-ap .act-date{font-size:9.5px;color:var(--t4);margin:0 8px 0 3px;white-space:nowrap}
.znp-ap .act-line{height:1.5px;width:18px;background:#d1dae8;flex-shrink:0}
.znp-ap .act-line.done{background:var(--blue)}
.znp-ap .act-pending-sep{width:10px;height:1.5px;border-top:1.5px dotted #cbd5e1;margin:0 4px;flex-shrink:0}
.znp-ap .act-pending-step{display:flex;align-items:center;gap:4px;cursor:pointer;flex-shrink:0}
.znp-ap .act-pending-dot{width:8px;height:8px;border-radius:50%;border:1.5px dashed var(--orange);background:transparent}
.znp-ap .act-pending-label{font-size:10.5px;font-weight:700;color:var(--orange);white-space:nowrap}
.znp-ap .pending-btn{display:inline-flex;align-items:center;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:#fff7ed;border:1px solid #fed7aa;color:#92400e;margin-left:8px;cursor:pointer;vertical-align:middle}
.znp-ap .pending-btn:hover{background:#f97316;color:#fff;border-color:#f97316}
.znp-ap .pending-btn.done{background:#f0fdf4;border-color:#86d3a8;color:#166534;pointer-events:none}
.znp-ap .jab{display:inline-flex;align-items:center;font-size:10px;font-weight:600;padding:1px 7px;border-radius:20px;background:var(--purple-50);color:var(--purple);border:1px solid var(--purple-100);margin-left:6px}
.znp-ap .jab-hot{background:#fff7ed;color:#92400e;border-color:#fed7aa}
.znp-ap .email-preview-wrap{position:relative;display:inline-flex}
.znp-ap .email-tip{display:none;position:absolute;bottom:calc(100% + 8px);left:0;background:var(--surface);border:1px solid var(--border);border-radius:var(--r-sm);min-width:260px;max-width:320px;box-shadow:var(--sh-md);z-index:20;padding:10px 12px}
.znp-ap .email-preview-wrap:hover .email-tip{display:block}
.znp-ap .et-label{font-size:9px;font-weight:700;color:var(--t4);text-transform:uppercase;margin-bottom:4px}
.znp-ap .et-subject{font-size:11px;font-weight:700;color:var(--text);margin-bottom:4px}
.znp-ap .et-body{font-size:11px;color:var(--t2);line-height:1.5}
.znp-ap .card-actions{display:flex;flex-direction:column;background:var(--bg);border-top:1px solid var(--border)}
.znp-ap .action-btns{display:flex;gap:6px;flex-wrap:wrap;padding:8px 14px 6px}
.znp-ap .reject-row{display:flex;gap:6px;justify-content:flex-end;padding:4px 14px 8px;border-top:1px solid var(--border)}
.znp-ap .abtn{padding:6px 14px;border-radius:50px;font-size:12px;font-weight:600;cursor:pointer;border:1.5px solid #c5d0ef;background:#eef1fb;color:#1c3faa;font-family:inherit;white-space:nowrap}
.znp-ap .abtn.reject{background:transparent;color:#64748b;border-color:#cbd5e1}
.znp-ap .abtn.report{background:#fff7ed;color:#92400e;border-color:#fed7aa}
.znp-ap .abtn.offer-btn{background:#fffbeb;color:#92400e;border-color:#fde68a}
.znp-ap .interview-badge{display:inline-flex;font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;margin-left:6px}
.znp-ap .av-meta{text-align:center;font-size:9.5px;color:var(--t4);line-height:1.5;width:44px}
.znp-ap .av-meta strong{display:block;color:var(--t3);font-size:9px;font-weight:700}
.znp-ap .empty-state{text-align:center;padding:48px 20px;color:var(--t4)}
.znp-ap .empty-state h4{font-size:14px;font-weight:700;color:var(--t2);margin:12px 0 6px}
.znp-ap .pagination{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:22px;padding-top:20px;border-top:1px solid var(--border)}
.znp-ap .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.4);z-index:500;align-items:center;justify-content:center;backdrop-filter:blur(2px);padding:16px}
.znp-ap .modal-overlay.open{display:flex}
.znp-ap .sched-modal,.znp-ap .composer,.znp-ap .report-modal{background:var(--surface);border-radius:var(--r);width:100%;max-width:520px;box-shadow:0 24px 64px rgba(0,0,0,.18);max-height:90vh;display:flex;flex-direction:column}
.znp-ap .composer{max-width:700px}
.znp-ap .sched-head,.znp-ap .comp-head{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);background:var(--bg)}
.znp-ap .sched-title,.znp-ap .comp-title{font-size:13.5px;font-weight:700}
.znp-ap .sched-body,.znp-ap .comp-body{padding:18px 20px;overflow-y:auto;flex:1}
.znp-ap .sched-label{display:block;font-size:10.5px;font-weight:700;color:var(--t4);text-transform:uppercase;margin-bottom:5px}
.znp-ap .sched-inp,.znp-ap .m-input{width:100%;border:1px solid var(--border);border-radius:var(--r-sm);padding:8px 11px;font-size:12.5px;font-family:inherit;margin-bottom:10px}
.znp-ap .sched-footer,.znp-ap .comp-footer{display:flex;gap:8px;padding:12px 20px;border-top:1px solid var(--border);background:var(--bg)}
.znp-ap .btn-send{padding:7px 20px;background:var(--blue);color:#fff;border:none;border-radius:50px;font-size:12.5px;font-weight:700;cursor:pointer;font-family:inherit}
.znp-ap .btn-comp-ghost{padding:7px 13px;background:var(--surface);color:var(--t2);border:1px solid var(--border);border-radius:50px;font-size:12px;font-weight:600;cursor:pointer;font-family:inherit;margin-left:auto}
.znp-ap .comp-field-row{display:flex;align-items:center;gap:10px;padding:8px 20px;border-bottom:1px solid var(--border)}
.znp-ap .cf-label{font-size:11px;font-weight:700;color:var(--t4);width:70px;flex-shrink:0;text-transform:uppercase}
.znp-ap .cf-input{flex:1;border:none;outline:none;font-size:12.5px;font-family:inherit;color:var(--text);background:transparent}
.znp-ap .comp-toolbar{display:flex;gap:6px;align-items:center;padding:8px 20px;border-bottom:1px solid var(--border);background:#fafbff;flex-wrap:wrap}
.znp-ap .ct-fmt,.znp-ap .var-btn{padding:4px 8px;border:1px solid var(--border);border-radius:5px;background:var(--surface);color:var(--t2);font-size:11px;font-weight:700;cursor:pointer}
.znp-ap .comp-body{min-height:170px;outline:none;line-height:1.7}
.znp-ap .comp-jd{border-top:1px solid var(--border);background:#f8fafc;padding:10px 20px}
.znp-ap .comp-jd-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px}
.znp-ap .comp-jd-block{font-size:11.5px;color:var(--t2);line-height:1.7}
.znp-ap .toast{display:none;position:fixed;bottom:28px;left:50%;transform:translateX(-50%);background:var(--text);color:#fff;padding:11px 20px;border-radius:var(--r-sm);font-size:13px;font-weight:500;z-index:9999;box-shadow:0 8px 24px rgba(0,0,0,.22);align-items:center;gap:10px}
.znp-ap .toast.show{display:flex}
.znp-ap .znp-opt{display:flex;gap:10px;padding:9px 11px;border:1.5px solid var(--border);border-radius:8px;margin-bottom:7px;cursor:pointer}
.znp-ap .znp-opt.sel{border-color:var(--blue);background:var(--blue-50)}
.znp-ap .if-verdict-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:6px;margin-bottom:16px}
.znp-ap .if-verdict{display:flex;flex-direction:column;align-items:center;gap:4px;padding:8px 4px;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;font-size:10px;font-weight:700;color:var(--t3)}
.znp-ap .if-verdict.sel{border-color:var(--blue);background:var(--blue-50);color:var(--blue)}
.znp-ap .abtn.done{background:#f0fdf4!important;color:#166534!important;border-color:#86d3a8!important;pointer-events:none}
.znp-ap .abtn.done::after{content:' ✓';font-size:11px}
.znp-ap .abtn.emailed-done{background:#dbeafe!important;color:#1e40af!important;border-color:#93c5fd!important}
.znp-ap .abtn.emailed-done::after{content:' ✓';font-size:11px}
.znp-ap .abtn.locked{opacity:.45;pointer-events:none;cursor:not-allowed}
.znp-ap .note-preview-strip{display:none;align-items:flex-start;gap:10px;padding:8px 16px;background:#fffef5;border-top:1px solid var(--border)}
.znp-ap .note-preview-strip.show{display:flex}
.znp-ap .nps-av{width:28px;height:28px;border-radius:50%;background:var(--amber-50);color:var(--amber);font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.znp-ap .nps-meta{font-size:10px;color:var(--t4);margin-bottom:2px}
.znp-ap .nps-text{font-size:12px;color:var(--text);line-height:1.5}
.znp-ap .nps-edit{font-size:11px;color:var(--blue);font-weight:600;cursor:pointer;margin-top:4px}
.znp-ap .notes-panel{display:none;border-top:1px solid var(--border);background:#fffef5}
.znp-ap .notes-panel.open{display:block}
.znp-ap .notes-panel textarea{width:100%;resize:none;border:none;outline:none;padding:8px 16px 10px;font-size:12px;font-family:inherit;color:var(--text);background:#fffef5;min-height:60px;line-height:1.6}
.znp-ap .feedback-strip{display:none;padding:8px 16px;background:#f5f3ff;border-top:1px solid #ddd6fe;font-size:12px}
.znp-ap .feedback-strip.show{display:block}
.znp-ap .fbstrip-meta{font-size:10px;font-weight:700;color:#7c3aed;margin-bottom:3px}
.znp-ap .status-strip{display:none;padding:8px 16px;background:var(--bg);border-top:1px solid var(--border);font-size:12px}
.znp-ap .status-strip.show{display:block}
.znp-ap .offer-wrap{position:relative;display:inline-block}
.znp-ap .offer-menu{display:none;position:absolute;bottom:100%;right:0;margin-bottom:4px;background:var(--surface);border:1px solid var(--border);border-radius:8px;box-shadow:var(--sh-md);min-width:140px;z-index:10}
.znp-ap .offer-wrap.open .offer-menu{display:block}
.znp-ap .om-item{padding:8px 12px;font-size:12px;font-weight:600;cursor:pointer}
.znp-ap .om-item:hover{background:var(--blue-50);color:var(--blue)}
.znp-ap .cv-frame{width:100%;height:70vh;border:none;display:none}
.znp-ap .cv-pdf-container{width:100%;height:70vh;overflow-y:auto;padding:16px;background:#f8fafc}
.znp-ap .cv-pdf-container canvas{display:block;margin:0 auto 16px;max-width:100%;height:auto;box-shadow:0 1px 4px rgba(0,0,0,.12)}
.znp-ap .cv-word-container{width:100%;height:70vh;overflow-y:auto;padding:16px;background:#fff}
.znp-ap .cv-word-container .docx-wrapper{background:#fff;padding:0}
.znp-ap .cv-fallback{display:none;padding:32px 24px;text-align:center}
.znp-ap .cv-fallback p{font-size:13px;color:var(--t3);margin-bottom:14px}
.znp-ap .cv-download-btn{margin-left:auto;font-size:11px;font-weight:700;color:var(--blue);text-decoration:none}
.znp-ap .cv-download-btn:hover{text-decoration:underline}
@media(max-width:960px){.znp-ap .page{grid-template-columns:1fr}.znp-ap .sidebar{position:static}}
@media(max-width:640px){
    .znp-ap .page{padding:14px 12px 44px}
    .znp-ap .card-main{padding:12px;gap:10px}
    .znp-ap .card-top{flex-direction:column;gap:7px}
    .znp-ap .cbadges{justify-content:flex-start;flex-shrink:1}
    .znp-ap .cbadge{font-size:10px;padding:3px 8px}
    .znp-ap .info-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));overflow:visible}
    .znp-ap .ig-item{border-right:none;border-top:1px solid var(--border)}
    .znp-ap .ig-item:nth-child(odd){border-right:1px solid var(--border)}
    .znp-ap .ig-item:nth-child(-n+2){border-top:none}
    .znp-ap .qa-item{grid-template-columns:1fr;gap:3px}
    .znp-ap .action-btns,.znp-ap .reject-row{justify-content:flex-start}
}
</style>
@endpush

@section('content')
<div class="znp-ap" id="znpApRoot" data-job-id="{{ $job->id }}" data-job-exp-min="{{ $job->exp_min ?? 0 }}" data-job-exp-max="{{ $job->exp_max ?? 99 }}">

    <nav class="nav">
        <a class="logo" href="{{ url('/') }}"><span class="la">Zero</span><span class="lb">Notice</span><span class="lc">Period</span></a>
        <div class="nav-r">
            <a class="nbtn nb-ghost" href="{{ route('my-jobs') }}">Back to Jobs</a>
            <a class="nbtn nb-primary" href="{{ route('employer.post.job.page') }}">+ Post Another Job</a>
            <button type="button" class="nbtn nb-ghost" data-znp-action="help-support" style="margin-right:4px">Help / Support</button>
            <div class="nav-av-wrap" id="apAvWrap" style="margin-left:6px;padding-left:12px;border-left:1px solid var(--border)">
                <div class="nav-av" data-znp-action="toggle-av-menu" title="{{ $company->name }}">{{ $companyInitials }}</div>
                <div class="av-menu">
                    <div class="av-menu-company">{{ $company->name }}@if($planSubLabel !== '')<span>{{ $planSubLabel }}</span>@endif</div>
                    <a class="av-menu-item" href="{{ route('company.profile') }}">Account Settings</a>
                    <a class="av-menu-item" href="{{ route('my-jobs') }}">My Job Postings</a>
                    <a class="av-menu-item logout" href="{{ route('logoutcompany') }}">Log out</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="crumb">
        <div class="crumb-inner">
            <a href="{{ route('employer.dashboard.page') }}">My Jobs</a>
            <span>›</span>
            <span style="color:var(--t3);font-weight:500">{{ $job->job_title }}</span>
            <span>›</span>
            <span style="color:var(--text);font-weight:600">Applicants</span>
        </div>
    </div>

    <div class="job-banner">
        <div class="jb-inner">
            <div class="jb-left">
                <div class="jb-av">{{ $companyInitials }}</div>
                <div>
                    <div class="jb-title">{{ $job->job_title }}</div>
                    <div class="jb-pills">
                        <span class="jb-pill blue">{{ $company->name }}</span>
                        @if($jobLocationLabel !== '—')<span class="jb-pill">{{ $jobLocationLabel }}</span>@endif
                        @if($salaryLabel !== '—')<span class="jb-pill green">{{ $salaryLabel }}</span>@endif
                        @if($expLabel)<span class="jb-pill">{{ $expLabel }}</span>@endif
                        @if($workModeLabel)<span class="jb-pill">{{ $workModeLabel }}</span>@endif
                        <span class="jb-pill">Posted {{ $postedLabel }}</span>
                    </div>
                    <div style="margin-top:4px;font-size:11.5px;display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                        <strong style="color:var(--blue)">{{ $metrics['total'] }} applicants</strong>
                        · <span style="color:var(--green);font-weight:600">{{ $metrics['shortlisted'] }} shortlisted</span>
                        · <span style="color:var(--amber);font-weight:600">{{ $metrics['interview'] }} interview</span>
                        @if(!empty($jobListing['label']))
                            <span class="jb-repost">{{ $jobListing['label'] }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="jb-actions">
                <button type="button" class="act-btn share" data-znp-action="share">Share</button>
                <a class="act-btn" href="{{ route('employer.post.job.edit', $job->id) }}">Edit Job</a>
                @if(!empty($job->slug))
                    <a class="act-btn viewjob" href="{{ route('job.detail.znp', $job->slug) }}" target="_blank" rel="noopener">View Job</a>
                @endif
                <button type="button" class="act-btn retire" data-znp-action="retire">Retire Job</button>
            </div>
        </div>
    </div>

    <div class="metrics-bar">
        <div class="metrics-inner">
            <div class="metric-item active" data-metric="all"><div class="m-num blue">{{ $metrics['total'] }}</div><div class="m-label">Total Applied</div></div>
            <!-- <div class="metric-item" data-metric="resumedb"><div class="m-num green">{{ $metrics['resumedb'] }}</div><div class="m-label">ResumeDB</div></div> -->
            <div class="metric-item" data-metric="within"><div class="m-num blue">{{ $metrics['within'] }}</div><div class="m-label">Within Budget</div></div>
            <div class="metric-item" data-metric="over"><div class="m-num red">{{ $metrics['over'] }}</div><div class="m-label">Over Budget</div></div>
            <div class="metric-item" data-metric="mumbai"><div class="m-num blue">{{ $metrics['mumbai'] }}</div><div class="m-label">Mumbai</div></div>
            <div class="metric-item" data-metric="other_cities"><div class="m-num blue">{{ $metrics['other_cities'] }}</div><div class="m-label">Other Cities</div></div>
            <div class="metric-item" data-metric="exp_in_range"><div class="m-num blue">{{ $metrics['exp_in_range'] }}</div><div class="m-label">{{ $metrics['exp_in_range_label'] ?? 'In Exp Range' }}</div></div>
            <div class="metric-item" data-metric="exp_senior"><div class="m-num blue">{{ $metrics['exp_senior'] }}</div><div class="m-label">{{ $metrics['exp_senior_label'] ?? 'Senior Exp' }}</div></div>
            <div class="metric-item" data-metric="verified"><div class="m-num green">{{ $metrics['verified'] }}</div><div class="m-label">Verified</div></div>
            <div class="metric-item" data-metric="emailed"><div class="m-num blue" id="apEmailedMetric">{{ $metrics['emailed'] ?? 0 }}</div><div class="m-label">Emailed</div></div>
        </div>
    </div>

    <div class="page">
        <aside class="sidebar">
            <div class="sb-head"><span class="sb-title">Filters</span><span class="sb-clear" id="apClearFilters">Clear all</span></div>
            <div class="sb-sec">
                <div class="sb-sec-title">Search</div>
                <input class="sb-search" id="apSearch" placeholder="Name, skill, company…" autocomplete="off">
            </div>
            <div class="sb-sec">
                <div class="sb-sec-title">Fitment Score</div>
                <div class="filter-opt checked" data-filter="fit-high"><div class="fo-check">✓</div><div class="fo-label">Strong (80–100%)</div><div class="fo-count">{{ $filterCounts['fit_high'] ?? 0 }}</div></div>
                <div class="filter-opt checked" data-filter="fit-mid"><div class="fo-check">✓</div><div class="fo-label">Good (60–79%)</div><div class="fo-count">{{ $filterCounts['fit_mid'] ?? 0 }}</div></div>
                <div class="filter-opt checked" data-filter="fit-low"><div class="fo-check">✓</div><div class="fo-label">Partial (&lt;60%)</div><div class="fo-count">{{ $filterCounts['fit_low'] ?? 0 }}</div></div>
            </div>
            <div class="sb-sec">
                <div class="sb-sec-title">Notice Period</div>
                <div class="filter-opt checked" data-filter="notice-immediate"><div class="fo-check">✓</div><div class="fo-label">Immediate</div><div class="fo-count">{{ $filterCounts['notice_immediate'] ?? 0 }}</div></div>
                <div class="filter-opt checked" data-filter="notice-serving"><div class="fo-check">✓</div><div class="fo-label">Serving Notice</div><div class="fo-count">{{ $filterCounts['notice_serving'] ?? 0 }}</div></div>
            </div>
            <div class="sb-sec">
                <div class="sb-sec-title">Experience (Years)</div>
                <div class="range-row">
                    <input class="range-inp" type="number" id="apExpMin" placeholder="Min" value="0">
                    <span style="font-size:11px;color:var(--t4)">to</span>
                    <input class="range-inp" type="number" id="apExpMax" placeholder="Max" value="99">
                </div>
            </div>
            <div class="sb-sec">
                <div class="sb-sec-title">Expected CTC (LPA)</div>
                <div class="range-row">
                    <input class="range-inp" type="number" id="apCtcMin" placeholder="Min" value="0">
                    <span style="font-size:11px;color:var(--t4)">to</span>
                    <input class="range-inp" type="number" id="apCtcMax" placeholder="Max" value="{{ $job->max_salary ?: 999 }}">
                </div>
            </div>
            <div class="sb-sec">
                <div class="sb-sec-title">Location</div>
                @foreach(['loc-mumbai'=>'Mumbai','loc-pune'=>'Pune','loc-bengaluru'=>'Bengaluru','loc-hyderabad'=>'Hyderabad','loc-delhi'=>'Delhi NCR','loc-other'=>'Other'] as $key => $label)
                    <div class="filter-opt checked" data-filter="{{ $key }}"><div class="fo-check">✓</div><div class="fo-label">{{ $label }}</div><div class="fo-count">{{ $filterCounts[str_replace('-', '_', $key)] ?? 0 }}</div></div>
                @endforeach
            </div>
            <div class="sb-sec">
                <div class="sb-sec-title">Preferred Mode</div>
                @foreach(['mode-office'=>'Work from Office','mode-hybrid'=>'Hybrid','mode-remote'=>'Remote / WFH'] as $key => $label)
                    <div class="filter-opt checked" data-filter="{{ $key }}"><div class="fo-check">✓</div><div class="fo-label">{{ $label }}</div><div class="fo-count">{{ $filterCounts[str_replace('-', '_', $key)] ?? 0 }}</div></div>
                @endforeach
            </div>
            <div class="sb-sec">
                <div class="sb-sec-title">Candidate Type</div>
                @foreach(['type-fulltime'=>'Full-time','type-contract'=>'Open to Contract'] as $key => $label)
                    <div class="filter-opt checked" data-filter="{{ $key }}"><div class="fo-check">✓</div><div class="fo-label">{{ $label }}</div><div class="fo-count">{{ $filterCounts[str_replace('-', '_', $key)] ?? 0 }}</div></div>
                @endforeach
            </div>
            <div class="sb-sec">
                <div class="sb-sec-title">Education</div>
                @foreach(['edu-btech'=>'B.Tech / B.E.','edu-mca'=>'MCA / M.Tech','edu-bca'=>'BCA / BSc','edu-other'=>'Other'] as $key => $label)
                    <div class="filter-opt checked" data-filter="{{ $key }}"><div class="fo-check">✓</div><div class="fo-label">{{ $label }}</div><div class="fo-count">{{ $filterCounts[str_replace('-', '_', $key)] ?? 0 }}</div></div>
                @endforeach
            </div>
            <div class="sb-sec">
                <div class="sb-sec-title">Stage</div>
                @foreach(['stage-new'=>'New / Unreviewed','stage-shortlisted'=>'Shortlisted','stage-interview'=>'Interview Scheduled'] as $key => $label)
                    <div class="filter-opt checked" data-filter="{{ $key }}"><div class="fo-check">✓</div><div class="fo-label">{{ $label }}</div><div class="fo-count">{{ $filterCounts[str_replace('-', '_', $key)] ?? 0 }}</div></div>
                @endforeach
            </div>
        </aside>

        <div class="main">
            <div class="toolbar">
                <div style="display:flex;gap:10px;align-items:center">
                    <label style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--t3)">
                        <input type="checkbox" id="apSelectAll"> Select all
                    </label>
                    <button type="button" class="tbtn" data-znp-action="email-all">Send Email to All</button>
                </div>
                <div style="display:flex;gap:10px;align-items:center">
                    <div id="apResultCount" style="font-size:13px;color:var(--t3)">Showing <strong>{{ count($applicants) }}</strong> applicants</div>
                <select class="sort-sel" id="apSort">
                    <option value="fit">Sort: Fitment Score</option>
                    <option value="recent">Sort: Most Recent</option>
                    <option value="exp">Sort: Experience</option>
                    <option value="ctc">Sort: Salary (Low–High)</option>
                </select>
                </div>
            </div>

            <div class="stage-tabs" id="apStageTabs">
                @foreach($apStageTabs as $key => $label)
                    <div class="stab {{ $key === 'all' ? 'active' : '' }}" data-stage="{{ $key }}">{{ $label }} <span class="stab-n">{{ $stages[$key] ?? 0 }}</span></div>
                @endforeach
            </div>

            <div id="apBulkBar" style="display:none;align-items:center;gap:10px;background:#EEF1FB;border:1px solid var(--blue-100);border-radius:var(--r-sm);padding:8px 14px;margin-bottom:10px">
                <span id="apBulkCount" style="font-size:12.5px;font-weight:700;color:var(--blue)">0 selected</span>
                <div style="flex:1"></div>
                <button type="button" class="tbtn" data-znp-action="email-selected">Email Selected</button>
                <button type="button" data-znp-action="clear-selection" style="background:none;border:none;font-size:16px;color:var(--t4);cursor:pointer">×</button>
            </div>

            @if(count($applicants) === 0)
                <div class="empty-state">
                    <h4>No applicants yet</h4>
                    <p>When candidates apply to this job, they will appear here with fitment scores and questionnaire answers.</p>
                </div>
            @else
                <div class="cands-grid" id="apCandsGrid">
                    @foreach($applicants as $a)
                        @php
                            $cavColors = ['background:#dde5f8;color:var(--blue)','background:#e4e0f5;color:var(--purple)','background:#d8eee3;color:var(--green)','background:#fde8cc;color:#9a4a00','background:#cde8f0;color:#0891b2'];
                            $cavStyle = $cavColors[$loop->index % count($cavColors)];
                        @endphp
                        <div class="ccard {{ $a['card_class'] }}"
                             data-app-id="{{ $a['application_id'] }}"
                             data-cand="{{ $a['slug'] }}"
                             data-email="{{ $a['candidate_email'] }}"
                             data-display-name="{{ $a['display_name'] }}"
                             data-stage="{{ $a['stage'] }}"
                             data-exp="{{ $a['data_exp'] }}"
                             data-ctc="{{ $a['data_ctc'] }}"
                             data-location="{{ $a['location_slug'] }}"
                             data-mode="{{ $a['mode_slug'] }}"
                             data-notice="{{ $a['notice_slug'] }}"
                             data-type="{{ $a['type_slug'] }}"
                             data-fit="{{ $a['data_fit'] }}"
                             data-education="{{ $a['education_slug'] ?? 'other' }}"
                             data-within-budget="{{ $a['within_budget'] ? '1' : '0' }}"
                             data-verified="{{ $a['verified'] ? '1' : '0' }}"
                             data-emailed="{{ $a['has_emailed'] ? '1' : '0' }}"
                             data-next-action="{{ $a['next_action']['action'] ?? '' }}"
                             data-next-label="{{ $a['next_action']['label'] ?? '' }}"
                             data-name="{{ strtolower($a['display_name']) }}"
                             data-search="{{ strtolower($a['display_name'].' '.$a['current_role'].' '.$a['current_company'].' '.collect($a['skills'])->pluck('name')->implode(' ')) }}">
                            <div class="card-main">
                                <input type="checkbox" class="ap-cand-check" data-app-id="{{ $a['application_id'] }}" style="margin-top:12px;width:15px;height:15px;accent-color:var(--blue);cursor:pointer">
                                <div class="av-wrap">
                                    <div class="cav" style="{{ $cavStyle }}">{{ $a['initials'] }}</div>
                                    <div class="fit-score {{ $a['fit_class'] }}">{{ $a['fit'] }}% fit</div>
                                    <div class="av-meta">Applied {{ $a['applied_label'] }}<strong>{{ $a['applied_ref'] }}</strong></div>
                                </div>
                                <div class="cbody">
                                    <div class="card-top">
                                        <div>
                                            <div class="cname">
                                                {{ $a['display_name'] }}
                                                @if(!empty($a['next_action']))
                                                    <button type="button" class="pending-btn" data-znp-action="pending-{{ $a['next_action']['action'] }}" data-name="{{ $a['display_name'] }}">{{ $a['next_action']['label'] }}</button>
                                                @endif
                                            </div>
                                            <div class="ccurrent">
                                                @if($a['current_role'] || $a['current_company'])
                                                    {{ $a['current_role'] }}{{ ($a['current_role'] && $a['current_company']) ? ' · ' : '' }}{{ $a['current_company'] }}
                                                @endif
                                                @if($a['location_display']) · {{ $a['location_display'] }} @endif
                                                @if(($a['jobs_applied_count'] ?? 1) > 0)
                                                    <span class="jab {{ ($a['jobs_applied_count'] ?? 1) >= 3 ? 'jab-hot' : '' }}" title="Applied to {{ $a['jobs_applied_count'] }} job(s) on ZNP">📋 {{ $a['jobs_applied_count'] }} job{{ ($a['jobs_applied_count'] ?? 1) === 1 ? '' : 's' }} applied</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="cbadges">
                                            @foreach($a['badges'] as $badge)
                                                <span class="cbadge {{ stripos($badge, 'Contract') !== false ? 'cb-contract' : 'cb-imm' }}">{{ $badge }}</span>
                                            @endforeach
                                            @if($a['has_interview'])<span class="interview-badge">Scheduled</span>@endif
                                        </div>
                                    </div>
                                    <div class="info-grid">
                                        <div class="ig-item"><div class="ig-label">Experience</div><div class="ig-val hi">{{ $a['exp_label'] }}</div></div>
                                        <div class="ig-item"><div class="ig-label">Curr. CTC</div><div class="ig-val">{{ $a['curr_ctc'] }}</div></div>
                                        <div class="ig-item"><div class="ig-label">Exp. CTC</div><div class="ig-val ok">{{ $a['exp_ctc'] }}</div></div>
                                        <div class="ig-item"><div class="ig-label">Notice</div><div class="ig-val imm">{{ $a['notice_label'] }}</div></div>
                                        <div class="ig-item"><div class="ig-label">Pref. Mode</div><div class="ig-val">{{ $a['pref_mode'] }}</div></div>
                                        <div class="ig-item"><div class="ig-label">Education</div><div class="ig-val">{{ $a['education'] }}</div></div>
                                        <div class="ig-item"><div class="ig-label">College</div><div class="ig-val">{{ $a['college'] }}</div></div>
                                    </div>
                                    @if(!empty($a['skills']))
                                        <div class="skills-row">
                                            @foreach(array_slice($a['skills'], 0, 8) as $sk)
                                                <span class="sk-tag {{ $sk['match'] ? 'match' : '' }}">{{ $sk['name'] }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(!empty($a['questionnaire']))
                                        @php
                                            $qaLabelMap = [
                                                'years_relevant' => 'Relevant experience',
                                                'why_hire'       => 'Why hire you?',
                                                'video_intro'    => 'Video intro',
                                            ];
                                        @endphp
                                        <div class="qa-wrap">
                                            <div class="qa-head">Questionnaire Responses</div>
                                            @foreach($a['questionnaire'] as $q)
                                                @if(!is_array($q)) @continue @endif
                                                @php
                                                    $qKey = (string) ($q['key'] ?? '');
                                                    $qType = (string) ($q['type'] ?? 'text');
                                                    $qAnswer = trim((string) ($q['answer'] ?? ''));
                                                    $qLabel = $qaLabelMap[$qKey] ?? ($q['label'] ?? 'Question');
                                                @endphp
                                                <div class="qa-item">
                                                    <span class="qa-label">{{ $qLabel }}</span>
                                                    <span class="qa-answer">
                                                        @if($qAnswer !== '')
                                                            @if($qType === 'url')
                                                                <a class="qa-video-link" href="{{ $qAnswer }}" target="_blank" rel="noopener noreferrer">
                                                                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M4 2.5v11l9-5.5z"/></svg>
                                                                    {{ preg_replace('#^https?://(www\.)?#i', '', $qAnswer) }}
                                                                </a>
                                                            @elseif($qType === 'text')
                                                                <span class="is-quote">"{{ $qAnswer }}"</span>
                                                            @else
                                                                {{ $qAnswer }}
                                                            @endif
                                                        @else
                                                            <span class="is-empty">Not provided</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="act-bar ap-act-bar">
                                @foreach($a['activity'] as $i => $step)
                                    @if($i > 0)<div class="act-line {{ $step['state'] === 'done' || ($a['activity'][$i-1]['state'] ?? '') === 'done' ? 'done' : '' }}"></div>@endif
                                    <div style="display:flex;align-items:center;flex-shrink:0">
                                        <div class="act-dot {{ $step['state'] }}"></div>
                                        <span class="act-label {{ $step['state'] }}">{{ $step['label'] }}</span>
                                        <span class="act-date">{{ $step['date'] }}</span>
                                    </div>
                                @endforeach
                                @if(!empty($a['next_action']))
                                    <div class="act-pending-sep"></div>
                                    <div class="act-pending-step" data-znp-action="pending-{{ $a['next_action']['action'] }}" data-name="{{ $a['display_name'] }}" title="Click to act">
                                        <div class="act-pending-dot"></div>
                                        <span class="act-pending-label">{{ $a['next_action']['label'] }}?</span>
                                    </div>
                                @endif
                            </div>
                            <div class="note-preview-strip {{ !empty($a['note']) ? 'show' : '' }}" data-note-strip>
                                <div class="nps-av">N</div>
                                <div class="nps-body">
                                    <div class="nps-meta" data-note-meta>{{ $a['note']['updated_at'] ?? '' }}</div>
                                    <div class="nps-text" data-note-text>{{ $a['note']['body'] ?? '' }}</div>
                                    <div class="nps-edit" data-znp-action="notes">Edit note</div>
                                </div>
                            </div>
                            <div class="feedback-strip {{ !empty($a['feedback']) ? 'show' : '' }}" data-feedback-strip>
                                <div class="fbstrip-meta" data-feedback-meta>{{ !empty($a['feedback']) ? ($a['feedback']['verdict_label'].' · '.$a['feedback']['created_at']) : '' }}</div>
                                <div class="fbstrip-comment" data-feedback-text>{{ $a['feedback']['comments'] ?? '' }}</div>
                            </div>
                            <div class="notes-panel" data-notes-panel>
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 16px 5px;border-bottom:1px solid var(--border)">
                                    <span style="font-size:10px;font-weight:700;color:var(--amber);text-transform:uppercase;letter-spacing:.07em">Internal Notes — not visible to candidate</span>
                                    <div style="display:flex;gap:8px">
                                        <button type="button" data-znp-action="save-note" style="font-size:11px;font-weight:700;color:var(--blue);background:none;border:none;cursor:pointer">Save</button>
                                        <button type="button" data-znp-action="close-notes" style="background:none;border:none;font-size:18px;cursor:pointer;color:var(--t3)">×</button>
                                    </div>
                                </div>
                                <textarea data-note-input placeholder="Add a note about this candidate…">{{ $a['note']['body'] ?? '' }}</textarea>
                            </div>
                            <div class="status-strip {{ !empty($a['offer_label']) || !empty($a['rejected_reason']) ? 'show' : '' }}" data-status-strip>
                                <div data-status-text>
                                    @if(!empty($a['offer_label']))
                                        <strong>{{ $a['offer_label'] }}</strong>
                                    @elseif(!empty($a['rejected_reason']))
                                        Rejected: {{ $a['rejected_reason'] }}
                                    @endif
                                </div>
                            </div>
                            <div class="card-actions">
                                <div class="action-btns">
                                    <button type="button" class="abtn" data-znp-action="view-cv" data-name="{{ $a['display_name'] }}">View CV</button>
                                    <a class="abtn" href="{{ $a['profile_url'] }}" target="_blank" rel="noopener">View Profile</a>
                                    <button type="button" class="abtn {{ $a['is_shortlisted'] ? 'done' : '' }}" data-znp-action="shortlist" data-name="{{ $a['display_name'] }}">{{ $a['is_shortlisted'] ? 'Shortlisted' : 'Shortlist' }}</button>
                                    <button type="button" class="abtn" data-znp-action="download-cv" data-name="{{ $a['display_name'] }}">Download CV</button>
                                    <button type="button" class="abtn" data-znp-action="notes" data-name="{{ $a['display_name'] }}">Notes</button>
                                    <div class="email-preview-wrap">
                                        <button type="button" class="abtn {{ $a['has_emailed'] ? 'emailed-done' : '' }}" data-znp-action="email" data-name="{{ $a['display_name'] }}">
                                            {{ $a['has_emailed'] ? 'Emailed' : 'Send Email' }}
                                        </button>
                                        <div class="email-tip">
                                            <div class="et-label">Email Preview</div>
                                            <div class="et-subject">{{ $a['email_preview_subject'] ?? '' }}</div>
                                            <div class="et-body">{{ $a['email_preview_body'] ?? '' }}</div>
                                        </div>
                                    </div>
                                    <button type="button" class="abtn" data-znp-action="feedback" data-name="{{ $a['display_name'] }}" style="background:#f5f3ff;color:#7c3aed;border-color:#ddd6fe">Log Feedback</button>
                                </div>
                                <div class="reject-row">
                                    <div class="offer-wrap">
                                        <button type="button"
                                                class="abtn offer-btn {{ $a['stage'] === 'offer' ? 'done' : '' }} {{ $a['stage'] === 'rejected' ? 'locked' : '' }}"
                                                data-znp-action="toggle-offer-menu">
                                            {{ $a['offer_label'] ?? 'Move to Offer' }}
                                        </button>
                                        <div class="offer-menu">
                                            <div class="om-item" data-znp-action="offer" data-offer-status="offered">Offered</div>
                                            <div class="om-item" data-znp-action="offer" data-offer-status="joined">Joined</div>
                                            <div class="om-item" data-znp-action="offer" data-offer-status="dropout">Offer Dropout</div>
                                        </div>
                                    </div>
                                    <button type="button"
                                            class="abtn reject {{ $a['stage'] === 'rejected' ? 'done' : '' }} {{ $a['stage'] === 'offer' ? 'locked' : '' }}"
                                            data-znp-action="reject"
                                            data-name="{{ $a['display_name'] }}">
                                        Reject
                                    </button>
                                    <button type="button" class="abtn report {{ $a['is_reported'] ? 'done' : '' }}" data-znp-action="report" data-name="{{ $a['display_name'] }}">Report</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Email composer --}}
    <div class="modal-overlay" id="apMsgModal" style="align-items:flex-start;overflow-y:auto">
        <div class="composer">
            <div class="comp-head">
                <span class="comp-title" id="apMsgTitle">Send Email</span>
                <button type="button" class="btn-comp-ghost" data-znp-close="apMsgModal">×</button>
            </div>
            <div class="comp-field-row">
                <span class="cf-label">Template</span>
                <select class="cf-input" id="apTemplateSelect">
                    <option value="">Choose template...</option>
                </select>
                <input class="cf-input" id="apTemplateName" placeholder="Save as new template (optional)" style="border-left:1px solid var(--border);padding-left:10px">
            </div>
            <div class="comp-field-row">
                <span class="cf-label">To</span>
                <input class="cf-input" id="apMsgTo" readonly>
            </div>
            <div class="comp-field-row">
                <span class="cf-label">Subject</span>
                <input class="cf-input" id="apMsgSubject">
            </div>
            <div class="comp-toolbar">
                <button type="button" class="ct-fmt" data-znp-action="fmt-bold"><b>B</b></button>
                <button type="button" class="ct-fmt" data-znp-action="fmt-italic"><i>I</i></button>
                <button type="button" class="ct-fmt" data-znp-action="fmt-ul">•≡</button>
                <button type="button" class="var-btn" data-znp-action="insert-var" data-var="[Candidate Name]">+Name</button>
                <button type="button" class="var-btn" data-znp-action="insert-var" data-var="[Role]">+Role</button>
                <button type="button" class="var-btn" data-znp-action="insert-var" data-var="[Date]">+Date</button>
            </div>
            <div class="comp-body" id="apMsgBody" contenteditable="true"></div>
            <div class="comp-jd">
                <div class="comp-jd-head">
                    <span style="font-size:10.5px;font-weight:700;color:var(--t4);text-transform:uppercase;letter-spacing:.06em">Job Description (included)</span>
                </div>
                <div class="comp-jd-block">
                    <strong>Role:</strong> {{ $job->job_title }} &nbsp;·&nbsp;
                    <strong>Company:</strong> {{ $company->name }} &nbsp;·&nbsp;
                    <strong>Location:</strong> {{ $jobLocationLabel }}<br>
                    <strong>Experience:</strong> {{ $expLabel ?: '—' }} &nbsp;·&nbsp;
                    <strong>Salary:</strong> {{ $salaryLabel }}
                </div>
            </div>
            <div class="comp-footer">
                <button type="button" class="btn-comp-ghost" data-znp-action="preview-email">Preview</button>
                <button type="button" class="btn-send" data-znp-action="send-email">Send Email</button>
                <button type="button" class="btn-comp-ghost" data-znp-close="apMsgModal">Discard</button>
            </div>
        </div>
    </div>

    {{-- Email preview --}}
    <div class="modal-overlay" id="apPreviewModal" style="align-items:flex-start;overflow-y:auto">
        <div class="composer">
            <div class="comp-head">
                <span class="comp-title">Email Preview</span>
                <button type="button" class="btn-comp-ghost" data-znp-close="apPreviewModal">×</button>
            </div>
            <div class="comp-field-row"><span class="cf-label">To</span><span id="apPreviewTo" style="font-size:12px;font-weight:600;color:var(--t2)"></span></div>
            <div class="comp-field-row"><span class="cf-label">Subject</span><span id="apPreviewSubject" style="font-size:12px;font-weight:600;color:var(--t2)"></span></div>
            <div class="comp-body" id="apPreviewBody" style="background:#fff;min-height:260px"></div>
            <div class="comp-footer">
                <button type="button" class="btn-comp-ghost" data-znp-close="apPreviewModal">Back to Edit</button>
                <button type="button" class="btn-send" data-znp-action="send-email">Send Email</button>
            </div>
        </div>
    </div>

    {{-- CV viewer --}}
    <div class="modal-overlay" id="apCvModal">
        <div class="sched-modal" style="max-width:900px;width:95%">
            <div class="sched-head">
                <span class="sched-title" id="apCvTitle">View CV</span>
                <a href="#" id="apCvDownloadBtn" class="cv-download-btn" target="_blank" rel="noopener">Download</a>
                <button type="button" class="btn-comp-ghost" data-znp-close="apCvModal">×</button>
            </div>
            <div class="sched-body" style="padding:0">
                <iframe id="apCvFrame" class="cv-frame" title="Candidate CV"></iframe>
                <div id="apCvPdfContainer" class="cv-pdf-container" style="display:none"></div>
                <div id="apCvWordContainer" class="cv-word-container" style="display:none"></div>
                <div id="apCvFallback" class="cv-fallback">
                    <p id="apCvFallbackMsg">This resume format cannot be previewed in the browser.</p>
                    <a href="#" id="apCvFallbackLink" class="btn-send" target="_blank" rel="noopener">Download Resume</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Reject modal --}}
    <div class="modal-overlay" id="apRejectModal">
        <div class="report-modal" style="max-width:420px">
            <div class="sched-head"><span class="sched-title">Reject Candidate</span><button type="button" class="btn-comp-ghost" data-znp-close="apRejectModal">×</button></div>
            <div class="sched-body">
                <div class="znp-opt sel"><input type="radio" name="rejectReason" checked> <span style="font-size:12px">Skills mismatch</span></div>
                <div class="znp-opt"><input type="radio" name="rejectReason"> <span style="font-size:12px">Salary expectations too high</span></div>
                <div class="znp-opt"><input type="radio" name="rejectReason"> <span style="font-size:12px">Position filled</span></div>
                <textarea class="sched-inp" rows="3" placeholder="Optional note…"></textarea>
            </div>
            <div class="sched-footer">
                <button type="button" class="btn-send" data-znp-action="confirm-reject">Confirm Reject</button>
                <button type="button" class="btn-comp-ghost" data-znp-close="apRejectModal">Cancel</button>
            </div>
        </div>
    </div>

    {{-- Report modal --}}
    <div class="modal-overlay" id="apReportModal">
        <div class="report-modal">
            <div class="sched-head"><span class="sched-title">Report Candidate</span><button type="button" class="btn-comp-ghost" data-znp-close="apReportModal">×</button></div>
            <div class="sched-body">
                <div class="znp-opt sel"><input type="radio" name="reportReason" checked> <span style="font-size:12px">Fake profile / resume</span></div>
                <div class="znp-opt"><input type="radio" name="reportReason"> <span style="font-size:12px">Spam application</span></div>
                <div class="znp-opt"><input type="radio" name="reportReason"> <span style="font-size:12px">Other</span></div>
                <textarea class="sched-inp" rows="3" placeholder="Details…"></textarea>
            </div>
            <div class="sched-footer">
                <button type="button" class="btn-send" data-znp-action="confirm-report">Submit Report</button>
                <button type="button" class="btn-comp-ghost" data-znp-close="apReportModal">Cancel</button>
            </div>
        </div>
    </div>

    {{-- Feedback modal --}}
    <div class="modal-overlay" id="apFeedbackModal">
        <div class="sched-modal" style="max-width:480px">
            <div class="sched-head"><span class="sched-title">Log Interview Feedback</span><button type="button" class="btn-comp-ghost" data-znp-close="apFeedbackModal">×</button></div>
            <div class="sched-body">
                <label class="sched-label">Candidate</label>
                <div id="apFbCandName" style="font-size:13px;font-weight:700;margin-bottom:12px"></div>
                <label class="sched-label">Overall Verdict</label>
                <div class="if-verdict-grid" id="apVerdictGrid">
                    @foreach(['sy'=>'Strong Yes','y'=>'Yes','m'=>'Maybe','n'=>'No','sn'=>'Strong No'] as $v => $lbl)
                        <div class="if-verdict {{ $v === 'y' ? 'sel' : '' }}" data-v="{{ $v }}">{{ $lbl }}</div>
                    @endforeach
                </div>
                <label class="sched-label">Comments</label>
                <textarea class="sched-inp" rows="4" id="apFbComments" placeholder="Private notes…"></textarea>
            </div>
            <div class="sched-footer">
                <button type="button" class="btn-send" data-znp-action="save-feedback">Save Feedback</button>
                <button type="button" class="btn-comp-ghost" data-znp-close="apFeedbackModal">Cancel</button>
            </div>
        </div>
    </div>

    {{-- Share modal --}}
    <div class="modal-overlay" id="apShareModal">
        <div class="sched-modal" style="max-width:440px">
            <div class="sched-head"><span class="sched-title">Share Job Listing</span><button type="button" class="btn-comp-ghost" data-znp-close="apShareModal">×</button></div>
            <div class="sched-body">
                <input class="sched-inp" readonly value="{{ !empty($job->slug) ? route('job.detail.znp', $job->slug) : url('/') }}">
            </div>
            <div class="sched-footer">
                <button type="button" class="btn-send" data-znp-action="copy-share">Copy Link</button>
                <button type="button" class="btn-comp-ghost" data-znp-close="apShareModal">Close</button>
            </div>
        </div>
    </div>

    <div class="toast" id="apToast"><span id="apToastMsg">Done</span></div>

    {{-- Help / Support --}}
    <div class="modal-overlay" id="apHelpModal">
        <div class="sched-modal" style="max-width:440px">
            <div class="sched-head">
                <div>
                    <span class="sched-title">Help &amp; Support</span>
                    <div style="font-size:11px;color:var(--t3);margin-top:2px">ZeroNoticePeriod · Employer Support</div>
                </div>
                <button type="button" class="btn-comp-ghost" data-znp-close="apHelpModal">×</button>
            </div>
            <div class="sched-body">
                <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:14px">
                    <div style="background:var(--blue-50);border:1px solid var(--blue-100);border-radius:9px;padding:11px 14px">
                        <div style="font-size:10px;font-weight:700;color:var(--blue);text-transform:uppercase;margin-bottom:2px">Call us</div>
                        <div style="font-size:14px;font-weight:800">+91 90354 79715</div>
                        <div style="font-size:11px;color:var(--t3);margin-top:2px">Mon–Sat · 9 AM–7 PM</div>
                    </div>
                    <div style="background:var(--green-50);border:1px solid var(--green-100);border-radius:9px;padding:11px 14px">
                        <div style="font-size:10px;font-weight:700;color:var(--green);text-transform:uppercase;margin-bottom:2px">Email us</div>
                        <div style="font-size:12.5px;font-weight:700">hello@zeronoticeperiod.com</div>
                    </div>
                </div>
                <textarea class="sched-inp" id="apHelpMessage" rows="4" placeholder="Describe your issue in detail…"></textarea>
            </div>
            <div class="sched-footer">
                <button type="button" class="btn-comp-ghost" data-znp-close="apHelpModal">Cancel</button>
                <button type="button" class="btn-send" data-znp-action="submit-help">Submit Request</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
<script>
    if (window['pdfjs-dist/build/pdf']) {
        window['pdfjs-dist/build/pdf'].GlobalWorkerOptions.workerSrc =
            'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';
    }
</script>
<script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
<script src="{{ asset('asset/script/docx-preview.js') }}"></script>
<script>
(function () {
    'use strict';

    var root = document.getElementById('znpApRoot');
    var jobId = root ? root.getAttribute('data-job-id') : '';
    var csrf = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = csrf ? csrf.getAttribute('content') : '';

    var routes = {
        shortlist:  '{{ url('post-job-page') }}/' + jobId + '/applicants/__APP__/shortlist',
        note:       '{{ url('post-job-page') }}/' + jobId + '/applicants/__APP__/note',
        feedback:   '{{ url('post-job-page') }}/' + jobId + '/applicants/__APP__/feedback',
        reject:     '{{ url('post-job-page') }}/' + jobId + '/applicants/__APP__/reject',
        report:     '{{ url('post-job-page') }}/' + jobId + '/applicants/__APP__/report',
        offer:      '{{ url('post-job-page') }}/' + jobId + '/applicants/__APP__/offer',
        viewCv:     '{{ url('post-job-page') }}/' + jobId + '/applicants/__APP__/view-cv',
        downloadCv: '{{ url('post-job-page') }}/' + jobId + '/applicants/__APP__/download-cv',
        emailTemplates: '{{ route('employer.applicant.email.templates', $job->id) }}',
        sendEmail: '{{ route('employer.applicant.email.send', $job->id) }}',
        retire:     '{{ route('employer.post.job.retire', $job->id) }}',
        helpSupport: '{{ route('employer.help.support', $job->id) }}'
    };

    var znpAp = {
        currentStage: 'all',
        currentMetric: 'all',
        jobExpMin: parseInt(root ? root.getAttribute('data-job-exp-min') || '0' : '0', 10),
        jobExpMax: parseInt(root ? root.getAttribute('data-job-exp-max') || '99' : '99', 10),
        activeCard: null,
        activeAppId: null,
        emailTemplates: [],
        emailState: { scope: 'single', applicationIds: [], cards: [] },

        url: function (key, appId) {
            return routes[key].replace('__APP__', appId);
        },

        post: function (url, data) {
            return fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data || {})
            }).then(function (r) {
                return r.json().then(function (j) {
                    if (!r.ok) throw new Error(j.message || 'Request failed');
                    return j;
                });
            });
        },

        escapeHtml: function (value) {
            return String(value || '').replace(/[&<>"']/g, function (ch) {
                return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[ch];
            });
        },

        selectedCards: function () {
            return Array.from(document.querySelectorAll('#apCandsGrid .ap-cand-check:checked'))
                .map(function (check) { return check.closest('.ccard'); })
                .filter(Boolean);
        },

        updateBulkBar: function () {
            var selected = znpAp.selectedCards().length;
            var bar = document.getElementById('apBulkBar');
            var count = document.getElementById('apBulkCount');
            if (count) count.textContent = selected + ' selected';
            if (bar) bar.style.display = selected > 0 ? 'flex' : 'none';
        },

        clearSelection: function () {
            document.querySelectorAll('.ap-cand-check').forEach(function (check) { check.checked = false; });
            var all = document.getElementById('apSelectAll');
            if (all) all.checked = false;
            znpAp.updateBulkBar();
        },

        loadTemplates: function () {
            if (znpAp._templatesLoaded) return Promise.resolve(znpAp.emailTemplates);
            return fetch(routes.emailTemplates, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    znpAp.emailTemplates = res.templates || [];
                    znpAp._templatesLoaded = true;
                    znpAp.renderTemplateOptions();
                    return znpAp.emailTemplates;
                });
        },

        renderTemplateOptions: function () {
            var select = document.getElementById('apTemplateSelect');
            if (!select) return;
            select.innerHTML = '<option value="">Choose template...</option>';
            znpAp.emailTemplates.forEach(function (tpl) {
                var option = document.createElement('option');
                option.value = tpl.id;
                option.textContent = tpl.name || ('Template #' + tpl.id);
                option.dataset.subject = tpl.subject || '';
                option.dataset.body = tpl.body || '';
                select.appendChild(option);
            });
        },

        defaultEmailBody: function (name) {
            return '<p>Hi ' + znpAp.escapeHtml(name || '[Candidate Name]') + ',</p>' +
                '<p>Thank you for applying for <strong>{{ addslashes($job->job_title) }}</strong> at {{ addslashes($company->name) }}. We reviewed your profile and would like to connect further.</p>' +
                '<p>Regards,<br>{{ addslashes($company->name) }}</p>';
        },

        openEmailComposer: function (scope, cards) {
            cards = cards || [];
            var ids = cards.map(function (card) { return card.getAttribute('data-app-id'); }).filter(Boolean);
            znpAp.emailState = { scope: scope, applicationIds: ids, cards: cards };

            var toLabel = 'All applicants';
            var title = 'Email All Applicants';
            var firstName = '';
            if (scope === 'single' && cards[0]) {
                firstName = cards[0].getAttribute('data-display-name') || '';
                toLabel = firstName + ' <' + (cards[0].getAttribute('data-email') || 'no email') + '>';
                title = 'Send Email';
            } else if (scope === 'selected') {
                toLabel = ids.length + ' selected applicants';
                title = 'Email Selected Applicants';
            }

            document.getElementById('apMsgTitle').textContent = title;
            document.getElementById('apMsgTo').value = toLabel;
            document.getElementById('apMsgSubject').value = 'Interview Opportunity — {{ addslashes($job->job_title) }} · {{ addslashes($company->name) }}';
            document.getElementById('apMsgBody').innerHTML = znpAp.defaultEmailBody(firstName || '[Candidate Name]');
            document.getElementById('apTemplateName').value = '';
            document.getElementById('apTemplateSelect').value = '';

            znpAp.loadTemplates().finally(function () {
                znpAp.openModal('apMsgModal');
            });
        },

        previewEmail: function () {
            document.getElementById('apPreviewTo').textContent = document.getElementById('apMsgTo').value;
            document.getElementById('apPreviewSubject').textContent = document.getElementById('apMsgSubject').value;
            document.getElementById('apPreviewBody').innerHTML = document.getElementById('apMsgBody').innerHTML;
            znpAp.openModal('apPreviewModal');
        },

        insertAtEditor: function (text) {
            var body = document.getElementById('apMsgBody');
            body.focus();
            document.execCommand('insertText', false, text);
        },

        toast: function (msg) {
            var el = document.getElementById('apToast');
            var tx = document.getElementById('apToastMsg');
            if (!el || !tx) return;
            tx.textContent = msg;
            el.classList.add('show');
            clearTimeout(znpAp._toastTimer);
            znpAp._toastTimer = setTimeout(function () { el.classList.remove('show'); }, 3200);
        },

        openModal: function (id) {
            var m = document.getElementById(id);
            if (m) m.classList.add('open');
        },

        resetHelpForm: function () {
            var msg = document.getElementById('apHelpMessage');
            if (msg) msg.value = '';
        },

        closeModal: function (id) {
            var m = document.getElementById(id);
            if (m) m.classList.remove('open');
            if (id === 'apCvModal') znpAp.resetCvViewer();
        },

        resetCvViewer: function () {
            var frame = document.getElementById('apCvFrame');
            var pdf = document.getElementById('apCvPdfContainer');
            var word = document.getElementById('apCvWordContainer');
            var fallback = document.getElementById('apCvFallback');
            if (frame) { frame.style.display = 'none'; frame.src = 'about:blank'; }
            if (pdf) { pdf.style.display = 'none'; pdf.innerHTML = ''; }
            if (word) { word.style.display = 'none'; word.innerHTML = ''; }
            if (fallback) fallback.style.display = 'none';
        },

        showCv: function (res, name) {
            znpAp.resetCvViewer();
            document.getElementById('apCvTitle').textContent = 'CV — ' + name;
            var dlBtn = document.getElementById('apCvDownloadBtn');
            if (dlBtn) dlBtn.href = res.download_url;
            var fallbackLink = document.getElementById('apCvFallbackLink');
            if (fallbackLink) fallbackLink.href = res.download_url;

            var type = (res.file_type || '').toLowerCase();
            if (type === 'pdf') {
                znpAp._renderPdfCv(res.cv_url);
            } else if (type === 'docx') {
                znpAp._renderDocxCv(res.cv_url);
            } else {
                var fb = document.getElementById('apCvFallback');
                var fbMsg = document.getElementById('apCvFallbackMsg');
                if (fbMsg) {
                    fbMsg.textContent = type === 'doc'
                        ? 'Older Word (.doc) files cannot be previewed here. Please download to view.'
                        : 'This resume format cannot be previewed in the browser.';
                }
                if (fb) fb.style.display = 'block';
            }
            znpAp.openModal('apCvModal');
        },

        _renderPdfCv: function (url) {
            var container = document.getElementById('apCvPdfContainer');
            var pdfjsLib = window['pdfjs-dist/build/pdf'];
            if (!container || !pdfjsLib) {
                var frame = document.getElementById('apCvFrame');
                if (frame) { frame.style.display = 'block'; frame.src = url; }
                return;
            }
            container.style.display = 'block';
            pdfjsLib.getDocument(url).promise.then(function (pdfDoc) {
                container.innerHTML = '';
                for (var i = 1; i <= pdfDoc.numPages; i++) {
                    (function (pageNum) {
                        pdfDoc.getPage(pageNum).then(function (page) {
                            var viewport = page.getViewport({ scale: 1.2 });
                            var canvas = document.createElement('canvas');
                            var ctx = canvas.getContext('2d');
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;
                            container.appendChild(canvas);
                            page.render({ canvasContext: ctx, viewport: viewport });
                        });
                    })(i);
                }
            }).catch(function () {
                container.style.display = 'none';
                var frame = document.getElementById('apCvFrame');
                if (frame) { frame.style.display = 'block'; frame.src = url; }
            });
        },

        _renderDocxCv: function (url) {
            var container = document.getElementById('apCvWordContainer');
            if (!container || typeof docx === 'undefined') {
                document.getElementById('apCvFallback').style.display = 'block';
                return;
            }
            container.style.display = 'block';
            var request = new XMLHttpRequest();
            request.open('GET', url, true);
            request.responseType = 'blob';
            request.onload = function () {
                var doc = new File([request.response], 'resume.docx', {
                    type: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                });
                var docxOptions = Object.assign(docx.defaultOptions, { useMathMLPolyfill: true });
                docx.renderAsync(doc, container, null, docxOptions).catch(function () {
                    container.style.display = 'none';
                    document.getElementById('apCvFallback').style.display = 'block';
                });
            };
            request.onerror = function () {
                container.style.display = 'none';
                document.getElementById('apCvFallback').style.display = 'block';
            };
            request.send();
        },

        cardFromBtn: function (btn) {
            return btn.closest('.ccard');
        },

        appIdFromCard: function (card) {
            return card ? card.getAttribute('data-app-id') : null;
        },

        setCardStage: function (card, stage) {
            if (!card || !stage) return;
            card.setAttribute('data-stage', stage);
            znpAp.recountStages();
            znpAp.applyFilters();
        },

        renderActivity: function (card, activity) {
            if (!card || !activity || !activity.length) return;
            var bar = card.querySelector('.ap-act-bar');
            if (!bar) return;
            var html = '';
            activity.forEach(function (step, i) {
                if (i > 0) {
                    html += '<div class="act-line ' + (step.state === 'done' || activity[i-1].state === 'done' ? 'done' : '') + '"></div>';
                }
                html += '<div style="display:flex;align-items:center;flex-shrink:0">' +
                    '<div class="act-dot ' + step.state + '"></div>' +
                    '<span class="act-label ' + step.state + '">' + step.label + '</span>' +
                    '<span class="act-date">' + step.date + '</span></div>';
            });
            var nextAction = card.getAttribute('data-next-action');
            var nextLabel = card.getAttribute('data-next-label');
            if (nextAction && nextLabel) {
                html += '<div class="act-pending-sep"></div>' +
                    '<div class="act-pending-step" data-znp-action="pending-' + nextAction + '" data-name="' + (card.getAttribute('data-display-name') || '') + '" title="Click to act">' +
                    '<div class="act-pending-dot"></div><span class="act-pending-label">' + nextLabel + '?</span></div>';
            }
            bar.innerHTML = html;
        },

        filterChecked: function (key) {
            var el = document.querySelector('.filter-opt[data-filter="' + key + '"]');
            return el ? el.classList.contains('checked') : true;
        },

        setMetricFilter: function (metric) {
            znpAp.currentMetric = metric || 'all';
            document.querySelectorAll('.metric-item[data-metric]').forEach(function (item) {
                item.classList.toggle('active', item.getAttribute('data-metric') === znpAp.currentMetric);
            });
            znpAp.applyFilters();
        },

        recountStages: function () {
            var counts = { all: 0, new: 0, shortlisted: 0, interview: 0, offer: 0, contractor: 0, resumedb: 0, rejected: 0 };
            document.querySelectorAll('#apCandsGrid .ccard').forEach(function (card) {
                counts.all++;
                var s = card.getAttribute('data-stage') || 'new';
                if (counts[s] !== undefined) counts[s]++;
            });
            Object.keys(counts).forEach(function (k) {
                var tab = document.querySelector('#apStageTabs .stab[data-stage="' + k + '"] .stab-n');
                if (tab) tab.textContent = counts[k];
            });
        },

        applyFilters: function () {
            var q = (document.getElementById('apSearch').value || '').trim().toLowerCase();
            var expMin = parseInt(document.getElementById('apExpMin').value || '0', 10);
            var expMax = parseInt(document.getElementById('apExpMax').value || '999', 10);
            var ctcMin = parseInt(document.getElementById('apCtcMin').value || '0', 10);
            var ctcMax = parseInt(document.getElementById('apCtcMax').value || '9999', 10);

            var fitHigh = document.querySelector('.filter-opt[data-filter="fit-high"]').classList.contains('checked');
            var fitMid  = document.querySelector('.filter-opt[data-filter="fit-mid"]').classList.contains('checked');
            var fitLow  = document.querySelector('.filter-opt[data-filter="fit-low"]').classList.contains('checked');
            var nImm    = document.querySelector('.filter-opt[data-filter="notice-immediate"]').classList.contains('checked');
            var nServ   = document.querySelector('.filter-opt[data-filter="notice-serving"]').classList.contains('checked');

            var visible = 0;
            document.querySelectorAll('#apCandsGrid .ccard').forEach(function (card) {
                var stage = card.getAttribute('data-stage') || 'new';
                var fit = parseInt(card.getAttribute('data-fit') || '0', 10);
                var exp = parseInt(card.getAttribute('data-exp') || '0', 10);
                var ctc = parseInt(card.getAttribute('data-ctc') || '0', 10);
                var notice = card.getAttribute('data-notice') || 'immediate';
                var search = card.getAttribute('data-search') || '';

                var ok = true;
                if (znpAp.currentStage !== 'all' && stage !== znpAp.currentStage) ok = false;
                if (q && search.indexOf(q) === -1) ok = false;
                if (exp < expMin || exp > expMax) ok = false;
                if (ctc > 0 && (ctc < ctcMin || ctc > ctcMax)) ok = false;

                var fitOk = (fit >= 80 && fitHigh) || (fit >= 60 && fit < 80 && fitMid) || (fit < 60 && fitLow);
                if (!fitOk) ok = false;

                var noticeOk = (notice === 'immediate' && nImm) || (notice === 'serving' && nServ) || (notice !== 'immediate' && notice !== 'serving' && nImm);
                if (!noticeOk) ok = false;

                var loc = card.getAttribute('data-location') || 'other';
                var locOk = (loc === 'mumbai' && znpAp.filterChecked('loc-mumbai'))
                    || (loc === 'pune' && znpAp.filterChecked('loc-pune'))
                    || (loc === 'bengaluru' && znpAp.filterChecked('loc-bengaluru'))
                    || (loc === 'hyderabad' && znpAp.filterChecked('loc-hyderabad'))
                    || (loc === 'delhi' && znpAp.filterChecked('loc-delhi'))
                    || (['mumbai', 'pune', 'bengaluru', 'hyderabad', 'delhi'].indexOf(loc) === -1 && znpAp.filterChecked('loc-other'));
                if (!locOk) ok = false;

                var mode = card.getAttribute('data-mode') || 'wfo';
                var modeOk = ((mode === 'wfo' || mode === 'office') && znpAp.filterChecked('mode-office'))
                    || (mode === 'hybrid' && znpAp.filterChecked('mode-hybrid'))
                    || (mode === 'remote' && znpAp.filterChecked('mode-remote'));
                if (!modeOk) ok = false;

                var type = card.getAttribute('data-type') || 'fulltime';
                var typeOk = (type === 'fulltime' && znpAp.filterChecked('type-fulltime'))
                    || (type === 'contract' && znpAp.filterChecked('type-contract'));
                if (!typeOk) ok = false;

                var edu = card.getAttribute('data-education') || 'other';
                var eduOk = (edu === 'btech' && znpAp.filterChecked('edu-btech'))
                    || (edu === 'mca' && znpAp.filterChecked('edu-mca'))
                    || (edu === 'bca' && znpAp.filterChecked('edu-bca'))
                    || (edu === 'other' && znpAp.filterChecked('edu-other'));
                if (!eduOk) ok = false;

                if (stage === 'new' || stage === 'shortlisted' || stage === 'interview') {
                    var stageSidebarOk = (stage === 'new' && znpAp.filterChecked('stage-new'))
                        || (stage === 'shortlisted' && znpAp.filterChecked('stage-shortlisted'))
                        || (stage === 'interview' && znpAp.filterChecked('stage-interview'));
                    if (!stageSidebarOk) ok = false;
                }

                if (znpAp.currentMetric && znpAp.currentMetric !== 'all') {
                    var withinBudget = card.getAttribute('data-within-budget');
                    var verified = card.getAttribute('data-verified');
                    var emailed = card.getAttribute('data-emailed');
                    if (znpAp.currentMetric === 'resumedb' && stage !== 'resumedb') ok = false;
                    if (znpAp.currentMetric === 'within' && withinBudget !== '1') ok = false;
                    if (znpAp.currentMetric === 'over' && withinBudget !== '0') ok = false;
                    if (znpAp.currentMetric === 'mumbai' && loc !== 'mumbai') ok = false;
                    if (znpAp.currentMetric === 'other_cities' && loc === 'mumbai') ok = false;
                    if (znpAp.currentMetric === 'exp_in_range' && (exp < znpAp.jobExpMin || exp > znpAp.jobExpMax)) ok = false;
                    if (znpAp.currentMetric === 'exp_senior' && exp <= znpAp.jobExpMax) ok = false;
                    if (znpAp.currentMetric === 'verified' && verified !== '1') ok = false;
                    if (znpAp.currentMetric === 'emailed' && emailed !== '1') ok = false;
                }

                card.style.display = ok ? '' : 'none';
                if (ok) visible++;
            });

            var rc = document.getElementById('apResultCount');
            if (rc) rc.innerHTML = 'Showing <strong>' + visible + '</strong> applicants';
        },

        sortCards: function (mode) {
            var grid = document.getElementById('apCandsGrid');
            if (!grid) return;
            var cards = Array.from(grid.querySelectorAll('.ccard'));
            cards.sort(function (a, b) {
                if (mode === 'exp') return parseInt(b.dataset.exp||0,10) - parseInt(a.dataset.exp||0,10);
                if (mode === 'ctc') return parseInt(a.dataset.ctc||0,10) - parseInt(b.dataset.ctc||0,10);
                if (mode === 'recent') return 0;
                return parseInt(b.dataset.fit||0,10) - parseInt(a.dataset.fit||0,10);
            });
            cards.forEach(function (c) { grid.appendChild(c); });
        }
    };

    window.znpAp = znpAp;

    document.querySelectorAll('.filter-opt[data-filter]').forEach(function (el) {
        el.addEventListener('click', function () {
            el.classList.toggle('checked');
            el.querySelector('.fo-check').textContent = el.classList.contains('checked') ? '✓' : '';
            znpAp.applyFilters();
        });
    });

    ['apSearch','apExpMin','apExpMax','apCtcMin','apCtcMax'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('input', znpAp.applyFilters);
    });

    document.getElementById('apClearFilters').addEventListener('click', function () {
        document.querySelectorAll('.filter-opt').forEach(function (f) {
            f.classList.add('checked');
            f.querySelector('.fo-check').textContent = '✓';
        });
        document.getElementById('apSearch').value = '';
        znpAp.setMetricFilter('all');
    });

    document.querySelectorAll('.metric-item[data-metric]').forEach(function (item) {
        item.addEventListener('click', function () {
            znpAp.setMetricFilter(item.getAttribute('data-metric'));
        });
    });

    document.addEventListener('click', function (e) {
        var avWrap = document.getElementById('apAvWrap');
        if (avWrap && !avWrap.contains(e.target)) avWrap.classList.remove('open');
    });

    document.querySelectorAll('#apStageTabs .stab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('#apStageTabs .stab').forEach(function (t) { t.classList.remove('active'); });
            tab.classList.add('active');
            znpAp.currentStage = tab.getAttribute('data-stage') || 'all';
            znpAp.applyFilters();
        });
    });

    var sortEl = document.getElementById('apSort');
    if (sortEl) sortEl.addEventListener('change', function () { znpAp.sortCards(this.value); });

    var selectAll = document.getElementById('apSelectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            var checked = this.checked;
            document.querySelectorAll('#apCandsGrid .ccard').forEach(function (card) {
                var box = card.querySelector('.ap-cand-check');
                if (box && card.style.display !== 'none') box.checked = checked;
            });
            znpAp.updateBulkBar();
        });
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('ap-cand-check')) znpAp.updateBulkBar();
    });

    var templateSelect = document.getElementById('apTemplateSelect');
    if (templateSelect) {
        templateSelect.addEventListener('change', function () {
            var option = this.options[this.selectedIndex];
            if (!option || !option.value) return;
            document.getElementById('apMsgSubject').value = option.dataset.subject || '';
            document.getElementById('apMsgBody').innerHTML = option.dataset.body || '';
        });
    }

    document.querySelectorAll('[data-znp-close]').forEach(function (btn) {
        btn.addEventListener('click', function () { znpAp.closeModal(btn.getAttribute('data-znp-close')); });
    });

    document.querySelectorAll('.modal-overlay').forEach(function (ov) {
        ov.addEventListener('click', function (e) {
            if (e.target === ov) ov.classList.remove('open');
        });
    });

    document.querySelectorAll('#apVerdictGrid .if-verdict').forEach(function (v) {
        v.addEventListener('click', function () {
            document.querySelectorAll('#apVerdictGrid .if-verdict').forEach(function (x) { x.classList.remove('sel'); });
            v.classList.add('sel');
        });
    });

    document.querySelectorAll('.znp-opt').forEach(function (opt) {
        opt.addEventListener('click', function () {
            opt.parentElement.querySelectorAll('.znp-opt').forEach(function (s) { s.classList.remove('sel'); });
            opt.classList.add('sel');
            var r = opt.querySelector('input[type=radio]');
            if (r) r.checked = true;
        });
    });

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-znp-action]');
        if (!btn) return;

        var action = btn.getAttribute('data-znp-action');
        var name = btn.getAttribute('data-name') || '';
        var card = znpAp.cardFromBtn(btn);
        var appId = znpAp.appIdFromCard(card);

        if (action === 'toggle-offer-menu') {
            var wrap = btn.closest('.offer-wrap');
            if (wrap) wrap.classList.toggle('open');
            return;
        }

        if (action === 'clear-selection') {
            znpAp.clearSelection();
            return;
        }

        if (action === 'help-support') {
            znpAp.resetHelpForm();
            znpAp.openModal('apHelpModal');
            return;
        }

        if (action === 'submit-help') {
            var helpMsg = (document.getElementById('apHelpMessage') || {}).value || '';
            if (!helpMsg.trim()) {
                znpAp.toast('Please describe your issue first.');
                return;
            }
            btn.disabled = true;
            znpAp.post(routes.helpSupport, {
                message: helpMsg.trim()
            }).then(function (res) {
                znpAp.closeModal('apHelpModal');
                znpAp.resetHelpForm();
                znpAp.toast(res.message || 'Support request submitted.');
            }).catch(function (err) {
                znpAp.toast(err.message || 'Could not submit support request.');
            }).finally(function () {
                btn.disabled = false;
            });
            return;
        }

        if (action === 'toggle-av-menu') {
            var wrap = document.getElementById('apAvWrap');
            if (wrap) wrap.classList.toggle('open');
            return;
        }

        if (action.indexOf('pending-') === 0) {
            var pending = action.replace('pending-', '');
            if (pending === 'shortlist') {
                var sl = card.querySelector('[data-znp-action="shortlist"]');
                if (sl) sl.click();
            } else if (pending === 'email') {
                znpAp.openEmailComposer('single', [card]);
            } else if (pending === 'feedback') {
                znpAp.activeCard = card;
                znpAp.activeAppId = appId;
                document.getElementById('apFbCandName').textContent = name;
                znpAp.openModal('apFeedbackModal');
            } else if (pending === 'profile') {
                var profileLink = card.querySelector('a.abtn[href]');
                if (profileLink) window.open(profileLink.href, '_blank');
            }
            if (btn.classList.contains('pending-btn')) {
                btn.classList.add('done');
                btn.textContent = '✓ Done';
            }
            return;
        }

        if (action === 'email') {
            znpAp.openEmailComposer('single', [card]);
            return;
        }

        if (action === 'email-selected') {
            var selected = znpAp.selectedCards();
            if (!selected.length) {
                znpAp.toast('Select at least one applicant.');
                return;
            }
            znpAp.openEmailComposer('selected', selected);
            return;
        }

        if (action === 'email-all') {
            znpAp.openEmailComposer('all', []);
            return;
        }

        if (action === 'preview-email') {
            znpAp.previewEmail();
            return;
        }

        if (action === 'fmt-bold') {
            document.execCommand('bold', false, null);
            return;
        }

        if (action === 'fmt-italic') {
            document.execCommand('italic', false, null);
            return;
        }

        if (action === 'fmt-ul') {
            document.execCommand('insertUnorderedList', false, null);
            return;
        }

        if (action === 'insert-var') {
            znpAp.insertAtEditor(btn.getAttribute('data-var') || '');
            return;
        }

        if (action === 'send-email') {
            var payload = {
                scope: znpAp.emailState.scope,
                application_ids: znpAp.emailState.applicationIds,
                subject: document.getElementById('apMsgSubject').value,
                body: document.getElementById('apMsgBody').innerHTML,
                template_id: document.getElementById('apTemplateSelect').value || null,
                save_template_name: document.getElementById('apTemplateName').value || null
            };

            btn.disabled = true;
            znpAp.post(routes.sendEmail, payload).then(function (res) {
                var cards = znpAp.emailState.scope === 'all'
                    ? Array.from(document.querySelectorAll('#apCandsGrid .ccard'))
                    : (znpAp.emailState.cards || []);
                cards.forEach(function (emailCard) {
                    if (res.application_ids && res.application_ids.indexOf(parseInt(emailCard.getAttribute('data-app-id'), 10)) === -1) return;
                    var emailBtn = emailCard.querySelector('[data-znp-action="email"]');
                    if (emailBtn) {
                        emailBtn.classList.add('emailed-done');
                        emailBtn.textContent = 'Emailed';
                    }
                    if (res.activities && res.activities[emailCard.getAttribute('data-app-id')]) {
                        znpAp.renderActivity(emailCard, res.activities[emailCard.getAttribute('data-app-id')]);
                    }
                });

                var metric = document.getElementById('apEmailedMetric');
                if (metric && res.metric !== undefined) metric.textContent = res.metric;

                znpAp.closeModal('apMsgModal');
                znpAp.closeModal('apPreviewModal');
                znpAp.clearSelection();
                znpAp.toast('Email sent to ' + res.sent_count + ' applicant(s)' + (res.failed_count ? ', ' + res.failed_count + ' failed' : ''));
            }).catch(function (err) {
                znpAp.toast(err.message);
            }).finally(function () {
                btn.disabled = false;
            });
            return;
        }

        if (action === 'share') { znpAp.openModal('apShareModal'); return; }

        if (action === 'copy-share') {
            var inp = document.querySelector('#apShareModal input');
            if (inp && navigator.clipboard) {
                navigator.clipboard.writeText(inp.value).then(function () {
                    znpAp.toast('Link copied to clipboard');
                });
            }
            znpAp.closeModal('apShareModal');
            return;
        }

        if (action === 'retire') {
            if (!confirm('Retire this job listing?')) return;
            znpAp.post(routes.retire, {}).then(function () {
                znpAp.toast('Job retired successfully');
            }).catch(function (err) { znpAp.toast(err.message); });
            return;
        }

        if (!appId && action !== 'confirm-reject' && action !== 'confirm-report' && action !== 'save-feedback') return;

        if (action === 'reject') {
            znpAp.activeCard = card;
            znpAp.activeAppId = appId;
            znpAp.openModal('apRejectModal');
            return;
        }
        if (action === 'report') {
            znpAp.activeCard = card;
            znpAp.activeAppId = appId;
            znpAp.openModal('apReportModal');
            return;
        }
        if (action === 'feedback') {
            znpAp.activeCard = card;
            znpAp.activeAppId = appId;
            document.getElementById('apFbCandName').textContent = name;
            znpAp.openModal('apFeedbackModal');
            return;
        }
        if (action === 'notes') {
            var panel = card.querySelector('[data-notes-panel]');
            if (panel) panel.classList.toggle('open');
            return;
        }
        if (action === 'close-notes') {
            var p = card.querySelector('[data-notes-panel]');
            if (p) p.classList.remove('open');
            return;
        }
        if (action === 'save-note') {
            var body = (card.querySelector('[data-note-input]') || {}).value || '';
            znpAp.post(znpAp.url('note', appId), { body: body }).then(function (res) {
                var strip = card.querySelector('[data-note-strip]');
                if (strip) {
                    strip.classList.add('show');
                    var meta = strip.querySelector('[data-note-meta]');
                    var text = strip.querySelector('[data-note-text]');
                    if (meta) meta.textContent = res.note.updated_at;
                    if (text) text.textContent = res.note.body;
                }
                card.querySelector('[data-notes-panel]').classList.remove('open');
                znpAp.renderActivity(card, res.activity);
                znpAp.toast('Note saved');
            }).catch(function (err) { znpAp.toast(err.message); });
            return;
        }
        if (action === 'shortlist') {
            znpAp.post(znpAp.url('shortlist', appId), {}).then(function (res) {
                var slBtn = card.querySelector('[data-znp-action="shortlist"]');
                if (slBtn) {
                    slBtn.classList.toggle('done', res.shortlisted);
                    slBtn.textContent = res.shortlisted ? 'Shortlisted' : 'Shortlist';
                }
                znpAp.setCardStage(card, res.stage);
                znpAp.renderActivity(card, res.activity);
                znpAp.toast(res.shortlisted ? 'Candidate shortlisted' : 'Removed from shortlist');
            }).catch(function (err) { znpAp.toast(err.message); });
            return;
        }
        if (action === 'view-cv') {
            znpAp.post(znpAp.url('viewCv', appId), {}).then(function (res) {
                znpAp.showCv(res, name);
                znpAp.renderActivity(card, res.activity);
            }).catch(function (err) { znpAp.toast(err.message); });
            return;
        }
        if (action === 'download-cv') {
            znpAp.post(znpAp.url('downloadCv', appId), {}).then(function (res) {
                window.open(res.download_url, '_blank');
                znpAp.renderActivity(card, res.activity);
                znpAp.toast('Downloading CV');
            }).catch(function (err) { znpAp.toast(err.message); });
            return;
        }
        if (action === 'offer') {
            var status = btn.getAttribute('data-offer-status') || 'offered';
            var offerCard = znpAp.cardFromBtn(btn);
            var offerAppId = znpAp.appIdFromCard(offerCard);
            znpAp.post(znpAp.url('offer', offerAppId), { status: status }).then(function (res) {
                var offerBtn = offerCard.querySelector('[data-znp-action="toggle-offer-menu"]');
                if (offerBtn) {
                    offerBtn.classList.add('done');
                    offerBtn.classList.remove('locked');
                    offerBtn.textContent = res.offer_label;
                }
                var rejectBtn = offerCard.querySelector('[data-znp-action="reject"]');
                if (rejectBtn) {
                    rejectBtn.classList.add('locked');
                    rejectBtn.classList.remove('done');
                }
                var statusStrip = offerCard.querySelector('[data-status-strip]');
                if (statusStrip) {
                    statusStrip.classList.add('show');
                    statusStrip.querySelector('[data-status-text]').innerHTML = '<strong>' + res.offer_label + '</strong>';
                }
                offerCard.querySelector('.offer-wrap').classList.remove('open');
                znpAp.setCardStage(offerCard, res.stage);
                znpAp.renderActivity(offerCard, res.activity);
                znpAp.toast('Offer status updated');
            }).catch(function (err) { znpAp.toast(err.message); });
            return;
        }
        if (action === 'confirm-reject') {
            var reasonEl = document.querySelector('#apRejectModal .znp-opt.sel span');
            var reason = reasonEl ? reasonEl.textContent.trim() : 'Skills mismatch';
            var noteEl = document.querySelector('#apRejectModal textarea');
            znpAp.post(znpAp.url('reject', znpAp.activeAppId), {
                reason: reason,
                note: noteEl ? noteEl.value : ''
            }).then(function (res) {
                var rCard = znpAp.activeCard;
                var rejectBtn = rCard.querySelector('[data-znp-action="reject"]');
                if (rejectBtn) {
                    rejectBtn.classList.add('done');
                    rejectBtn.classList.remove('locked');
                }
                var offerBtn = rCard.querySelector('[data-znp-action="toggle-offer-menu"]');
                if (offerBtn) {
                    offerBtn.classList.add('locked');
                    offerBtn.classList.remove('done');
                    offerBtn.textContent = 'Move to Offer';
                }
                var statusStrip = rCard.querySelector('[data-status-strip]');
                if (statusStrip) {
                    statusStrip.classList.add('show');
                    statusStrip.querySelector('[data-status-text]').textContent = 'Rejected: ' + reason;
                }
                znpAp.setCardStage(rCard, res.stage);
                znpAp.renderActivity(rCard, res.activity);
                znpAp.closeModal('apRejectModal');
                znpAp.toast('Candidate rejected');
            }).catch(function (err) { znpAp.toast(err.message); });
            return;
        }
        if (action === 'confirm-report') {
            var rReasonEl = document.querySelector('#apReportModal .znp-opt.sel span');
            var rReason = rReasonEl ? rReasonEl.textContent.trim() : 'Fake profile / resume';
            var rDetails = document.querySelector('#apReportModal textarea');
            znpAp.post(znpAp.url('report', znpAp.activeAppId), {
                reason: rReason,
                details: rDetails ? rDetails.value : ''
            }).then(function (res) {
                var rpCard = znpAp.activeCard;
                var reportBtn = rpCard.querySelector('[data-znp-action="report"]');
                if (reportBtn) reportBtn.classList.add('done');
                znpAp.renderActivity(rpCard, res.activity);
                znpAp.closeModal('apReportModal');
                znpAp.toast('Report submitted');
            }).catch(function (err) { znpAp.toast(err.message); });
            return;
        }
        if (action === 'save-feedback') {
            var verdictEl = document.querySelector('#apVerdictGrid .if-verdict.sel');
            var verdict = verdictEl ? verdictEl.getAttribute('data-v') : 'y';
            var comments = document.getElementById('apFbComments').value || '';
            znpAp.post(znpAp.url('feedback', znpAp.activeAppId), {
                verdict: verdict,
                comments: comments
            }).then(function (res) {
                var fbCard = znpAp.activeCard;
                var strip = fbCard.querySelector('[data-feedback-strip]');
                if (strip) {
                    strip.classList.add('show');
                    strip.querySelector('[data-feedback-meta]').textContent = res.feedback.verdict_label + ' · ' + res.feedback.created_at;
                    strip.querySelector('[data-feedback-text]').textContent = res.feedback.comments || '';
                }
                znpAp.renderActivity(fbCard, res.activity);
                znpAp.closeModal('apFeedbackModal');
                znpAp.toast('Feedback saved');
            }).catch(function (err) { znpAp.toast(err.message); });
            return;
        }
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.offer-wrap')) {
            document.querySelectorAll('.offer-wrap.open').forEach(function (w) { w.classList.remove('open'); });
        }
    });

    znpAp.applyFilters();
})();
</script>
@endpush
