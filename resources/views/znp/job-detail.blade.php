@extends('layouts.znp')

@push('styles')
<style>
/* ─── scope & font reset ─────────────────────────────── */
.znp-job-detail,
.znp-job-detail * {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}
.znp-job-detail { background: var(--bg); color: var(--text); font-size: 13px; padding-bottom: 56px; }
.znp-job-detail a              { color: inherit; text-decoration: none; }
.znp-job-detail h1, .znp-job-detail h2,
.znp-job-detail h3, .znp-job-detail h4 { margin: 0; font-weight: inherit; }
.znp-job-detail p              { margin: 0; }
.znp-job-detail button         { font-family: inherit !important; }

/* ─── page wrapper ───────────────────────────────────── */
.znp-job-detail .jd-pg {
    max-width: 980px;
    margin: 0px auto 0;
    padding: 22px 18px;
}

/* ─── job header ─────────────────────────────────────── */
.znp-job-detail .jh {
    background: var(--white);
    border: 0.5px solid #d1dae8;
    border-top: 3px solid #93c5fd; /* blue top stroke to follow curved corners */
    border-radius: 12px;
    overflow: hidden;
}
.znp-job-detail .jh-bar {
    display: none; /* top stroke is now provided by the .jh border-top */
}
.znp-job-detail .jh-body {
    padding: 22px 26px 18px;
}
.znp-job-detail .jh-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 14px;
}
.znp-job-detail .jtitle {
    font-size: 19px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 8px;
    letter-spacing: -.2px;
}
.znp-job-detail .pbadge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eff6ff;
    border: 0.5px solid #bfdbfe;
    border-radius: 20px;
    padding: 4px 13px;
    font-size: 11px;
    color: #1e40af;
    font-weight: 600;
    max-width: 100%;
}
.znp-job-detail .pdot {
    width: 6px;
    height: 6px;
    background: #3b82f6;
    border-radius: 50%;
    display: inline-block;
}
.znp-job-detail .znpbadge {
    width: 56px;
    height: 56px;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 800;
    color: #1e40af;
    text-align: center;
    line-height: 1.2;
    flex-shrink: 0;
    overflow: hidden;
    padding: 4px;
}
.znp-job-detail .znpbadge img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

/* ─── summary pills ──────────────────────────────────── */
.znp-job-detail .sum-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 7px;
    margin: 0 0 5px;
}
.znp-job-detail .sg-pill {
    display: inline-flex;
    align-items: center;
    font-size: 11.5px;
    font-weight: 500;
    color: #334155;
    background: #f1f5f9;
    border: 0.5px solid #cbd5e1;
    border-radius: 20px;
    padding: 4px 12px;
    white-space: nowrap;
}

