@extends('layouts.znp')

@section('page_title', 'E2E Test Runner | ZNP Dev')

@push('styles')
<style>
/* ────────────────────────────────────────────────────────────────────
   Scoped to .znp-e2e so we don't bleed into any other page styles.
   Design language matches the rest of the new ZNP UI (Inter font,
   rounded cards, orange/teal accents).
   ──────────────────────────────────────────────────────────────────── */
.znp-e2e { font-family: 'Inter', system-ui, sans-serif; color:#0f172a; background:#f8fafc; min-height:100vh; padding:32px 24px 96px; }
.znp-e2e .wrap { max-width: 1240px; margin: 0 auto; }
.znp-e2e .hd { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom: 16px; }
.znp-e2e .hd h1 { font-size: 26px; font-weight: 700; margin:0 0 4px; }
.znp-e2e .hd p  { color:#475569; margin:0; font-size:14px; }
.znp-e2e .pill  { display:inline-flex; align-items:center; gap:6px; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:600; background:#e2e8f0; color:#334155; }
.znp-e2e .pill.ok  { background:#dcfce7; color:#166534; }
.znp-e2e .pill.bad { background:#fee2e2; color:#991b1b; }
.znp-e2e .pill.warn{ background:#fef3c7; color:#92400e; }

.znp-e2e .env-bar { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:14px 18px; margin-bottom: 22px; display:flex; flex-wrap:wrap; gap:14px 24px; align-items:center; font-size:13px; }
.znp-e2e .env-bar code { background:#f1f5f9; padding:2px 6px; border-radius:4px; font-size:12px; color:#334155; }

.znp-e2e .toolbar { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:14px 18px; margin-bottom: 22px; display:flex; flex-wrap:wrap; gap:10px; align-items:center; justify-content:space-between; }
.znp-e2e .toolbar .left { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
.znp-e2e .toolbar .right { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
.znp-e2e .toolbar input[type="search"] { width:280px; padding:9px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:13px; }
.znp-e2e .toolbar .meta { color:#64748b; font-size:12px; }

.znp-e2e .btn { appearance:none; border:0; border-radius:8px; padding:10px 16px; font-size:13px; font-weight:600; cursor:pointer; line-height:1; transition: background 0.15s, transform 0.05s; }
.znp-e2e .btn:active { transform: translateY(1px); }
.znp-e2e .btn-primary { background:#f97316; color:#fff; }
.znp-e2e .btn-primary:hover { background:#ea580c; }
.znp-e2e .btn-ghost   { background:#f1f5f9; color:#0f172a; }
.znp-e2e .btn-ghost:hover { background:#e2e8f0; }
.znp-e2e .btn-dark    { background:#0f172a; color:#fff; }
.znp-e2e .btn-dark:hover { background:#1e293b; }
.znp-e2e .btn-danger  { background:#dc2626; color:#fff; }
.znp-e2e .btn-danger:hover { background:#b91c1c; }
.znp-e2e .btn[disabled] { opacity:0.55; cursor:not-allowed; }
.znp-e2e .btn-sm { padding:6px 10px; font-size:12px; }

.znp-e2e .grid { display:grid; grid-template-columns: 1.4fr 1fr; gap: 22px; align-items:flex-start; }
@media (max-width: 1024px) { .znp-e2e .grid { grid-template-columns: 1fr; } }

.znp-e2e .group { background:#fff; border:1px solid #e2e8f0; border-radius:14px; margin-bottom: 18px; overflow:hidden; }
.znp-e2e .group .group-hd { display:flex; align-items:center; justify-content:space-between; padding:12px 18px; background:#f8fafc; border-bottom:1px solid #e2e8f0; }
.znp-e2e .group .group-hd h2 { margin:0; font-size:14px; font-weight:700; color:#0f172a; letter-spacing:0.02em; text-transform:uppercase; }
.znp-e2e .group .group-hd .count { font-size:12px; color:#64748b; }

.znp-e2e .test { display:flex; gap:14px; padding:14px 18px; border-top:1px solid #f1f5f9; align-items:flex-start; }
.znp-e2e .test:first-child { border-top:0; }
.znp-e2e .test .check { padding-top:3px; }
.znp-e2e .test .check input { width:16px; height:16px; cursor:pointer; }
.znp-e2e .test .body { flex:1; min-width:0; }
.znp-e2e .test .title-row { display:flex; gap:10px; align-items:center; margin-bottom:4px; flex-wrap:wrap; }
.znp-e2e .test .id-tag { font-family: 'JetBrains Mono', ui-monospace, monospace; font-size:11px; font-weight:700; padding:3px 7px; border-radius:5px; background:#eff6ff; color:#1d4ed8; letter-spacing:0.04em; }
.znp-e2e .test .title  { font-weight:600; font-size:14px; color:#0f172a; }
.znp-e2e .test .file   { font-size:11px; color:#64748b; font-family: 'JetBrains Mono', ui-monospace, monospace; }
.znp-e2e .test .what   { color:#475569; font-size:13px; line-height:1.5; margin: 6px 0 8px; }
.znp-e2e .test .actions{ display:flex; gap:8px; align-items:center; }
.znp-e2e .test .status { margin-left:auto; }

/* status pill colors */
.znp-e2e .s-idle  { background:#e2e8f0; color:#475569; }
.znp-e2e .s-run   { background:#fef3c7; color:#92400e; animation: pulse 1.2s ease-in-out infinite; }
.znp-e2e .s-pass  { background:#dcfce7; color:#166534; }
.znp-e2e .s-fail  { background:#fee2e2; color:#991b1b; }
@keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:0.55;} }

/* Right column = live output panel + run summary */
.znp-e2e .side { position: sticky; top: 16px; }
.znp-e2e .panel { background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:0; overflow:hidden; }
.znp-e2e .panel .panel-hd { display:flex; align-items:center; justify-content:space-between; padding:12px 16px; background:#f8fafc; border-bottom:1px solid #e2e8f0; }
.znp-e2e .panel .panel-hd h3 { margin:0; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#0f172a; }

.znp-e2e .summary { padding: 14px 16px; display:flex; gap:10px; flex-wrap:wrap; align-items:center; font-size:13px; color:#475569; border-bottom:1px solid #f1f5f9; }
.znp-e2e .summary .kv { background:#f1f5f9; padding:4px 10px; border-radius:6px; font-size:12px; color:#334155; }
.znp-e2e .summary .kv b { color:#0f172a; font-weight:700; }

.znp-e2e pre.console { margin:0; padding: 14px 16px; background:#0b1220; color:#e2e8f0; font-family: 'JetBrains Mono', ui-monospace, monospace; font-size:12px; line-height:1.55; height: 540px; overflow:auto; border-radius: 0; white-space: pre-wrap; word-break: break-word; }
.znp-e2e pre.console .ln-pass { color:#86efac; }
.znp-e2e pre.console .ln-fail { color:#fca5a5; }
.znp-e2e pre.console .ln-info { color:#93c5fd; }
.znp-e2e pre.console .ln-cmd  { color:#fbbf24; }

.znp-e2e .empty-hint { padding: 26px; text-align:center; color:#64748b; font-size:13px; }
</style>
@endpush

@section('content')
<div class="znp-e2e">
    <div class="wrap">

        {{-- ── Header ─────────────────────────────────────────────────────── --}}
        <div class="hd">
            <div>
                <h1>End-to-End Test Runner</h1>
                <p>Every Playwright scenario that protects the Post-a-Job / Edit-a-Job / Wizard flow. Pick what you want and hit Run — output streams live below.</p>
            </div>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <span class="pill {{ app()->environment('production') ? 'bad' : 'ok' }}">env: {{ app()->environment() }}</span>
                <span class="pill">{{ count($catalog) }} tests</span>
            </div>
        </div>

        {{-- ── Environment summary ───────────────────────────────────────── --}}
        <div class="env-bar">
            <div><strong>e2e dir:</strong> <code>{{ $envOk['e2e_dir'] }}</code></div>
            <div>
                <strong>.env file:</strong>
                <span class="pill {{ $envOk['e2e_env_exists'] ? 'ok' : 'warn' }}">
                    {{ $envOk['e2e_env_exists'] ? 'found' : 'missing (will use defaults)' }}
                </span>
            </div>
            <div>
                <strong>@playwright/test:</strong>
                <span class="pill {{ $envOk['node_modules_ok'] ? 'ok' : 'bad' }}">
                    {{ $envOk['node_modules_ok'] ? 'installed' : 'run npm i in tests/e2e' }}
                </span>
            </div>
        </div>

        {{-- ── Toolbar ───────────────────────────────────────────────────── --}}
        <div class="toolbar">
            <div class="left">
                <input type="search" id="filter" placeholder="Filter by title, ID, file…" autocomplete="off">
                <button type="button" class="btn btn-sm btn-ghost" id="selectAll">Select all</button>
                <button type="button" class="btn btn-sm btn-ghost" id="selectNone">Clear</button>
                <span class="meta" id="selCount">0 selected</span>
            </div>
            <div class="right">
                <a class="btn btn-sm btn-ghost" href="{{ url('dev/e2e-runner/report/index.html') }}" target="_blank" rel="noopener">Open last HTML report</a>
                <button type="button" class="btn btn-ghost" id="runSelected" disabled>Run selected</button>
                <button type="button" class="btn btn-primary" id="runAll">Run all tests</button>
                <button type="button" class="btn btn-danger" id="cancelBtn" style="display:none;">Cancel</button>
            </div>
        </div>

        {{-- ── Two-column layout: catalog + live console ──────────────────── --}}
        <div class="grid">

            <div class="left-col">
                @foreach ($groups as $groupName => $rows)
                    <div class="group" data-group="{{ $groupName }}">
                        <div class="group-hd">
                            <h2>{{ $groupName }}</h2>
                            <span class="count">{{ count($rows) }} scenarios</span>
                        </div>
                        @foreach ($rows as $t)
                            <div class="test" data-id="{{ $t['id'] }}" data-search="{{ strtolower($t['id'].' '.$t['title'].' '.$t['file']) }}">
                                <div class="check">
                                    <input type="checkbox" class="t-check" value="{{ $t['id'] }}">
                                </div>
                                <div class="body">
                                    <div class="title-row">
                                        <span class="id-tag">{{ $t['id'] }}</span>
                                        <span class="title">{{ $t['title'] }}</span>
                                        <span class="status pill s-idle" data-status>idle</span>
                                    </div>
                                    <div class="file">{{ $t['file'] }}</div>
                                    <div class="what">{{ $t['what'] }}</div>
                                    <div class="actions">
                                        <button type="button" class="btn btn-sm btn-dark t-run" data-id="{{ $t['id'] }}">Run just this</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="side">
                <div class="panel">
                    <div class="panel-hd">
                        <h3>Live output</h3>
                        <span class="pill s-idle" id="runState">idle</span>
                    </div>
                    <div class="summary" id="runSummary">
                        <span class="kv">Last run: <b id="kvLast">—</b></span>
                        <span class="kv">Status: <b id="kvStatus">—</b></span>
                        <span class="kv">Tests: <b id="kvCount">—</b></span>
                        <span class="kv">Duration: <b id="kvDur">—</b></span>
                    </div>
                    <pre class="console" id="console">No run started yet. Pick one or more tests and click Run.

Tip:
  • "Run all tests"        → executes the whole suite
  • "Run selected"         → runs only the tests with a tick
  • "Run just this"        → runs a single test inline

The Playwright HTML report (index.html with screenshots + traces) will open automatically in a new tab when a run finishes.</pre>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    /* ── Endpoints (built server-side so we don't hard-code prefixes) ── */
    var URLS = {
        run:    '{{ url('dev/e2e-runner/run') }}',
        log:    '{{ url('dev/e2e-runner/log') }}',
        status: '{{ url('dev/e2e-runner/status') }}',
        cancel: '{{ url('dev/e2e-runner/cancel') }}',
    };
    var CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    /* ── Element refs ── */
    var els = {
        filter:      document.getElementById('filter'),
        selectAll:   document.getElementById('selectAll'),
        selectNone:  document.getElementById('selectNone'),
        selCount:    document.getElementById('selCount'),
        runSelected: document.getElementById('runSelected'),
        runAll:      document.getElementById('runAll'),
        cancelBtn:   document.getElementById('cancelBtn'),
        console:     document.getElementById('console'),
        runState:    document.getElementById('runState'),
        kvLast:      document.getElementById('kvLast'),
        kvStatus:    document.getElementById('kvStatus'),
        kvCount:     document.getElementById('kvCount'),
        kvDur:       document.getElementById('kvDur'),
    };

    var currentRunId = null;
    var pollTimer    = null;
    var startTs      = null;
    /** map of testId → status pill element so we can flip each tile as we
        parse the playwright output lines */
    var pillByName   = {};

    @php
        /* Trim down to the few fields the JS needs, encoded server-side
           because Blade can't parse a closure inside an @json directive. */
        $catalogJs = [];
        foreach ($catalog as $t) {
            $catalogJs[] = ['id' => $t['id'], 'title' => $t['title'], 'pattern' => $t['pattern']];
        }
    @endphp
    /* ── Catalog (mirrors the PHP side; we only need id + pattern here) ── */
    var CATALOG = @json($catalogJs);

    /* Build a name→pill index. We use the test "title" (full Playwright
       test name) to look up matches inside the live log. */
    document.querySelectorAll('.test').forEach(function (el) {
        var id = el.getAttribute('data-id');
        var pill = el.querySelector('[data-status]');
        pillByName[id] = pill;
    });

    /* ──────────────────────── Filter / selection ──────────────────────── */

    els.filter.addEventListener('input', function () {
        var q = els.filter.value.trim().toLowerCase();
        document.querySelectorAll('.test').forEach(function (el) {
            var hay = el.getAttribute('data-search');
            el.style.display = (!q || hay.indexOf(q) !== -1) ? '' : 'none';
        });
        /* Hide whole group sections that have no visible tests left */
        document.querySelectorAll('.group').forEach(function (g) {
            var anyVisible = Array.from(g.querySelectorAll('.test')).some(function (el) { return el.style.display !== 'none'; });
            g.style.display = anyVisible ? '' : 'none';
        });
    });

    function refreshSelCount () {
        var n = document.querySelectorAll('.t-check:checked').length;
        els.selCount.textContent = n + ' selected';
        els.runSelected.disabled = (n === 0) || currentRunId !== null;
    }
    document.addEventListener('change', function (e) {
        if (e.target.classList && e.target.classList.contains('t-check')) refreshSelCount();
    });
    els.selectAll.addEventListener('click', function () {
        document.querySelectorAll('.test').forEach(function (el) {
            if (el.style.display !== 'none') el.querySelector('.t-check').checked = true;
        });
        refreshSelCount();
    });
    els.selectNone.addEventListener('click', function () {
        document.querySelectorAll('.t-check').forEach(function (c) { c.checked = false; });
        refreshSelCount();
    });

    /* ──────────────────────── Run controls ──────────────────────── */

    els.runAll.addEventListener('click', function () { startRun('all', []); });

    els.runSelected.addEventListener('click', function () {
        var ids = Array.from(document.querySelectorAll('.t-check:checked')).map(function (c) { return c.value; });
        if (!ids.length) return;
        startRun('selected', ids);
    });

    document.querySelectorAll('.t-run').forEach(function (btn) {
        btn.addEventListener('click', function () { startRun('selected', [btn.getAttribute('data-id')]); });
    });

    els.cancelBtn.addEventListener('click', function () {
        if (!currentRunId) return;
        fetch(URLS.cancel + '/' + currentRunId, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        }).catch(function () {});
    });

    function startRun (scope, ids) {
        if (currentRunId) return;

        /* Reset state */
        resetAllPills(ids.length ? ids : null);
        setUIState(true);
        appendLine('▶  Starting ' + (scope === 'all' ? 'ALL tests' : ids.length + ' selected test(s))…'), 'cmd');
        startTs = Date.now();

        var fd = new FormData();
        fd.append('_token', CSRF);
        fd.append('scope', scope);
        (ids || []).forEach(function (id) { fd.append('ids[]', id); });

        fetch(URLS.run, { method: 'POST', body: fd, headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }})
            .then(function (r) { return r.json().then(function (j) { return [r.ok, j]; }); })
            .then(function (pair) {
                var ok = pair[0], j = pair[1];
                if (!ok) {
                    appendLine('✗ Failed to start: ' + (j.error || JSON.stringify(j)), 'fail');
                    setUIState(false);
                    return;
                }
                currentRunId = j.run_id;
                els.kvCount.textContent = j.count;
                appendLine('   command: ' + j.command, 'info');
                appendLine('   run id : ' + j.run_id, 'info');
                appendLine('', 'info');
                startPolling();
            })
            .catch(function (err) {
                appendLine('✗ ' + err, 'fail');
                setUIState(false);
            });
    }

    /* ──────────────────────── Polling ──────────────────────── */

    var lastLogSize = 0;
    function startPolling () {
        lastLogSize = 0;
        pollTimer = setInterval(tick, 1200);
    }
    function stopPolling () {
        if (pollTimer) { clearInterval(pollTimer); pollTimer = null; }
    }

    function tick () {
        if (!currentRunId) return;
        Promise.all([
            fetch(URLS.log + '/' + currentRunId).then(function (r) { return r.json(); }),
            fetch(URLS.status + '/' + currentRunId).then(function (r) { return r.json(); }),
        ]).then(function (pair) {
            var logRes = pair[0], st = pair[1];

            /* Append only the new bytes — avoids the console redrawing
               every tick (and losing scroll position). */
            if (logRes.log && logRes.log.length > lastLogSize) {
                var newPart = logRes.log.substring(lastLogSize);
                lastLogSize = logRes.log.length;
                appendChunk(newPart);
                parseAndTagTests(newPart);
            }

            els.kvDur.textContent = ((Date.now() - startTs) / 1000).toFixed(1) + 's';

            if (st && st.status && st.status !== 'running') {
                stopPolling();
                finishRun(st);
            }
        }).catch(function () { /* keep polling on transient errors */ });
    }

    function finishRun (st) {
        var ok = st.status === 'passed';
        els.runState.textContent = st.status;
        els.runState.className = 'pill ' + (ok ? 's-pass' : (st.status === 'cancelled' ? 's-idle' : 's-fail'));
        els.kvStatus.textContent = st.status + (st.exit_code !== null ? ' (exit ' + st.exit_code + ')' : '');
        els.kvLast.textContent = (new Date()).toLocaleTimeString();
        setUIState(false);
        currentRunId = null;

        appendLine('', 'info');
        appendLine(ok ? '✓ Suite finished — all good.' : '✗ Suite finished with failures. See the HTML report for details.', ok ? 'pass' : 'fail');

        /* Auto-open Playwright HTML report on completion. The report
           lives under tests/e2e/playwright-report and is served back to
           the browser by the controller's report() method. */
        if (st.status !== 'cancelled') {
            try {
                window.open('{{ url('dev/e2e-runner/report/index.html') }}', '_blank');
            } catch (e) {}
        }
    }

    /* ──────────────────────── Console helpers ──────────────────────── */

    function appendChunk (chunk) {
        /* Split into lines so we can color each individually. */
        var lines = chunk.split(/\r?\n/);
        lines.forEach(function (l, i) {
            /* Keep blank lines too (helps readability) */
            appendLine(l, classifyLine(l), i === lines.length - 1 && !chunk.endsWith('\n'));
        });
    }

    function appendLine (text, klass, noNewline) {
        var span = document.createElement('span');
        if (klass) span.className = 'ln-' + klass;
        span.textContent = text + (noNewline ? '' : '\n');
        els.console.appendChild(span);
        els.console.scrollTop = els.console.scrollHeight;
    }

    function classifyLine (l) {
        if (!l) return '';
        if (/^\s*[✘✗×]\s/.test(l) || /\bfailed\b/i.test(l) || /^\s*Error:/.test(l)) return 'fail';
        if (/^\s*[✔✓√]\s/.test(l) || /\bpassed\b/i.test(l)) return 'pass';
        if (/^\s*Running\s/.test(l) || /^\s*\[\d+\/\d+\]/.test(l)) return 'info';
        if (/\bnpx playwright\b/.test(l) || /^▶/.test(l) || /^   command:/.test(l) || /^   run id :/.test(l)) return 'cmd';
        return '';
    }

    /**
     * Walks a log chunk looking for hints that a specific test started or
     * finished, then updates the matching pill on the catalog list.
     *
     * Playwright list reporter prints lines like:
     *   "  ✓ 1 [chromium] › post-job.spec.ts:32 › Post a Job creation … › A — Direct + WFO … (3.2s)"
     *   "  ✘ 5 [chromium] › edit-job.spec.ts:29 › Edit-a-job round-trip   › EDIT-1 — …"
     */
    function parseAndTagTests (chunk) {
        var lines = chunk.split(/\r?\n/);
        lines.forEach(function (l) {
            CATALOG.forEach(function (t) {
                /* Only react if the test ID prefix is present (cheap filter) */
                if (l.indexOf(t.pattern) === -1) return;
                var pill = pillByName[t.id];
                if (!pill) return;
                if (/[✘✗×]/.test(l) || /\bfailed\b/i.test(l)) {
                    pill.textContent = 'failed';
                    pill.className = 'status pill s-fail';
                } else if (/[✔✓√]/.test(l) || /\bpassed\b/i.test(l) || /\bok\b/i.test(l)) {
                    pill.textContent = 'passed';
                    pill.className = 'status pill s-pass';
                } else {
                    pill.textContent = 'running';
                    pill.className = 'status pill s-run';
                }
            });
        });
    }

    function resetAllPills (onlyIds) {
        Object.keys(pillByName).forEach(function (id) {
            if (onlyIds && onlyIds.indexOf(id) === -1) return;
            var p = pillByName[id];
            p.textContent = 'queued';
            p.className = 'status pill s-run';
        });
        els.console.textContent = '';
        els.runState.textContent = 'running';
        els.runState.className = 'pill s-run';
        els.kvStatus.textContent = 'running';
        els.kvDur.textContent = '0.0s';
    }

    function setUIState (running) {
        els.runAll.disabled = running;
        els.runSelected.disabled = running || document.querySelectorAll('.t-check:checked').length === 0;
        els.cancelBtn.style.display = running ? '' : 'none';
        document.querySelectorAll('.t-run').forEach(function (b) { b.disabled = running; });
    }

    refreshSelCount();
})();
</script>
@endpush
