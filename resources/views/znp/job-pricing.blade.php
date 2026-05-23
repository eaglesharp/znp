@extends('layouts.znp')

@section('page_title', 'Pricing — Job Posts | ZeroNoticePeriod')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* Scoped ZNP job pricing page (matches client HTML; never leak global Bootstrap) */
.znp-jp {
    --jp-blue:#3B5CCC; --jp-blue-d:#2d47a3; --jp-blue-light:#EEF1FB; --jp-blue-100:#D6DEFC;
    --jp-orange:#F2994A; --jp-orange-d:#e0852e; --jp-orange-light:#FEF3E8; --jp-orange-100:#fde8c8;
    --jp-green:#15803d; --jp-green-50:#f0fdf4; --jp-green-100:#dcfce7;
    --jp-bg:#F7F8FC; --jp-surface:#fff; --jp-border:#E7EAF3;
    --jp-text:#2F3443; --jp-t2:#4A5068; --jp-t3:#717A96; --jp-t4:#A0AABF;
    --jp-shadow:0 2px 12px rgba(59,92,204,.07),0 1px 3px rgba(47,52,67,.04);
    --jp-shadow-md:0 8px 32px rgba(59,92,204,.11),0 2px 8px rgba(47,52,67,.05);
    --jp-shadow-lg:0 24px 64px rgba(59,92,204,.14),0 4px 16px rgba(47,52,67,.06);
    --jp-r:16px; --jp-r-sm:10px; --jp-r-lg:24px;
    --jp-font:'Manrope',sans-serif;
    font-family: var(--jp-font), 'Inter', sans-serif !important;
    background: var(--jp-bg); color: var(--jp-text);
    font-size: 14px;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    min-height: 100vh;
}
.znp-jp, .znp-jp *, .znp-jp *::before, .znp-jp *::after {
    box-sizing: border-box;
}
.znp-jp a {
    color: inherit;
    text-decoration: none;
}
.znp-jp button {
    cursor: pointer;
    font-family: inherit;
}