/* ─── cert badges ────────────────────────────────────── */
.znp-job-detail .cert-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    padding: 5px 0;
    border-top: 0.5px solid #e8eef5;
    border-bottom: 0.5px solid #e8eef5;
    margin-bottom: 12px;
}
.znp-job-detail .ctag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
}
.znp-job-detail .ctag svg {
    width: 12px;
    height: 12px;
    fill: none;
    flex-shrink: 0;
}
.znp-job-detail .cg { border: 1.5px solid #0ea5e9; color: #0369a1; background: #f0f9ff; }
.znp-job-detail .ce { border: 1.5px solid #14b8a6; color: #0f766e; background: #f0fdfa; }
.znp-job-detail .cs { border: 1px solid #94a3b8;   color: #475569; background: #f8fafc; }
.znp-job-detail .cd { border: 1.5px solid #a855f7; color: #7e22ce; background: #faf5ff; }
.znp-job-detail .cw { border: 1.5px solid #ec4899; color: #be185d; background: #fdf2f8; }

/* ─── actions row ────────────────────────────────────── */
.znp-job-detail .jact {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.znp-job-detail .jinfo {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 500;
}
.znp-job-detail .abtns {
    display: flex;
    gap: 10px;
}
.znp-job-detail .bsave {
    border: 1px solid #bfdbfe;
    background: #eff6ff;
    color: #1e40af;
    padding: 7px 18px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}
.znp-job-detail .bapp {
    background: var(--orange);
    color: var(--white);
    border: none;
    padding: 7px 20px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}
.znp-job-detail .bapp:hover { background: var(--orange-dark); color: var(--white); text-decoration: none; }
.znp-job-detail .bsave:hover { background: #dbeafe; color: #1e3a8a; text-decoration: none; }

/* ─── grid layout ────────────────────────────────────── */
.znp-job-detail .jd-grid {
    display: grid;
    grid-template-columns: 1fr 284px;
    gap: 16px;
    align-items: stretch;
    margin-top: 16px;
}
.znp-job-detail .lc,
.znp-job-detail .rc {
    display: flex;
    flex-direction: column;
    gap: 14px;
    min-height: 100%;
}
.znp-job-detail .rc .card.rc-grow {
    flex: 1;
    display: flex;
    flex-direction: column;
}
.znp-job-detail .rc .card.rc-grow .bb {
    margin-top: auto;
}

/* ─── cards ──────────────────────────────────────────── */
.znp-job-detail .card {
    background: var(--white);
    border: 0.5px solid #d1dae8;
    border-radius: 12px;
    padding: 20px 24px;
}
.znp-job-detail .ct {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 13px;
}

/* ─── highlights ─────────────────────────────────────── */
.znp-job-detail .hl {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 0;
    margin: 0;
}
.znp-job-detail .hl li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 12.5px;
    color: #334155;
    line-height: 1.6;
    font-weight: 400;
}
.znp-job-detail .hd {
    width: 6px;
    height: 6px;
    min-width: 6px;
    background: var(--orange);
    border-radius: 50%;
    margin-top: 5px;
}

/* ─── key skills ─────────────────────────────────────── */
.znp-job-detail .sw {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.znp-job-detail .sk {
    font-size: 11.5px;
    padding: 4px 12px;
    border-radius: 20px;
    border: 0.5px solid #bfdbfe;
    background: #eff6ff;
    color: #1e40af;
    font-weight: 500;
}
.znp-job-detail .sk.p {
    border-color: var(--blue);
    background: #dbeafe;
}
.znp-job-detail .sknote {
    font-size: 10.5px;
    color: #94a3b8;
    margin-top: 10px;
    font-weight: 500;
    margin-bottom: 0;
}

/* ─── job description ────────────────────────────────── */
.znp-job-detail .db {
    font-size: 12.5px;
    color: #334155;
    line-height: 1.75;
    font-weight: 400;
}
.znp-job-detail .db p { margin-bottom: 8px; }
.znp-job-detail .db ul, .znp-job-detail .db ol { padding-left: 20px; margin-bottom: 10px; }
.znp-job-detail .db li { margin-bottom: 4px; }
.znp-job-detail .db h3,
.znp-job-detail .db h4,
.znp-job-detail .db strong { font-size: 13px; font-weight: 700; color: #0f172a; }
.znp-job-detail .desc-inner {
    max-height: 260px;
    overflow: hidden;
    position: relative;
    transition: max-height 0.3s ease;
}
.znp-job-detail .desc-inner.expanded { max-height: none; }
.znp-job-detail .desc-fade {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(transparent, var(--white));
    pointer-events: none;
    transition: opacity 0.2s;
}
.znp-job-detail .desc-inner.expanded .desc-fade { opacity: 0; }
.znp-job-detail .rm {
    color: var(--blue);
    font-size: 12px;
    cursor: pointer;
    font-weight: 500;
    background: none;
    border: none;
    outline: none;
    padding: 0;
    margin-top: 8px;
    display: inline-block;
}

/* ─── share row ──────────────────────────────────────── */
.znp-job-detail .shr {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}
.znp-job-detail .sob {
    width: 26px;
    height: 26px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 700;
    cursor: pointer;
    color: var(--white);
    border: none;
    text-decoration: none;
}
.znp-job-detail .sfb { background: #1877f2; }
.znp-job-detail .sx  { background: #0f172a; }
.znp-job-detail .sli { background: #0a66c2; }
.znp-job-detail .sob:hover { opacity: 0.85; color: var(--white); text-decoration: none; }
.znp-job-detail .rpt {
    font-size: 11px;
    color: #94a3b8;
    cursor: pointer;
    background: none;
    border: none;
    text-decoration: underline;
    font-weight: 500;
}

/* ─── about company ──────────────────────────────────── */
.znp-job-detail .crow {
    display: flex;
    align-items: center;
    gap: 14px;
}
.znp-job-detail .clogo {
    width: 44px;
    height: 44px;
    background: #f1f5f9;
    border-radius: 8px;
    border: 0.5px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #475569;
    flex-shrink: 0;
    overflow: hidden;
}
.znp-job-detail .clogo img { width: 44px; height: 44px; object-fit: contain; }
.znp-job-detail .cn {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 2px;
}
.znp-job-detail .csub {
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
}
.znp-job-detail .cdesc {
    font-size: 12px;
    color: #475569;
    margin-top: 13px;
    line-height: 1.7;
    font-weight: 400;
    margin-bottom: 0;
}

/* ─── sidebar: interview mode ────────────────────────── */
.znp-job-detail .itags {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
}
.znp-job-detail .itag {
    font-size: 11px;
    padding: 4px 11px;
    background: #f8fafc;
    border: 0.5px solid #cbd5e1;
    border-radius: 20px;
    color: #334155;
    font-weight: 500;
}

/* ─── sidebar: similar jobs ──────────────────────────── */
.znp-job-detail .sj {
    padding: 11px 0;
    border-bottom: 0.5px solid #f1f5f9;
}
.znp-job-detail .sj:last-of-type { border-bottom: none; }
.znp-job-detail .sjt {
    font-size: 12.5px;
    font-weight: 500;
    color: var(--blue);
    margin-bottom: 2px;
    cursor: pointer;
}
.znp-job-detail .sjt:hover { text-decoration: underline; }
.znp-job-detail .sjm {
    font-size: 11px;
    color: #64748b;
    font-weight: 400;
    margin-bottom: 4px;
}
.znp-job-detail .sjtags {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
}
.znp-job-detail .sjt2 {
    font-size: 10.5px;
    padding: 2px 9px;
    background: #f8fafc;
    border: 0.5px solid #e2e8f0;
    border-radius: 10px;
    color: #475569;
    font-weight: 500;
}
.znp-job-detail .bb {
    width: 100%;
    margin-top: 12px;
    padding: 8px;
    background: #fff7ed;
    border: 0.5px solid #fed7aa;
    border-radius: 7px;
    color: var(--orange);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-align: center;
    display: block;
    text-decoration: none;
}
.znp-job-detail .bb:hover { background: #ffedd5; text-decoration: none; color: var(--orange); }

/* ─── apply modal styles ─────────────────────────────── */
.znp-job-detail .bapp-applied {
    background: #16a34a;
    color: var(--white);
    border: none;
    padding: 7px 20px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    cursor: default;
}

/* ─── walkin info ────────────────────────────────────── */
.znp-job-detail .walkin-box {
    background: #f0f9ff;
    border: 0.5px solid #bae6fd;
    border-radius: 8px;
    padding: 12px 16px;
    margin-top: 10px;
    font-size: 12px;
    color: #0369a1;
    line-height: 1.8;
}
.znp-job-detail .walkin-box strong { font-weight: 700; }

/* ─── right-rail key-value list (Job snapshot) ───────── */
.znp-job-detail .rail-card { padding: 16px 18px; }
.znp-job-detail .rail-card .ct { font-size: 13px; margin-bottom: 11px; }
.znp-job-detail .kv-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
}
.znp-job-detail .kv-list li {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    gap: 10px;
    padding: 7px 0;
    border-bottom: 0.5px dashed #e2e8f0;
    font-size: 12px;
    line-height: 1.45;
}
.znp-job-detail .kv-list li:last-child { border-bottom: none; }
.znp-job-detail .kv-list li.kv-stack {
    flex-direction: column;
    align-items: flex-start;
    gap: 2px;
}
.znp-job-detail .kv-lbl {
    color: #64748b;
    font-weight: 500;
    flex-shrink: 0;
}
.znp-job-detail .kv-val {
    color: #0f172a;
    font-weight: 600;
    text-align: right;
    word-break: break-word;
}
.znp-job-detail .kv-stack .kv-val { text-align: left; font-weight: 700; }
.znp-job-detail .kv-sub {
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
}

/* ─── snapshot / contract grids (left column — Contract details) ─ */
.znp-job-detail .snap-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px 22px;
}
.znp-job-detail .snap-item { display: flex; flex-direction: column; gap: 3px; min-width: 0; }
.znp-job-detail .snap-lbl {
    font-size: 10.5px;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.znp-job-detail .snap-val {
    font-size: 12.5px;
    font-weight: 600;
    color: #0f172a;
    line-height: 1.45;
    word-break: break-word;
}
.znp-job-detail .snap-val.muted { color: #64748b; font-weight: 500; }
.znp-job-detail .snap-val a { color: #1d4ed8; }
.znp-job-detail .snap-val a:hover { text-decoration: underline; }

.znp-job-detail .client-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fef3c7;
    border: 0.5px solid #fde68a;
    color: #92400e;
    border-radius: 20px;
    padding: 3px 10px;
    font-size: 11px;
    font-weight: 600;
    margin-left: 6px;
}

.znp-job-detail .conf-pill {
    background: #fff7ed !important;
    border-color: #fed7aa !important;
    color: #9a3412 !important;
    font-weight: 600;
}

/* ─── perks & awards lists ───────────────────────────── */
.znp-job-detail .pill-list {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
}
.znp-job-detail .pl-perk {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11.5px;
    font-weight: 500;
    background: #ecfdf5;
    border: 0.5px solid #a7f3d0;
    color: #065f46;
    border-radius: 20px;
    padding: 5px 12px;
}
.znp-job-detail .pl-perk::before {
    content: '';
    width: 5px;
    height: 5px;
    background: #10b981;
    border-radius: 50%;
}
.znp-job-detail .pl-award {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11.5px;
    font-weight: 600;
    background: #fef9c3;
    border: 0.5px solid #fde68a;
    color: #854d0e;
    border-radius: 20px;
    padding: 5px 12px;
}
.znp-job-detail .pl-award svg {
    width: 11px;
    height: 11px;
    flex-shrink: 0;
}

/* ─── perks collapse (read more) ─────────────────────── */
.znp-job-detail .perks-inner {
    max-height: 108px;
    overflow: hidden;
    position: relative;
    transition: max-height 0.3s ease;
}
.znp-job-detail .perks-inner.expanded { max-height: none; }
.znp-job-detail .perks-fade {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 44px;
    background: linear-gradient(transparent, var(--white));
    pointer-events: none;
    transition: opacity 0.2s;
}
.znp-job-detail .perks-inner.expanded .perks-fade { opacity: 0; }
.znp-job-detail .rm.is-hidden { display: none; }

/* ─── company details (extended about-company) ──────── */
.znp-job-detail .cmeta {
    display: grid;
    grid-template-columns: 110px 1fr;
    gap: 8px 14px;
    margin-top: 14px;
    padding-top: 14px;
    border-top: 0.5px dashed #e2e8f0;
    font-size: 12px;
}
.znp-job-detail .cmeta dt {
    color: #64748b;
    font-weight: 600;
    margin: 0;
}
.znp-job-detail .cmeta dd {
    color: #0f172a;
    font-weight: 500;
    margin: 0;
    word-break: break-word;
}
.znp-job-detail .cmeta dd a { color: #1d4ed8; }
.znp-job-detail .cmeta dd a:hover { text-decoration: underline; }
.znp-job-detail .cmeta .country-chips {
    display: flex; flex-wrap: wrap; gap: 6px;
}
.znp-job-detail .cmeta .country-chips span {
    font-size: 11px;
    padding: 2px 9px;
    background: #f1f5f9;
    border: 0.5px solid #cbd5e1;
    border-radius: 20px;
    color: #334155;
    font-weight: 500;
}

/* ─── application requirements (right rail) ──────────── */
.znp-job-detail .req-list {
    display: flex;
    flex-direction: column;
    gap: 7px;
}
.znp-job-detail .req-list li {
    list-style: none;
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 12px;
    color: #334155;
    line-height: 1.5;
}
.znp-job-detail .req-list svg {
    width: 13px;
    height: 13px;
    margin-top: 2px;
    flex-shrink: 0;
    color: #1c3faa;
}
.znp-job-detail .strict-banner {
    margin-top: 12px;
    background: #fef2f2;
    border: 0.5px solid #fecaca;
    color: #991b1b;
    border-radius: 8px;
    padding: 9px 12px;
    font-size: 11.5px;
    font-weight: 500;
    line-height: 1.55;
    display: flex;
    align-items: flex-start;
    gap: 8px;
}
.znp-job-detail .strict-banner svg { width: 13px; height: 13px; flex-shrink: 0; margin-top: 2px; }

/* ─── questionnaire (right rail) ─────────────────────── */
.znp-job-detail .qst-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    counter-reset: qst;
    padding: 0;
    margin: 0;
}
.znp-job-detail .qst-list li {
    list-style: none;
    counter-increment: qst;
    display: flex;
    gap: 9px;
    font-size: 11.5px;
    color: #334155;
    line-height: 1.55;
}
.znp-job-detail .qst-list li::before {
    content: counter(qst);
    flex-shrink: 0;
    width: 18px; height: 18px;
    background: #eff6ff;
    border: 0.5px solid #bfdbfe;
    color: #1e40af;
    border-radius: 50%;
    font-size: 10px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.znp-job-detail .qst-q { font-weight: 500; color: #0f172a; word-break: break-word; }
.znp-job-detail .qst-meta {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 3px;
    font-size: 10.5px;
    color: #64748b;
    font-weight: 500;
}
.znp-job-detail .qst-type-chip {
    background: #f1f5f9;
    border-radius: 10px;
    padding: 1px 8px;
    font-size: 10px;
    color: #475569;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.znp-job-detail .qst-req { color: #dc2626; font-weight: 700; }
.znp-job-detail .qst-hint {
    margin-top: 2px;
    margin-bottom: 12px;
    font-size: 11px;
    color: #64748b;
    line-height: 1.5;
}

/* ─── responsive ─────────────────────────────────────── */
@media (max-width: 768px) {
    .znp-job-detail .jd-grid {
        grid-template-columns: 1fr;
    }
    .znp-job-detail .rc {
        order: -1;
    }
    .znp-job-detail .jh-body {
        padding: 16px 16px 14px;
    }
    .znp-job-detail .jact {
        flex-direction: column;
        align-items: flex-start;
    }
    .znp-job-detail .jtitle {
        font-size: 16px;
    }
}

/* ─── apply modal ─────────────────────────────────────── */
.znp-apply-modal,
.znp-apply-modal * {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}
.znp-apply-modal .modal-content {
    border: none;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18);
    overflow: hidden;
    padding: 0;
}
.znp-am-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 22px 14px;
    border-bottom: 0.5px solid #e2e8f0;
    background: #f8fafc;
}
.znp-am-title {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
}
.znp-am-title svg { width:18px; height:18px; color:#1a3faa; flex-shrink:0; }
.znp-am-title .znp-am-jobtitle {
    color: #1a3faa;
    max-width: 260px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.znp-am-close {
    background: none; border: none; font-size: 22px; line-height: 1;
    color: #94a3b8; cursor: pointer; padding: 0 2px;
}
.znp-am-close:hover { color: #0f172a; }
.znp-am-body { padding: 20px 22px 24px; max-height: 78vh; overflow-y: auto; }
.znp-am-group { margin-bottom: 14px; }
.znp-am-label { display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 5px; }
.znp-am-label span { color: #dc2626; margin-left: 2px; }
.znp-am-input,
.znp-am-select {
    width: 100%; padding: 9px 12px;
    border: 1.5px solid #cbd5e1; border-radius: 8px;
    font-size: 13px; color: #0f172a; background: #fff;
    outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    font-family: inherit;
}
.znp-am-input:focus,
.znp-am-select:focus {
    border-color: #1a3faa;
    box-shadow: 0 0 0 3px rgba(26,63,170,0.08);
}
.znp-am-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
    padding-right: 34px; cursor: pointer;
}
.znp-am-section-title {
    font-size: 11px; font-weight: 700; color: #64748b;
    text-transform: uppercase; letter-spacing: 0.07em;
    margin: 18px 0 12px;
    display: flex; align-items: center; gap: 8px;
}
.znp-am-section-title::after { content:''; flex:1; height:1px; background:#e2e8f0; }
.znp-am-slot {
    background: #f8fafc; border: 0.5px solid #e2e8f0;
    border-radius: 10px; padding: 14px 14px 10px; margin-bottom: 10px;
    position: relative;
}
.znp-am-3col { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
.znp-am-3col .znp-am-group { margin-bottom: 0; }

/* ── Mandatory Questionnaire (replaces the old slot picker) ── */
.znp-am-qst-list {
    display: flex; flex-direction: column;
    gap: 14px;
    counter-reset: znp-q;
}
.znp-am-qst {
    counter-increment: znp-q;
    background: #f8fafc;
    border: 0.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 14px;
}
.znp-am-qst-label {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: 12.5px; font-weight: 600; color: #0f172a;
    margin-bottom: 8px; line-height: 1.45;
}
.znp-am-qst-label::before {
    content: counter(znp-q);
    flex-shrink: 0;
    width: 20px; height: 20px;
    background: #1c3faa; color: #fff;
    border-radius: 50%;
    font-size: 10.5px; font-weight: 700;
    display: inline-flex; align-items: center; justify-content: center;
    margin-top: 1px;
}
.znp-am-qst-label .req-star { color: #dc2626; }
.znp-am-qst-type {
    background: #eff6ff;
    border: 0.5px solid #bfdbfe;
    color: #1e40af;
    border-radius: 10px;
    padding: 1px 8px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-left: auto;
    flex-shrink: 0;
    align-self: center;
}
.znp-am-qst-input,
.znp-am-qst textarea {
    width: 100%;
    padding: 9px 12px;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    font-size: 13px;
    color: #0f172a;
    background: #fff;
    outline: none;
    font-family: inherit;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.znp-am-qst-input:focus,
.znp-am-qst textarea:focus {
    border-color: #1a3faa;
    box-shadow: 0 0 0 3px rgba(26,63,170,0.08);
}
.znp-am-qst textarea { resize: vertical; min-height: 70px; line-height: 1.5; }
.znp-am-qst-yesno {
    display: flex; gap: 8px;
}
.znp-am-qst-yesno label {
    flex: 1;
    display: flex; align-items: center; justify-content: center;
    gap: 6px;
    padding: 8px 12px;
    border: 1.5px solid #cbd5e1;
    background: #fff;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s;
    margin-bottom: 0;
}
.znp-am-qst-yesno input[type="radio"] { display: none; }
.znp-am-qst-yesno label:hover { border-color: #94a3b8; background: #f8fafc; }
.znp-am-qst-yesno input[type="radio"]:checked + span,
.znp-am-qst-yesno label.is-on {
    /* keep simple; we toggle the .is-on class on the wrapping label */
}
.znp-am-qst-yesno label.is-on {
    border-color: #1c3faa;
    background: #eff6ff;
    color: #1c3faa;
}
.znp-am-qst-empty {
    background: #f0fdf4;
    border: 0.5px solid #bbf7d0;
    color: #15803d;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 12px;
    line-height: 1.55;
    display: flex; align-items: flex-start; gap: 8px;
}
.znp-am-qst-empty svg { width: 14px; height: 14px; flex-shrink: 0; margin-top: 2px; }

/* ── Confirm & Apply submit button (scoped to the modal so it
     renders correctly even though the modal is outside .znp-job-detail). */
.znp-apply-modal .znp-am-submit {
    width: 100%;
    margin-top: 18px;
    background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 13px 22px;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.01em;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    box-shadow: 0 4px 14px rgba(234, 88, 12, 0.28);
    transition: transform 0.12s ease, box-shadow 0.18s ease, background 0.18s ease;
    font-family: inherit;
}
.znp-apply-modal .znp-am-submit:hover {
    background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%);
    box-shadow: 0 6px 18px rgba(234, 88, 12, 0.38);
    transform: translateY(-1px);
    color: #ffffff;
}
.znp-apply-modal .znp-am-submit:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(234, 88, 12, 0.32);
}
.znp-apply-modal .znp-am-submit:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
    box-shadow: 0 2px 8px rgba(234, 88, 12, 0.16);
}
.znp-apply-modal .znp-am-submit svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    transition: transform 0.18s ease;
}
.znp-apply-modal .znp-am-submit:hover svg { transform: translateX(2px); }
.znp-am-slot-del {
    position: absolute; top: 9px; right: 10px;
    background: none; border: none; color: #94a3b8;
    font-size: 17px; cursor: pointer; line-height: 1; padding: 0;
}
.znp-am-slot-del:hover { color: #dc2626; }
.znp-am-add-btn {
    font-size: 12px; font-weight: 600; color: #1a3faa;
    background: none; border: 1.5px dashed #bfdbfe; border-radius: 8px;
    padding: 7px 14px; cursor: pointer; width: 100%;
    transition: all 0.2s; margin-bottom: 4px; margin-top: 2px;
}
.znp-am-add-btn:hover { background: #eff6ff; border-color: #1a3faa; }
.znp-am-add-btn:disabled { opacity: 0.4; cursor: not-allowed; }
.znp-am-error {
    background: #fef2f2; border: 0.5px solid #fecaca;
    color: #dc2626; border-radius: 8px;
    padding: 10px 14px; font-size: 12px; margin-top: 12px;
}
.znp-am-success { text-align: center; padding: 36px 16px; }
.znp-am-success-icon {
    width: 56px; height: 56px; background: #dcfce7; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; color: #16a34a; margin: 0 auto 14px;
}
.znp-am-success h3 { font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
.znp-am-success p  { font-size: 12px; color: #64748b; margin: 0; }
@media (max-width: 480px) {
    .znp-am-3col { grid-template-columns: 1fr; }
    .znp-apply-modal { margin: 8px; }
}
</style>
@endpush

@section('content')
@include('znp.header')

<div class="znp-job-detail">
<div class="jd-pg">

@php
    /* ── location decode ─────────────────────────────────── */
    try {
        $loc = unserialize($job->location);
        $locationStr = is_array($loc) ? implode(' · ', array_filter(array_values($loc))) : ($job->location ?? '');
    } catch (\Exception $e) {
        $locationStr = $job->location ?? '';
    }

    /* ── salary string ───────────────────────────────────── */
    $isCompConfidential = (bool) ($job->compensation_confidential ?? 0);
    if ($isCompConfidential) {
        $salaryStr = 'Compensation: Confidential';
    } elseif ($job->min_salary && $job->max_salary) {
        $salaryStr = $job->min_salary . 'L – ' . $job->max_salary . 'L / yr';
    } elseif ($job->min_salary) {
        $salaryStr = $job->min_salary . 'L+ / yr';
    } elseif ($job->max_salary) {
        $salaryStr = 'Up to ' . $job->max_salary . 'L / yr';
    } else {
        $salaryStr = '';
    }

    /* ── experience range (prefer exp_min/exp_max range, fall back to legacy) ── */
    $fmtYrs = function ($v) {
        $f = (float) $v;
        return rtrim(rtrim(number_format($f, 2, '.', ''), '0'), '.');
    };
    if ($job->exp_min !== null && $job->exp_min !== '' && $job->exp_max !== null && $job->exp_max !== '') {
        $expRangeStr = $fmtYrs($job->exp_min) . ' – ' . $fmtYrs($job->exp_max) . ' yrs';
    } elseif ($job->exp_min !== null && $job->exp_min !== '') {
        $expRangeStr = $fmtYrs($job->exp_min) . '+ yrs';
    } else {
        $expRangeStr = (string) ($job->experience ?? '');
    }

    /* ── posted age ──────────────────────────────────────── */
    $postedDays = $job->created_at ? (int) $job->created_at->diffInDays(now()) : null;
    if ($postedDays === null) {
        $postedLabel = '';
    } elseif ($postedDays === 0) {
        $postedLabel = 'Posted today';
    } elseif ($postedDays === 1) {
        $postedLabel = 'Posted 1 day ago';
    } else {
        $postedLabel = 'Posted ' . $postedDays . ' days ago';
    }

    /* ── interview modes ─────────────────────────────────── */
    $interviewModes = [];
    if (!empty($job->interview_modes)) {
        $interviewModes = array_filter(array_map('trim', explode(',', $job->interview_modes)));
    }
    $hasWalkin = in_array('Walkin', $interviewModes);

    /* ── job highlights (derive from content) ────────────── */
    $hlSource = $job->job_overview ?: $job->roles_responsibility ?: '';
    preg_match_all('/<li[^>]*>\s*(.*?)\s*<\/li>/si', $hlSource, $hlMatches);
    $highlights = [];
    foreach (($hlMatches[1] ?? []) as $raw) {
        $clean = preg_replace('/^[\s\-\*\•\●\·]+/u', '', trim(strip_tags($raw)));
        if ($clean) $highlights[] = $clean;
        if (count($highlights) >= 3) break;
    }
    if (empty($highlights)) {
        $plainText = trim(preg_replace('/\s+/', ' ', strip_tags($hlSource)));
        $sentences = array_filter(array_map('trim', preg_split('/(?<=[.!?])\s+/', $plainText)));
        $highlights = array_slice(array_values($sentences), 0, 3);
    }

    /* ── company badges ──────────────────────────────────── */
    $co          = $job->company;
    $hcMap       = [
        '1-10'=>'1-10 Employees','11-50'=>'11-50 Employees','51-200'=>'51-200 Employees',
        '201-500'=>'201-500 Employees','501-1000'=>'501-1K Employees','1001-5000'=>'1K-5K Employees',
        '5001-10000'=>'5K-10K Employees','10001-25000'=>'10K-25K Employees',
        '25001-50000'=>'25K-50K Employees','50001-75000'=>'50K-75K Employees',
        '75001-100000'=>'75K-1L Employees','100000+'=>'1L+ Employees',
    ];
    $companyName = trim($co->name ?? '');
    $companyDisplayName = $companyName ?: 'Company';
    $companyBadgeText = mb_strlen($companyDisplayName) <= 14
        ? $companyDisplayName
        : strtoupper(mb_substr(preg_replace('/\s+/', '', $companyDisplayName), 0, 3));
    $headcountStr = ($co && isset($hcMap[$co->size])) ? $hcMap[$co->size] : '';
    $hasGptw      = $co && $co->is_gptw_certified;
    $hasTopEmp    = $co && $co->is_top_employer;
    $hasDisab     = $co && $co->is_disability_hiring;
    $hasWomen     = $co && $co->is_women_friendly;
    $hasAnyBadge  = $hasGptw || $hasTopEmp || $headcountStr || $hasDisab || $hasWomen;

    /* ── share URL ───────────────────────────────────────── */
    $shareUrl = urlencode(url()->current());
    $shareTitle = urlencode($job->job_title . ' at ZeroNoticePeriod');

    /* ── posting type / client metadata ──────────────────── */
    $postingType   = strtolower((string) ($job->posting_type ?? ''));
    $isClientPost  = $postingType === 'client';
    $clientName    = trim((string) ($job->client_name ?? ''));
    $clientIndStr  = trim((string) ($job->client_industry ?? ''));

    /* ── contract block (only for *Contract* job types) ──── */
    $isContract = (bool) preg_match('/contract/i', (string) ($job->job_type ?? ''));
    $contractDuration  = trim((string) ($job->duration ?? ''));
    $contractDayRate   = $job->contract_day_rate;
    $contractExtension = trim((string) ($job->contract_extension ?? ''));
    $hasContractInfo   = $isContract && ($contractDuration || $contractDayRate || $contractExtension);

    /* ── headcount label (reuse $hcMap from above) ──────── */
    $jobHeadcount = trim((string) ($job->headcount ?? ''));
    $jobHeadcountLabel = $jobHeadcount && isset($hcMap[$jobHeadcount]) ? $hcMap[$jobHeadcount] : $jobHeadcount;

    /* ── industry / website / office / countries ───────── */
    $jobIndustryStr = trim((string) ($job->industry ?? ''));
    $jobWebsiteRaw  = trim((string) ($job->website_address ?? ''));
    $jobWebsiteHost = $jobWebsiteRaw ? preg_replace('#^https?://(www\.)?#i', '', $jobWebsiteRaw) : '';
    $jobOfficeAddr  = trim((string) ($job->office_address ?? ''));
    try {
        $jobCountries = json_decode((string) ($job->countries_presence ?? '[]'), true) ?: [];
    } catch (\Exception $e) { $jobCountries = []; }

    /* ── perks / awards (JSON arrays on post_jobs) ──────── */
    try { $perks  = json_decode((string) ($job->perks  ?? '[]'), true) ?: []; } catch (\Exception $e) { $perks  = []; }
    try { $awards = json_decode((string) ($job->awards ?? '[]'), true) ?: []; } catch (\Exception $e) { $awards = []; }
    /* De-dupe defensively (older rows may have duplicates from clone history). */
    $perks  = array_values(array_unique(array_filter(array_map('trim', $perks))));
    $awards = array_values(array_unique(array_filter(array_map('trim', $awards))));

    /* ── profile requirements + strict mode ─────────────── */
    try { $profileReqs = json_decode((string) ($job->profile_requirements ?? '[]'), true) ?: []; }
    catch (\Exception $e) { $profileReqs = []; }
    $profileReqs = array_values(array_unique(array_filter(array_map('trim', $profileReqs))));
    $isStrictMode = (int) ($job->strict_mode ?? 0) === 1;

    /* ── questionnaire (skip disabled rows; pretty type label) ─ */
    try { $questionnaire = json_decode((string) ($job->questionnaire ?? '[]'), true) ?: []; }
    catch (\Exception $e) { $questionnaire = []; }
    $questionnaire = array_values(array_filter($questionnaire, function ($q) {
        return is_array($q) && !empty($q['label']) && (!isset($q['enabled']) || $q['enabled']);
    }));
    $qstTypeMap = [
        'text'   => 'Short answer',
        'yesno'  => 'Yes / No',
        'number' => 'Number',
        'url'    => 'Video link',
    ];
@endphp

{{-- ═══ JOB HEADER ═══════════════════════════════════════════════ --}}
<div class="jh">
    <div class="jh-bar"></div>
    <div class="jh-body">

        <div class="jh-top">
            <div>
                <div class="jtitle">{{ $job->job_title }}</div>
                <div class="pbadge"><span class="pdot"></span>{{ $companyDisplayName }}</div>
            </div>
            <div class="znpbadge">
                @if($co && $co->logo)
                    <img src="{{ asset('company_logos/' . $co->logo) }}" alt="{{ $companyDisplayName }}">
                @else
                    {{ $companyBadgeText }}
                @endif
            </div>
        </div>

        <div class="sum-row">
            @if($salaryStr)<span class="sg-pill {{ $isCompConfidential ? 'conf-pill' : '' }}">{{ $salaryStr }}</span>@endif
            @if($job->job_type)<span class="sg-pill">{{ $job->job_type }}</span>@endif
            @if($expRangeStr)<span class="sg-pill">{{ $expRangeStr }}</span>@endif
            @if($job->job_shift)<span class="sg-pill">{{ $job->job_shift }}</span>@endif
            @if($job->work_mode)<span class="sg-pill">{{ $job->work_mode }}</span>@endif
            @if($locationStr)<span class="sg-pill">{{ $locationStr }}</span>@endif
            @if($isClientPost)<span class="client-pill">Hiring for a Client</span>@endif
        </div>

        @if($hasAnyBadge)
        <div class="cert-badges">
            @if($hasGptw)
            <span class="ctag cg">
                <svg viewBox="0 0 13 13" stroke="#0369a1" stroke-width="2"><polyline points="1.5,6.5 5,10 11.5,3"/></svg>
                GPTW Certified
            </span>
            @endif
            @if($hasTopEmp)
            <span class="ctag ce">
                <svg viewBox="0 0 13 13" stroke="#0f766e" stroke-width="1.8"><polygon points="6.5,1.5 8,4.5 11.5,5 9,7.5 9.5,11 6.5,9.5 3.5,11 4,7.5 1.5,5 5,4.5"/></svg>
                Top Employer
            </span>
            @endif
            @if($headcountStr)
            <span class="ctag cs">
                <svg viewBox="0 0 13 13" stroke="#475569" stroke-width="1.8"><circle cx="4.5" cy="4" r="2"/><circle cx="9" cy="4" r="2"/><path d="M1 11c0-2 1.6-3.5 3.5-3.5s3.5 1.5 3.5 3.5"/><path d="M9 7.5c1.5.3 3 1.2 3 3"/></svg>
                {{ $headcountStr }}
            </span>
            @endif
            @if($hasDisab)
            <span class="ctag cd">
                <svg viewBox="0 0 13 13" stroke="#7e22ce" stroke-width="1.8"><circle cx="6.5" cy="3" r="1.5"/><path d="M6.5 5v4M4.5 7h4M4.5 12l2-3 2 3"/></svg>
                Disability Hiring
            </span>
            @endif
            @if($hasWomen)
            <span class="ctag cw">
                <svg viewBox="0 0 13 13" stroke="#be185d" stroke-width="1.8"><circle cx="6.5" cy="4.5" r="2.2"/><path d="M6.5 6.8v4M5 10h3"/></svg>
                Women Friendly
            </span>
            @endif
        </div>
        @endif

        <div class="jact">
            <!--<div class="jinfo">-->
            <!--    {{ $postedLabel }}@if($postedLabel) &nbsp;·&nbsp; @endif Applicants: {{ $applicantCount }}-->
            <!--</div>-->
            <div class="jinfo">
                {{ $postedLabel }}@if($postedLabel) &nbsp; @endif
            </div>
            <div class="abtns">
                @guest
                    {{-- Not logged in: show Register + Apply redirects to login --}}
                    <a href="{{ route('register') }}" class="bsave">Register</a>
                    <a href="{{ route('login') }}" class="bapp">Apply Now →</a>
                @else
                    {{-- Logged in --}}
                    @if(Auth::user()->isAppliedOnJob($job->id))
                        <span class="bapp-applied">✓ Applied</span>
                    @else
                        {{-- No Register button when authenticated --}}
                        <button class="bapp" data-toggle="modal" data-target="#applyModal">Apply Now →</button>
                    @endif
                @endguest
            </div>
        </div>

    </div>
</div>
{{-- end job header --}}

{{-- ═══ GRID ═══════════════════════════════════════════════════════ --}}
<div class="jd-grid">

    {{-- ── LEFT COLUMN ───────────────────────────────────────── --}}
    <div class="lc">

        {{-- Job Highlights --}}
        @if(count($highlights))
        <div class="card">
            <div class="ct">Job highlights</div>
            <ul class="hl">
                @foreach($highlights as $hl)
                    <li><span class="hd"></span>{{ $hl }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Contract details (only when job_type is *Contract*) --}}
        @if($hasContractInfo)
        <div class="card">
            <div class="ct">Contract details</div>
            <div class="snap-grid">
                @if($contractDuration)
                <div class="snap-item">
                    <span class="snap-lbl">Duration</span>
                    <span class="snap-val">{{ $contractDuration }}</span>
                </div>
                @endif
                @if($contractDayRate)
                <div class="snap-item">
                    <span class="snap-lbl">Day rate</span>
                    <span class="snap-val">₹{{ number_format((float) $contractDayRate, 0) }} / day</span>
                </div>
                @endif
                @if($contractExtension)
                <div class="snap-item">
                    <span class="snap-lbl">Extension</span>
                    <span class="snap-val">{{ $contractExtension }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Key Skills --}}
        @if($jobskills->count())
        <div class="card">
            <div class="ct">Key skills</div>
            <div class="sw">
                @foreach($jobskills as $i => $skill)
                    <span class="sk{{ $i < 2 ? ' p' : '' }}">{{ $skill->job_skill }}</span>
                @endforeach
            </div>
            @if($jobskills->count() > 2)
            <p class="sknote">Skills highlighted in blue are preferred key skills</p>
            @endif
        </div>
        @endif

        {{-- Job Description --}}
        @if($job->job_description || $job->job_overview || $job->roles_responsibility)
        <div class="card">
            <div class="ct">Job description</div>
            <div class="db">
                <div class="desc-inner" id="jd-desc">
                    @if($job->job_description)
                        {!! $job->job_description !!}
                    @endif
                    @if($job->job_overview)
                        {!! $job->job_overview !!}
                    @endif
                    @if($job->roles_responsibility)
                        {!! $job->roles_responsibility !!}
                    @endif
                    <div class="desc-fade" id="jd-fade"></div>
                </div>
                <button type="button" class="rm is-hidden" id="jd-rm-btn" onclick="znpToggleDesc()">read more ▾</button>
            </div>
        </div>
        @endif

        {{-- Share + Report --}}
        <div class="card" style="padding:13px 24px;">
            <div class="shr">
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:12px;color:#64748b;font-weight:600;">Share this job:</span>
                    <div style="display:flex;gap:7px;">
                        <a class="sob sfb"
                           href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                           target="_blank" rel="noopener noreferrer"
                           title="Share on Facebook">f</a>
                        <a class="sob sx"
                           href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
                           target="_blank" rel="noopener noreferrer"
                           title="Share on X">𝕏</a>
                        <a class="sob sli"
                           href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}&title={{ $shareTitle }}"
                           target="_blank" rel="noopener noreferrer"
                           title="Share on LinkedIn">in</a>
                    </div>
                </div>
                {{-- <button class="rpt" onclick="znpReportJob()">Report this job</button> --}}
            </div>
        </div>

        {{-- About the Company --}}
        <div class="card">
            <div class="ct">About the company</div>
            <div class="crow">
                <div class="clogo">
                    @if($co && $co->logo)
                        <img src="{{ asset('company_logos/' . $co->logo) }}" alt="{{ $co->name ?? 'Company' }}">
                    @else
                        {{ $co ? strtoupper(substr($co->name ?? 'C', 0, 3)) : 'ZNP' }}
                    @endif
                </div>
                <div>
                    <div class="cn">{{ $companyDisplayName }}</div>
                    <div class="csub">Exclusive immediate-hire listing on ZeroNoticePeriod</div>
                </div>
            </div>
            <p class="cdesc">
                @php
                    /* Prefer the per-job snapshot (always reflects what was posted),
                       fall back to the company-level description for older rows. */
                    $aboutText = trim((string) ($job->about_company ?? ''));
                    if ($aboutText === '' && $co && $co->description) {
                        $aboutText = (string) $co->description;
                    }
                @endphp
                @if($aboutText !== '')
                    {!! $aboutText !!}
                @else
                    ZeroNoticePeriod is an exclusive online hiring platform connecting job seekers with Zero Notice Period with employers looking for immediate hires. We help employers hire at a fast pace without losing time on "searching" talent with zero notice period.
                @endif
            </p>

            @if($jobIndustryStr || $jobHeadcountLabel || $jobWebsiteHost || $jobOfficeAddr || count($jobCountries))
            <dl class="cmeta">
                @if($jobIndustryStr)
                    <dt>Industry</dt>
                    <dd>{{ $jobIndustryStr }}</dd>
                @endif
                @if($jobHeadcountLabel)
                    <dt>Team size</dt>
                    <dd>{{ $jobHeadcountLabel }}</dd>
                @endif
                @if($jobWebsiteHost)
                    <dt>Website</dt>
                    <dd>
                        <a href="{{ $jobWebsiteRaw }}" target="_blank" rel="noopener nofollow">{{ $jobWebsiteHost }} ↗</a>
                    </dd>
                @endif
                @if($jobOfficeAddr)
                    <dt>Office</dt>
                    <dd>{{ $jobOfficeAddr }}</dd>
                @endif
                @if(count($jobCountries))
                    <dt>Presence</dt>
                    <dd>
                        <div class="country-chips">
                            @foreach($jobCountries as $cn)
                                <span>{{ $cn }}</span>
                            @endforeach
                        </div>
                    </dd>
                @endif
            </dl>
            @endif
        </div>

    </div>
    {{-- end left column --}}

    {{-- ── RIGHT COLUMN ──────────────────────────────────────── --}}
    <div class="rc">

        {{-- Mode of Interview --}}
        @if(count($interviewModes))
        <div class="card">
            <div class="ct">Mode of interview</div>
            <div class="itags">
                @foreach($interviewModes as $mode)
                    <span class="itag">{{ $mode }}</span>
                @endforeach
            </div>
            @if($hasWalkin && ($job->walkin_date || $job->walkin_venue || $job->walkin_time || $job->walkin_contact))
            <div class="walkin-box">
                @if($job->walkin_date)<div><strong>Date:</strong> {{ $job->walkin_date }}</div>@endif
                @if($job->walkin_time)<div><strong>Time:</strong> {{ $job->walkin_time }}</div>@endif
                @if($job->walkin_venue)<div><strong>Venue:</strong> {{ $job->walkin_venue }}</div>@endif
                @if($job->walkin_contact)<div><strong>Contact:</strong> {{ $job->walkin_contact }}</div>@endif
            </div>
            @endif
        </div>
        @endif

        {{-- Job Snapshot — non-duplicating quick facts.
             Header pills already cover: salary, job_type, experience range,
             job_shift, work_mode, location, "Hiring for a Client" badge.
             The snapshot adds the bits we *don't* already show in the header. --}}
        @php
            $hasSnapshot = $job->no_of_openings
                || $job->primary_language
                || $job->locality
                || ($isClientPost && ($clientName || $clientIndStr));
        @endphp
        @if($hasSnapshot)
        <div class="card rail-card">
            <div class="ct">Job snapshot</div>
            <ul class="kv-list">
                @if($job->no_of_openings)
                <li>
                    <span class="kv-lbl">Openings</span>
                    <span class="kv-val">{{ $job->no_of_openings }} {{ (int) $job->no_of_openings === 1 ? 'position' : 'positions' }}</span>
                </li>
                @endif

                @if($job->primary_language)
                <li>
                    <span class="kv-lbl">Primary language</span>
                    <span class="kv-val">{{ $job->primary_language }}</span>
                </li>
                @endif

                @if($job->locality)
                <li>
                    <span class="kv-lbl">Locality</span>
                    <span class="kv-val">{{ $job->locality }}</span>
                </li>
                @endif

                @if($isClientPost && ($clientName || $clientIndStr))
                <li class="kv-stack">
                    <span class="kv-lbl">Client</span>
                    <span class="kv-val">{{ $clientName ?: 'Confidential' }}</span>
                    @if($clientIndStr)
                        <span class="kv-sub">{{ $clientIndStr }}</span>
                    @endif
                </li>
                @endif
            </ul>
        </div>
        @endif

        {{-- Perks & Benefits --}}
        @if(count($perks))
        <div class="card rail-card">
            <div class="ct">Perks &amp; benefits</div>
            <div class="perks-inner" id="jd-perks">
                <div class="pill-list">
                    @foreach($perks as $p)
                        <span class="pl-perk">{{ $p }}</span>
                    @endforeach
                </div>
                <div class="perks-fade" id="jd-perks-fade"></div>
            </div>
            <button type="button" class="rm is-hidden" id="jd-perks-rm-btn" onclick="znpTogglePerks()">read more ▾</button>
        </div>
        @endif

        {{-- Awards & Recognition --}}
        @if(count($awards))
        <div class="card rail-card">
            <div class="ct">Awards &amp; recognition</div>
            <div class="pill-list">
                @foreach($awards as $a)
                    <span class="pl-award">
                        <svg viewBox="0 0 16 16" fill="#ca8a04" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 1.5l1.95 3.95 4.35.63-3.15 3.07.74 4.33L8 11.4 4.11 13.48l.74-4.33L1.7 6.08l4.35-.63z"/>
                        </svg>
                        {{ $a }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Similar Jobs --}}
        <div class="card rc-grow">
            <div class="ct">Similar jobs on ZNP</div>
            @forelse($similarJobs as $sj)
                @php
                    try {
                        $sjLoc = unserialize($sj->location);
                        $sjLocStr = is_array($sjLoc) ? implode(' · ', array_filter(array_slice(array_values($sjLoc), 0, 2))) : ($sj->location ?? '');
                    } catch (\Exception $e) {
                        $sjLocStr = $sj->location ?? '';
                    }
                    $sjCompany  = $sj->company->name ?? '';
                    $sjSalary   = ($sj->min_salary && $sj->max_salary) ? $sj->min_salary.'–'.$sj->max_salary.' LPA' : ($sj->min_salary ? $sj->min_salary.'+ LPA' : '');
                    $sjExp      = $sj->experience ?? '';
                @endphp
                <div class="sj">
                    <a class="sjt" href="{{ route('job.detail.znp', $sj->slug) }}">{{ $sj->job_title }}</a>
                    @if($sjCompany || $sjLocStr)
                    <div class="sjm">{{ implode(' · ', array_filter([$sjCompany, $sjLocStr])) }}</div>
                    @endif
                    @if($sjExp || $sjSalary)
                    <div class="sjm">{{ implode(' · ', array_filter([$sjExp, $sjSalary])) }}</div>
                    @endif
                    <div class="sjtags">
                        @if($sj->work_mode)<span class="sjt2">{{ $sj->work_mode }}</span>@endif
                        <span class="sjt2">Immediate</span>
                    </div>
                </div>
            @empty
                <p style="font-size:12px;color:#94a3b8;margin:0;">No similar jobs found right now.</p>
            @endforelse
            <a href="{{ route('jobs.page') }}" class="bb">Browse all jobs →</a>
        </div>

    </div>
    {{-- end right column --}}

</div>
{{-- end grid --}}

</div>
</div>
{{-- end .jd-pg / .znp-job-detail --}}

@include('znp.footer')

{{-- ═══ APPLY MODAL (for authenticated non-applied users) ═════════ --}}
@auth
@if(!Auth::user()->isAppliedOnJob($job->id))
@php $amUser = Auth::user(); @endphp
<div class="modal fade" id="applyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered znp-apply-modal" role="document" style="max-width:520px;">
        <div class="modal-content">

            {{-- header --}}
            <div class="znp-am-header">
                <div class="znp-am-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    Apply for&nbsp;<span class="znp-am-jobtitle">{{ $job->job_title }}</span>
                </div>
                <button class="znp-am-close" type="button" data-dismiss="modal" aria-label="Close">×</button>
            </div>

            {{-- success screen --}}
            <div class="znp-am-success" id="znp-am-success" style="display:none;">
                <div class="znp-am-success-icon">✓</div>
                <h3>Application Submitted!</h3>
                <p>Our recruiters will get back to you soon.</p>
            </div>

            {{-- form body --}}
            <div class="znp-am-body" id="znp-am-form-wrap">
                <form id="znp-apply-form" method="POST"
                      action="{{ route('job.update.front.profile.np', [$amUser->id]) }}">
                    @csrf
                    <input type="hidden" name="job_id"  value="{{ $job->id }}">
                    <input type="hidden" name="user_id" value="{{ $amUser->id }}">

                    {{-- Mandatory Questionnaire (set by the employer at post-time).
                         Renders only enabled questions. Required questions get a
                         red asterisk + client-side gating. --}}
                    @if(count($questionnaire))
                    <div class="znp-am-section-title">Mandatory Questionnaire</div>
                    <p style="font-size:11.5px;color:#64748b;margin:-6px 0 12px;">
                        The employer asks every applicant to answer these before they review your profile.
                    </p>
                    <div class="znp-am-qst-list">
                        @foreach($questionnaire as $q)
                            @php
                                $qKey   = (string) ($q['key']   ?? 'q_' . md5((string) ($q['label'] ?? '')));
                                $qLabel = (string) ($q['label'] ?? '');
                                $qType  = (string) ($q['type']  ?? 'text');
                                $qReq   = (bool)   ($q['required'] ?? false);
                                $qTypeLabel = $qstTypeMap[$qType] ?? ucfirst($qType);
                                $inputName = 'answers[' . $qKey . ']';
                            @endphp
                            <div class="znp-am-qst" data-qkey="{{ $qKey }}" data-qtype="{{ $qType }}" data-qrequired="{{ $qReq ? '1' : '0' }}">
                                <div class="znp-am-qst-label">
                                    <span style="flex:1;">
                                        {{ $qLabel }}
                                        @if($qReq)<span class="req-star">&nbsp;*</span>@endif
                                    </span>
                                    <span class="znp-am-qst-type">{{ $qTypeLabel }}</span>
                                </div>

                                @if($qType === 'yesno')
                                    <div class="znp-am-qst-yesno" role="radiogroup">
                                        <label>
                                            <input type="radio" name="{{ $inputName }}" value="Yes">
                                            <span>Yes</span>
                                        </label>
                                        <label>
                                            <input type="radio" name="{{ $inputName }}" value="No">
                                            <span>No</span>
                                        </label>
                                    </div>
                                @elseif($qType === 'number')
                                    <input type="number" name="{{ $inputName }}" class="znp-am-qst-input"
                                           min="0" step="1" placeholder="e.g. 5" autocomplete="off">
                                @elseif($qType === 'url')
                                    <input type="url" name="{{ $inputName }}" class="znp-am-qst-input"
                                           placeholder="https://drive.google.com/... or https://youtu.be/..." autocomplete="off">
                                @else
                                    <textarea name="{{ $inputName }}" rows="3" placeholder="Type your answer here…"></textarea>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @else
                    <div class="znp-am-qst-empty">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <polyline points="3 8 7 12 13 4"/>
                        </svg>
                        <span>The employer hasn't set any pre-apply questions for this job — you're all set to submit.</span>
                    </div>
                    @endif

                    <div class="znp-am-error" id="znp-am-error" style="display:none;"></div>

                    <button type="button" class="znp-am-submit" id="znp-am-submit-btn"
                            onclick="znpSubmitApply()">
                        Confirm &amp; Apply
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <line x1="3" y1="8" x2="13" y2="8"/><polyline points="9 4 13 8 9 12"/>
                        </svg>
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endif
@endauth

@endsection

@push('scripts')
<script>
/* ── read-more toggle (job description) ─────────────── */
function znpToggleDesc() {
    var inner = document.getElementById('jd-desc');
    var fade  = document.getElementById('jd-fade');
    var btn   = document.getElementById('jd-rm-btn');
    if (!inner) return;
    if (inner.classList.contains('expanded')) {
        inner.classList.remove('expanded');
        if (fade) fade.style.opacity = '1';
        if (btn) btn.textContent = 'read more ▾';
    } else {
        inner.classList.add('expanded');
        if (fade) fade.style.opacity = '0';
        if (btn) btn.textContent = 'show less ▴';
    }
}

/* ── read-more toggle (perks & benefits) ────────────── */
function znpTogglePerks() {
    var inner = document.getElementById('jd-perks');
    var btn   = document.getElementById('jd-perks-rm-btn');
    if (!inner) return;
    if (inner.classList.contains('expanded')) {
        inner.classList.remove('expanded');
        if (btn) btn.textContent = 'read more ▾';
    } else {
        inner.classList.add('expanded');
        if (btn) btn.textContent = 'show less ▴';
    }
}

function znpInitCollapsibles() {
    function bindToggle(innerId, btnId, maxHeight) {
        var inner = document.getElementById(innerId);
        var btn   = document.getElementById(btnId);
        if (!inner || !btn) return;
        if (inner.scrollHeight > maxHeight + 4) {
            btn.classList.remove('is-hidden');
        }
    }
    bindToggle('jd-desc', 'jd-rm-btn', 260);
    bindToggle('jd-perks', 'jd-perks-rm-btn', 108);
}

document.addEventListener('DOMContentLoaded', znpInitCollapsibles);

/* ── report job ───────────────────────────────────────── */
function znpReportJob() {
    alert('Thank you. Your report has been noted and will be reviewed by our team.');
}

/* ── apply modal ──────────────────────────────────────── */
(function () {
    /* The modal now contains only the Mandatory Questionnaire — no datepickers
       to bootstrap. NOP fields and the slot pickers are gone. */

    /* Yes/No questionnaire — toggle .is-on on the selected label so the
       chosen option highlights even though the radio itself is hidden. */
    $(document).on('change', '.znp-am-qst-yesno input[type="radio"]', function () {
        var $g = $(this).closest('.znp-am-qst-yesno');
        $g.find('label').removeClass('is-on');
        $(this).closest('label').addClass('is-on');
    });

    /* Client-side validation of required questionnaire answers.
       Server still re-validates — this is purely a UX nicety. */
    function znpValidateQuestionnaire() {
        var missing = [];
        $('#znp-apply-form .znp-am-qst[data-qrequired="1"]').each(function () {
            var $q   = $(this);
            var type = $q.data('qtype');
            var ok   = false;
            if (type === 'yesno') {
                ok = $q.find('input[type="radio"]:checked').length > 0;
            } else {
                var v = ($q.find('textarea, .znp-am-qst-input').val() || '').toString().trim();
                ok = v.length > 0;
            }
            if (!ok) {
                missing.push($q.find('.znp-am-qst-label > span').first().text().trim().replace(/\s+\*$/, ''));
            }
        });
        return missing;
    }

    function znpSetSubmitBtnLabel($btn, label, isLoading) {
        $btn.prop('disabled', !!isLoading);
        /* Replace the text node only — keep the SVG arrow intact. */
        $btn.contents().filter(function () {
            return this.nodeType === 3; /* Node.TEXT_NODE */
        }).first().replaceWith(document.createTextNode(' ' + label + ' '));
    }

    /* AJAX apply submit */
    window.znpSubmitApply = function () {
        var $form = $('#znp-apply-form');
        var $err  = $('#znp-am-error');
        var $btn  = $('#znp-am-submit-btn');
        $err.hide();

        var missing = znpValidateQuestionnaire();
        if (missing.length) {
            $err.html('Please answer the required questions:<br>• ' + missing.join('<br>• ')).show();
            return;
        }

        znpSetSubmitBtnLabel($btn, 'Submitting…', true);
        $.ajax({
            url:      $form.attr('action'),
            type:     'POST',
            data:     $form.serialize(),
            dataType: 'json',
            success: function () {
                $('#znp-am-form-wrap').hide();
                $('#znp-am-success').show();
                setTimeout(function () {
                    $('#applyModal').modal('hide');
                    location.reload();
                }, 2200);
            },
            error: function (xhr) {
                znpSetSubmitBtnLabel($btn, 'Confirm & Apply', false);
                var msg = 'Something went wrong. Please try again.';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errs = [];
                    $.each(xhr.responseJSON.errors, function (k, v) { errs.push(v[0]); });
                    msg = errs.join('<br>');
                } else if (xhr.status === 419) {
                    msg = 'Session expired. Please refresh the page and try again.';
                }
                $err.html(msg).show();
            }
        });
    };

})();
</script>
@endpush
