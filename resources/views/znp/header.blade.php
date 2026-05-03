{{--
    ZNP Header — standalone blade include.
    Defines global CSS variables on :root so the whole ZNP home page
    (header + content + footer) can share the same design tokens.
    CSS is scoped to header.znp-header so it never conflicts with Bootstrap.
--}}
<style>
/* ── ZNP GLOBAL DESIGN TOKENS (accessible to all ZNP partials) ── */
:root {
    --blue:        #1a3faa;
    --blue-dark:   #152f85;
    --blue-mid:    #2350cc;
    --orange:      #f97316;
    --orange-dark: #ea6a00;
    --text:        #111827;
    --text-muted:  #6b7280;
    --text-light:  #9ca3af;
    --border:      #e5e7eb;
    --bg:          #f3f4f8;
    --white:       #ffffff;
}

/* ── ZNP HEADER ── */
header.znp-header {
    background: var(--white);
    border-bottom: 1px solid var(--border);
    padding: 0 24px;
    height: 60px;
    display: flex;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
    font-family: 'Inter', sans-serif;
    box-sizing: border-box;
}
header.znp-header * {
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}
.znp-header-inner {
    max-width: 1120px;
    margin: 0 auto;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
header.znp-header .znp-logo {
    display: flex;
    align-items: center;
    text-decoration: none;
}
header.znp-header .znp-logo-text {
    font-size: 18px;
    font-weight: 700;
    color: var(--text);
    line-height: 1;
    white-space: nowrap;
}
header.znp-header .znp-logo-text .logo-blue   { color: var(--blue); }
header.znp-header .znp-logo-text .logo-orange { color: var(--orange); }
header.znp-header .znp-nav-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}
header.znp-header .znp-btn-jobs {
    background: var(--white);
    border: 1px solid #b8c9ee;
    color: var(--blue);
    padding: 9px 22px;
    border-radius: 7px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
    transition: all 0.15s;
    text-decoration: none;
    display: inline-block;
    letter-spacing: 0.01em;
    line-height: 1;
}
header.znp-header .znp-btn-jobs:hover {
    background: #eef2ff;
    box-shadow: 0 2px 8px rgba(26,63,170,0.12);
    color: var(--blue);
    text-decoration: none;
}
header.znp-header .znp-btn-post {
    background: var(--orange);
    border: none;
    color: #fff;
    padding: 9px 20px;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
    transition: all 0.15s;
    text-decoration: none;
    display: inline-block;
    line-height: 1;
}
header.znp-header .znp-btn-post:hover {
    background: var(--orange-dark);
    color: #fff;
    text-decoration: none;
}
@media (max-width: 600px) {
    header.znp-header {
        padding: 0 14px;
        height: 52px;
    }
    .znp-header-inner { gap: 8px; }
    header.znp-header .znp-logo { flex: 1 1 0; min-width: 0; overflow: hidden; }
    header.znp-header .znp-logo-text { font-size: 15px; }
    header.znp-header .znp-nav-actions { gap: 6px; flex-shrink: 0; }
    header.znp-header .znp-btn-jobs {
        padding: 8px 14px;
        font-size: 12.5px;
        white-space: nowrap;
        letter-spacing: 0;
        line-height: 1;
    }
    header.znp-header .znp-btn-post {
        padding: 8px 14px;
        font-size: 12.5px;
        white-space: nowrap;
        line-height: 1;
    }
}
</style>

<header class="znp-header">
    <div class="znp-header-inner">
        <a class="znp-logo" href="{{ url('/') }}">
            <span class="znp-logo-text"><span class="logo-blue">Zero</span><span class="logo-orange">Notice</span><span class="logo-blue">Period</span></span>
        </a>
        <nav></nav>
        <div class="znp-nav-actions">
            <a class="znp-btn-jobs" href="{{ url('/jobseeker-auth') }}" target="_blank" rel="noopener noreferrer">Find Jobs</a>
            <a class="znp-btn-post" href="{{ url('/employer-login') }}" target="_blank" rel="noopener noreferrer">Post Jobs</a>
        </div>
    </div>
</header>