.znp-jp .jp-nav {
    background: rgba(255,255,255,.95); backdrop-filter: blur(14px);
    border-bottom: 1px solid var(--jp-border);
    padding: 0 max(24px,calc(50% - 620px));
    height: 56px; display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 100;
}
.znp-jp .jp-logo { font-size: 15px; font-weight: 800; letter-spacing: -.3px; }
.znp-jp .jp-la { color: var(--jp-blue); } .znp-jp .jp-lb { color: var(--jp-orange); } .znp-jp .jp-lc { color: var(--jp-blue); }
.znp-jp .jp-nav-r { display: flex; gap: 10px; }
.znp-jp .jp-nb {
    padding: 6px 18px; border-radius: 50px; font-size: 12px; font-weight: 600;
    transition: all .2s; display: inline-flex; align-items: center; border: none;
    cursor: pointer; font-family: var(--jp-font);
}
.znp-jp .jp-nb-o { border: 1.5px solid var(--jp-border); background: transparent; color: var(--jp-t2); }
.znp-jp .jp-nb-o:hover { border-color: var(--jp-blue); color: var(--jp-blue); }
.znp-jp .jp-nb-p { background: var(--jp-blue); color: #fff; box-shadow: 0 2px 8px rgba(59,92,204,.28); }
.znp-jp .jp-nb-p:hover { background: var(--jp-blue-d); transform: translateY(-1px); }

.znp-jp .jp-hero { text-align: center; padding: 36px max(24px,calc(50% - 620px)) 28px; position: relative; overflow: hidden; }
.znp-jp .jp-hero::before {
    content: ''; position: absolute; top: -120px; left: 50%; transform: translateX(-50%);
    width: 800px; height: 500px;
    background: radial-gradient(ellipse, rgba(59,92,204,.07) 0%, transparent 70%);
    pointer-events: none;
}
.znp-jp .jp-hero h1 { font-size: 24px; font-weight: 800; color: var(--jp-text); letter-spacing: -.5px; line-height: 1.2; margin: 0; }
.znp-jp .jp-hero h1 em { color: var(--jp-blue); font-style: normal; }

.znp-jp .jp-plans { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; padding: 24px max(24px,calc(50% - 620px)) 28px; align-items: stretch; }

.znp-jp .jp-plan {
    background: var(--jp-surface); border: 1.5px solid var(--jp-border); border-radius: var(--jp-r);
    padding: 20px 22px; box-shadow: var(--jp-shadow); transition: all .25s;
    position: relative; overflow: hidden; display: flex; flex-direction: column;
}
.znp-jp .jp-plan:hover { box-shadow: var(--jp-shadow-md); transform: translateY(-3px); }
.znp-jp .jp-plan.featured {
    background: linear-gradient(160deg,var(--jp-blue) 0%,var(--jp-blue-d) 100%); border-color: var(--jp-blue);
    box-shadow: var(--jp-shadow-lg); color: #fff;
}
.znp-jp .jp-plan.featured:hover { transform: translateY(-3px); }
.znp-jp .jp-plan.featured::before { content:''; position:absolute; top:-60px; right:-60px; width:200px; height:200px;
    background: rgba(255,255,255,.06); border-radius:50%;
}
.znp-jp .jp-plan.featured::after {
    content:''; position:absolute; bottom:-40px; left:-40px; width:150px; height:150px;
    background: rgba(255,255,255,.04); border-radius:50%;
}

.znp-jp .jp-popular-badge {
    display: inline-flex; align-items: center; gap: 5px; background: var(--jp-orange); color: #fff;
    font-size: 10px; font-weight: 700; padding: 2px 9px; border-radius: 50px; margin-bottom: 10px; letter-spacing: .04em;
}
.znp-jp .jp-plan:not(.featured) .jp-plan-tag {
    display: inline-flex; align-items: center; gap: 5px; background: var(--jp-blue-light); color: var(--jp-blue);
    font-size: 10px; font-weight: 700; padding: 2px 9px; border-radius: 50px; margin-bottom: 10px; letter-spacing: .04em;
}
.znp-jp .jp-plan.enterprise .jp-plan-tag { background: var(--jp-orange-light); color: var(--jp-orange); }

.znp-jp .jp-plan-name { font-size: 16px; font-weight: 800; color: var(--jp-text); margin-bottom: 4px; letter-spacing: -.3px; }
.znp-jp .jp-plan.featured .jp-plan-name { color: #fff; }
.znp-jp .jp-plan-desc { font-size: 11.5px; color: var(--jp-t3); margin-bottom: 14px; line-height: 1.5; }
.znp-jp .jp-plan.featured .jp-plan-desc { color: rgba(255,255,255,.65); }

.znp-jp .jp-price-row { min-height: 82px; display: flex; flex-direction: column; justify-content: flex-start; margin-bottom: 0; }
.znp-jp .jp-price {
    font-size: 28px; font-weight: 800; color: var(--jp-text); letter-spacing: -.6px; line-height: 1;
    display: inline-flex; align-items: center; gap: 2px; flex-wrap: nowrap;
}
.znp-jp .jp-plan.featured .jp-price { color: #fff; }
.znp-jp .jp-price-currency { font-size: 0.58em; font-weight: 800; line-height: 1; flex-shrink: 0; }
.znp-jp .jp-price-num { letter-spacing: inherit; }
.znp-jp .jp-price-per { font-size: 11px; color: var(--jp-t4); margin-top: 5px; font-weight: 500; line-height: 1.4; }
.znp-jp .jp-plan.featured .jp-price-per { color: rgba(255,255,255,.5); }
.znp-jp .jp-price-monthly { font-size: 10.5px; color: var(--jp-t3); margin-top: 3px; font-weight: 500; }
.znp-jp .jp-plan.featured .jp-price-monthly { color: rgba(255,255,255,.45); }
.znp-jp .jp-price-original { font-size: 12px; color: var(--jp-t4); text-decoration: line-through; margin-left: 6px; font-weight: 500; }
.znp-jp .jp-plan.featured .jp-price-original { color: rgba(255,255,255,.4); }
.znp-jp .jp-price-save {
    font-size: 10.5px; font-weight: 700; color: #15803d; background: #f0fdf4; border: 1px solid #bbf7d0;
    padding: 1px 7px; border-radius: 20px; margin-left: 6px;
}
.znp-jp .jp-plan.featured .jp-price-save { color:#4ade80; background: rgba(74,222,128,.15); border-color: rgba(74,222,128,.3); }

.znp-jp .jp-plan-btn {
    display: block; width: 100%; padding: 9px; border-radius: 50px; font-size: 12px; font-weight: 700;
    text-align: center; border: none; transition: all .2s; letter-spacing: .01em; font-family: var(--jp-font);
}
.znp-jp .jp-btn-blue { background: var(--jp-blue); color: #fff; box-shadow: 0 4px 12px rgba(59,92,204,.28); }
.znp-jp .jp-btn-blue:hover { background: var(--jp-blue-d); transform: translateY(-1px); color: #fff !important; }
.znp-jp .jp-btn-white { background: #fff; color: var(--jp-blue); box-shadow: 0 4px 12px rgba(0,0,0,.1); }
.znp-jp .jp-btn-white:hover { background: #f0f4ff; transform: translateY(-1px); color: var(--jp-blue); }
.znp-jp .jp-btn-outline { background: transparent; color: var(--jp-blue); border: 2px solid var(--jp-blue); }
.znp-jp .jp-btn-outline:hover { background: var(--jp-blue); color: #fff; }

.znp-jp .jp-plan-divider { height: 1px; background: var(--jp-border); margin: 14px 0; }
.znp-jp .jp-plan.featured .jp-plan-divider { background: rgba(255,255,255,.15); }

.znp-jp .jp-features { display: flex; flex-direction: column; gap: 7px; flex: 1; }
.znp-jp .jp-feat-row { display: flex; align-items: flex-start; gap: 8px; font-size: 11.5px; color: var(--jp-t2); line-height: 1.4; }
.znp-jp .jp-plan.featured .jp-feat-row { color: rgba(255,255,255,.85); }
.znp-jp .jp-feat-check {
    width: 16px; height: 16px; border-radius: 50%; background: var(--jp-blue-light);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px;
}
.znp-jp .jp-plan.featured .jp-feat-check { background: rgba(255,255,255,.18); }
.znp-jp .jp-feat-check svg { width: 9px; height: 9px; stroke: var(--jp-blue); stroke-width: 2.5; fill: none; }
.znp-jp .jp-plan.featured .jp-feat-check svg { stroke: #fff; }
.znp-jp .jp-feat-no {
    width: 16px; height: 16px; border-radius: 50%; background: #f1f5f9;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px;
}
.znp-jp .jp-plan.featured .jp-feat-no { background: rgba(255,255,255,.1); }
.znp-jp .jp-feat-no svg { width: 9px; height: 9px; stroke: var(--jp-t4); stroke-width: 2; fill: none; }
.znp-jp .jp-plan.featured .jp-feat-no svg { stroke: rgba(255,255,255,.3); }
.znp-jp .jp-feat-label { font-weight: 600; font-size: 11.5px; }
.znp-jp .jp-feat-note { font-size: 10px; color: var(--jp-t4); margin-top: 1px; }
.znp-jp .jp-plan.featured .jp-feat-note { color: rgba(255,255,255,.4); }
.znp-jp .jp-feat-muted { color: var(--jp-t4) !important; }

.znp-jp .jp-trust {
    background: var(--jp-surface); border-top: 1px solid var(--jp-border); border-bottom: 1px solid var(--jp-border);
    padding: 20px max(24px,calc(50% - 620px)); display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 16px; text-align: center;
}
.znp-jp .jp-trust-ico {
    width: 36px; height: 36px; border-radius: 10px; background: var(--jp-blue-light);
    display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;
}
.znp-jp .jp-trust-title { font-size: 12.5px; font-weight: 700; color: var(--jp-text); margin-bottom: 2px; }
.znp-jp .jp-trust-desc { font-size: 11px; color: var(--jp-t4); line-height: 1.5; }

.znp-jp .jp-faq-section { padding: 32px max(24px,calc(50% - 620px)); }
.znp-jp .jp-faq-head { text-align: center; margin-bottom: 20px; }
.znp-jp .jp-faq-head h2 { font-size: 20px; font-weight: 800; color: var(--jp-text); letter-spacing: -.4px; margin: 0 0 4px; }
.znp-jp .jp-faq-head p { font-size: 13px; color: var(--jp-t3); margin: 0; }
.znp-jp .jp-faq-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.znp-jp .jp-faq-item {
    background: var(--jp-surface); border: 1px solid var(--jp-border); border-radius: var(--jp-r-sm);
    padding: 12px 14px; cursor: pointer; transition: all .2s;
    width: 100%; text-align: left; font-family: var(--jp-font); color: var(--jp-text); line-height: 1.35;
}
.znp-jp .jp-faq-item:hover { border-color: var(--jp-blue); box-shadow: var(--jp-shadow); }
.znp-jp .jp-faq-q { font-size: 12.5px; font-weight: 700; color: var(--jp-text); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
.znp-jp .jp-faq-icon {
    width: 20px; height: 20px; border-radius: 50%; background: var(--jp-blue-light); color: var(--jp-blue);
    display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; transition: transform .2s;
}
.znp-jp .jp-faq-item.open .jp-faq-icon { transform: rotate(45deg); }
.znp-jp .jp-faq-a { font-size: 12px; color: var(--jp-t3); line-height: 1.65; margin-top: 10px; display: none; }
.znp-jp .jp-faq-item.open .jp-faq-a { display: block; }

.znp-jp .jp-cta-block {
    margin: 0 max(24px,calc(50% - 620px)) 36px;
    background: linear-gradient(135deg,var(--jp-blue-d) 0%,var(--jp-blue) 60%,#4a72dd 100%);
    border-radius: var(--jp-r-lg); padding: 30px 28px; text-align: center; position: relative; overflow: hidden;
}
.znp-jp .jp-cta-block::before {
    content:''; position:absolute; top:-80px; left:50%; transform:translateX(-50%);
    width:600px; height:300px; background: radial-gradient(ellipse,rgba(255,255,255,.08) 0%,transparent 70%);
}
.znp-jp .jp-cta-block h2 { font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -.4px; margin: 0 0 6px; position: relative; }
.znp-jp .jp-cta-block p { font-size: 13px; color: rgba(255,255,255,.7); margin: 0 0 24px; position: relative; }
.znp-jp .jp-cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; position: relative; }
.znp-jp .jp-cta-btn-a {
    background: #fff; color: var(--jp-blue); padding: 11px 28px; border-radius: 50px; font-size: 13px; font-weight: 700;
    font-family: var(--jp-font); border: none; cursor: pointer; transition: all .2s; box-shadow: 0 4px 12px rgba(0,0,0,.12);
}
.znp-jp .jp-cta-btn-a:hover { background: #f0f4ff; transform: translateY(-2px); color: var(--jp-blue); }
.znp-jp .jp-cta-btn-b {
    background: transparent; color: #fff; padding: 11px 28px; border-radius: 50px; font-size: 13px; font-weight: 600;
    font-family: var(--jp-font); border: 2px solid rgba(255,255,255,.4); cursor: pointer; transition: all .2s;
}
.znp-jp .jp-cta-btn-b:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.8); transform: translateY(-2px); }

@keyframes jpFadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}
.znp-jp .jp-plans .jp-plan { animation: jpFadeUp .4s ease both; }
.znp-jp .jp-plans .jp-plan:nth-child(1) { animation-delay: .05s; }
.znp-jp .jp-plans .jp-plan:nth-child(2) { animation-delay: .12s; }
.znp-jp .jp-plans .jp-plan:nth-child(3) { animation-delay: .19s; }

@media (max-width: 900px) {
    .znp-jp .jp-plans { grid-template-columns: 1fr; max-width: 440px; margin: 0 auto; }
    .znp-jp .jp-trust { grid-template-columns: repeat(2, 1fr); }
    .znp-jp .jp-faq-grid { grid-template-columns: 1fr; }
}
@media (max-width: 560px) {
    .znp-jp .jp-trust { grid-template-columns: 1fr; }
    .znp-jp .jp-cta-btns { flex-direction: column; align-items: center; }
}
</style>
@endpush

@section('content')
<div class="znp-jp">

<nav class="jp-nav">
    <a class="jp-logo" href="{{ route('index') }}"><span class="jp-la">Zero</span><span class="jp-lb">Notice</span><span class="jp-lc">Period</span></a>
    <div class="jp-nav-r">
        <a href="{{ route('jobs.page') }}" class="jp-nb jp-nb-o">Find Jobs</a>
        <a href="{{ url('post-job') }}" class="jp-nb jp-nb-p">Post a Job</a>
    </div>
</nav>

<div class="jp-hero">
    <h1>Hire immediately. <em>Pay only for what you need.</em></h1>
</div>

<div class="jp-plans">

    <div class="jp-plan">
        <div class="jp-plan-tag">Single Job</div>
        <div class="jp-plan-name">Quick Job</div>
        <div class="jp-plan-desc">Perfect for occasional hiring. Pay per job — no commitment, no subscription.</div>
        <div class="jp-price-row">
            <div>
                <span class="jp-price"><span class="jp-price-currency">₹</span><span class="jp-price-num">2,999</span></span>
            </div>
            <div class="jp-price-per">per job post · shown across all metros · valid 30 days · + GST</div>
            <div class="jp-price-monthly">Billed monthly — pay only when you post</div>
        </div>
        <div class="jp-plan-divider"></div>
        <div class="jp-features">
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">1 active job post · shown across all metros</div><div class="jp-feat-note">Goes live within 30 minutes of review</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Applications from immediate joiners &amp; serving notice</div><div class="jp-feat-note">Verified zero &amp; short notice period candidates only</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Applications from contractors</div><div class="jp-feat-note">Access freelance &amp; contract talent on day-rate</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Verification of notice period</div><div class="jp-feat-note">Every applicant's notice period is independently verified</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">KYC verification required</div><div class="jp-feat-note">One-time employer verification before going live</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Applicant dashboard</div><div class="jp-feat-note">View, shortlist and manage applications</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Email support</div></div></div>
        </div>
        <a href="{{ url('post-job') }}" class="jp-plan-btn jp-btn-outline" style="margin-top:18px">Get Started →</a>
    </div>

    <div class="jp-plan featured">
        <div class="jp-popular-badge">⚡ Most Popular</div>
        <div class="jp-plan-name">Flex</div>
        <div class="jp-plan-desc">For teams hiring regularly. 10 posts at a significant discount with premium features included.</div>
        <div class="jp-price-row">
            <div>
                <span class="jp-price"><span class="jp-price-currency">₹</span><span class="jp-price-num">25,000</span></span>
                <span class="jp-price-original">₹29,990</span>
                <span class="jp-price-save">Save ₹4,990</span>
            </div>
            <div class="jp-price-per">10 job posts · ₹2,500 per post · valid 90 days · each post active 30 days · + GST</div>
            <div class="jp-price-monthly">Billed monthly — activate posts anytime within 90 days</div>
        </div>
        <div class="jp-plan-divider"></div>
        <div class="jp-features">
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">10 job posts · shown across all metros</div><div class="jp-feat-note">Each post stays active for 30 days · activate anytime within 90 days of purchase</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Applications from immediate joiners &amp; serving notice</div><div class="jp-feat-note">Verified zero &amp; short notice period candidates only</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Applications from contractors</div><div class="jp-feat-note">Access freelance &amp; contract talent on day-rate</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Verification of notice period</div><div class="jp-feat-note">Every applicant's notice period is independently verified</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">KYC verification required</div><div class="jp-feat-note">One-time employer verification before going live</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Applicant dashboard</div><div class="jp-feat-note">View, shortlist and manage applications</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Dedicated recruiter support</div><div class="jp-feat-note">A ZeroNoticePeriod recruiter assists your hiring</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Priority listing</div><div class="jp-feat-note">Your jobs appear at the top of search results</div></div></div>
        </div>
        <a href="{{ route('employer.login') }}" class="jp-plan-btn jp-btn-white" style="margin-top:18px">Start Hiring →</a>
    </div>

    <div class="jp-plan enterprise">
        <div class="jp-plan-tag">Enterprise</div>
        <div class="jp-plan-name">Pro</div>
        <div class="jp-plan-desc">For large teams with high-volume hiring. Minimum 250 job postings, everything unlimited, white-glove support.</div>
        <div class="jp-price-row">
            <div><span class="jp-price" style="font-size:24px;letter-spacing:-.3px">Custom</span></div>
            <div class="jp-price-per">Annual plan · minimum 250 job postings · + GST</div>
            <div class="jp-price-monthly">Billed annually — tailored to your team size</div>
        </div>
        <div class="jp-plan-divider"></div>
        <div class="jp-features">
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Minimum 250 job posts per year</div><div class="jp-feat-note">No cap — post as many as your plan allows</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Applications from immediate joiners &amp; serving notice</div><div class="jp-feat-note">Verified zero &amp; short notice period candidates</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Applications from contractors</div><div class="jp-feat-note">Find both permanent and contract talent</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Verification of notice period</div><div class="jp-feat-note">Every applicant's notice period is independently verified</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">AI fitment analysis</div><div class="jp-feat-note">Auto-rank every applicant instantly</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Dedicated account manager</div><div class="jp-feat-note">Named contact, not a support queue</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Priority listing + featured employer</div><div class="jp-feat-note">Your brand prominently displayed to candidates</div></div></div>
            <div class="jp-feat-row"><div class="jp-feat-check"><svg viewBox="0 0 12 12" fill="none"><polyline points="1.5,6 4.5,9 10.5,3"/></svg></div><div><div class="jp-feat-label">Custom reporting &amp; analytics</div><div class="jp-feat-note">Hiring funnel data and team-level insights</div></div></div>
        </div>
        <a href="{{ url('contact-us') }}" class="jp-plan-btn jp-btn-blue" style="margin-top:18px">Talk to Sales →</a>
    </div>
</div>

<div class="jp-trust">
    <div>
        <div class="jp-trust-ico"><svg width="18" height="18" fill="none" stroke="var(--jp-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <div class="jp-trust-title">No hidden fees</div>
        <div class="jp-trust-desc">What you see is what you pay. GST charged separately.</div>
    </div>
    <div>
        <div class="jp-trust-ico"><svg width="18" height="18" fill="none" stroke="var(--jp-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
        <div class="jp-trust-title">Go live in 30 minutes</div>
        <div class="jp-trust-desc">Jobs reviewed and published within 30 minutes of KYC approval.</div>
    </div>
    <div>
        <div class="jp-trust-ico"><svg width="18" height="18" fill="none" stroke="var(--jp-blue)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div class="jp-trust-title">Shortlisted in 72 hrs</div>
        <div class="jp-trust-desc">Most employers receive their first verified candidates within 72 hours of posting.</div>
    </div>
    <div>
        <div class="jp-trust-ico"><svg width="18" height="18" fill="none" stroke="var(--jp-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
        <div class="jp-trust-title">Verified candidates</div>
        <div class="jp-trust-desc">Every applicant is confirmed immediately available or serving notice.</div>
    </div>
</div>

<div class="jp-faq-section">
    <div class="jp-faq-head"><h2>Frequently asked questions</h2></div>
    <div class="jp-faq-grid">
        <button type="button" class="jp-faq-item" onclick="JpPricing.toggleFaq(this)">
            <div class="jp-faq-q">What counts as one job post? <div class="jp-faq-icon">+</div></div>
            <div class="jp-faq-a">One job post = one unique role at one location. If you're hiring 5 Python Developers in Bengaluru, that's one post. If you're hiring the same role in Mumbai too, that's two posts.</div>
        </button>
        <button type="button" class="jp-faq-item" onclick="JpPricing.toggleFaq(this)">
            <div class="jp-faq-q">How long is each job post active? <div class="jp-faq-icon">+</div></div>
            <div class="jp-faq-a">Quick Job posts are active for 30 days from when they go live. Flex posts are valid for 90 days from the date of purchase — each post stays active for 30 days once activated, so you can stagger them as needed. Pro plan posts are governed by your annual agreement.</div>
        </button>
        <button type="button" class="jp-faq-item" onclick="JpPricing.toggleFaq(this)">
            <div class="jp-faq-q">Why is KYC verification required? <div class="jp-faq-icon">+</div></div>
            <div class="jp-faq-a">KYC verification ensures only legitimate, verified employers can post jobs on ZeroNoticePeriod. This protects candidates from fraudulent listings. Verification takes less than 24 hours and is a one-time process. You can purchase a plan before verification and go live as soon as it's approved.</div>
        </button>
        <button type="button" class="jp-faq-item" onclick="JpPricing.toggleFaq(this)">
            <div class="jp-faq-q">Can I top up if I run out of posts? <div class="jp-faq-icon">+</div></div>
            <div class="jp-faq-a">Yes — you can purchase additional single Quick Job posts or another Flex pack at any time.</div>
        </button>
        <button type="button" class="jp-faq-item" onclick="JpPricing.toggleFaq(this)">
            <div class="jp-faq-q">What is AI fitment analysis? <div class="jp-faq-icon">+</div></div>
            <div class="jp-faq-a">AI fitment analysis automatically scores each applicant against your job description — rating their skills, experience and location match. It saves hours of manual screening and is available exclusively on the Pro plan.</div>
        </button>
        <button type="button" class="jp-faq-item" onclick="JpPricing.toggleFaq(this)">
            <div class="jp-faq-q">Is GST included in the prices shown? <div class="jp-faq-icon">+</div></div>
            <div class="jp-faq-a">No — prices shown are exclusive of GST. 18% GST is added at checkout. A GST invoice is generated automatically for all purchases and can be downloaded from your Billing &amp; Plan section.</div>
        </button>
        <button type="button" class="jp-faq-item" onclick="JpPricing.toggleFaq(this)">
            <div class="jp-faq-q">What payment methods do you accept? <div class="jp-faq-icon">+</div></div>
            <div class="jp-faq-a">We accept UPI (GPay, PhonePe, Paytm, BHIM), Credit/Debit Cards (Visa, Mastercard, RuPay), Net Banking (50+ banks), Mobile Wallets and EMI via Razorpay.</div>
        </button>
        <button type="button" class="jp-faq-item" onclick="JpPricing.toggleFaq(this)">
            <div class="jp-faq-q">What is the minimum for the Pro plan? <div class="jp-faq-icon">+</div></div>
            <div class="jp-faq-a">The Pro plan is an annual contract with a minimum of 250 job postings per year. Pricing is custom and tailored to your team size, hiring volume and feature requirements. Contact our sales team to get a quote.</div>
        </button>
    </div>
</div>

<div class="jp-cta-block">
    <h2>Ready to hire immediately?</h2>
    <p>Join a growing list of companies already hiring zero notice period talent.</p>
    <div class="jp-cta-btns">
        <a href="{{ route('employer.login') }}" class="jp-cta-btn-a">Post a Job — from ₹2,999</a>
        <a href="{{ url('contact-us') }}" class="jp-cta-btn-b">Talk to Sales</a>
    </div>
</div>

</div>
@endsection

@push('scripts')
<script>
(function () {
    window.JpPricing = {
        toggleFaq: function (el) {
            if (!el) return;
            var isOpen = el.classList.contains('open');
            var items = document.querySelectorAll('.znp-jp .jp-faq-item');
            for (var i = 0; i < items.length; i++) {
                items[i].classList.remove('open');
            }
            if (!isOpen) {
                el.classList.add('open');
            }
        }
    };
})();
</script>
@endpush
