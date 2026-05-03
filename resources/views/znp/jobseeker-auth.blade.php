@extends('layouts.znp')

@section('page_title', 'Create your jobseeker account | ZeroNoticePeriod')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800&display=swap" rel="stylesheet">
<style>
/* ── ZNP JOBSEEKER-AUTH v13 ── */
.znp-auth-v13 {
    --blue:#3B5CCC;--blue-d:#2d47a3;--blue-50:#EEF1FB;--blue-100:#D6DEFC;
    --orange:#F2994A;--orange-50:#FEF3E8;--bg:#F7F8FC;--surface:#FFFFFF;
    --surface-2:#EEF1FB;--border:#E7EAF3;--text:#2F3443;--text-2:#4A5068;
    --text-3:#717A96;--text-4:#A0AABF;--r:14px;--r-sm:9px;--r-lg:22px;
    --font:'Nunito Sans',sans-serif;
    font-family:var(--font);color:var(--text);
    -webkit-font-smoothing:antialiased;line-height:1.5;
    background:var(--bg);position:relative;
}
.znp-auth-v13::before {
    content:'';position:fixed;inset:0;
    background:radial-gradient(ellipse 80% 60% at 20% 10%,rgba(59,92,204,.07) 0%,transparent 60%),
               radial-gradient(ellipse 55% 45% at 85% 85%,rgba(59,92,204,.05) 0%,transparent 55%),
               radial-gradient(ellipse 40% 40% at 60% 30%,rgba(242,153,74,.04) 0%,transparent 50%);
    pointer-events:none;z-index:0;
}
.znp-auth-v13 *,.znp-auth-v13 *::before,.znp-auth-v13 *::after {box-sizing:border-box;}
.znp-auth-v13 .wrap {
    max-width:900px;margin:0 auto;padding:32px 28px 56px;
    position:relative;z-index:1;
    animation:znpFadeUp .4s cubic-bezier(.22,.68,0,1.2) both;
}
.znp-auth-v13 .top {text-align:center;margin-bottom:24px;}
.znp-auth-v13 .top-eyebrow {
    display:inline-flex;align-items:center;gap:6px;
    background:var(--blue-50);border:1px solid var(--blue-100);
    color:var(--blue);font-size:13.5px;font-weight:700;
    padding:6px 16px;border-radius:50px;margin-bottom:14px;letter-spacing:.01em;
}
.znp-auth-v13 .top h1 {font-size:20px;font-weight:700;color:var(--text);letter-spacing:-.2px;line-height:1.3;margin-bottom:8px;}
.znp-auth-v13 .top h1 em {color:var(--blue);font-style:normal;}
.znp-auth-v13 .top p {font-size:13.5px;color:var(--text-3);letter-spacing:.01em;}
.znp-auth-v13 .props {
    display:flex;background:rgba(255,255,255,.7);border:1px solid var(--border);
    border-radius:var(--r) var(--r) 0 0;overflow:hidden;backdrop-filter:blur(8px);
    border-top:3px solid var(--orange);
}
.znp-auth-v13 .prop {flex:1;display:flex;align-items:center;gap:7px;padding:10px 14px;border-right:1px solid var(--border);}
.znp-auth-v13 .prop:last-child {border-right:none;}
.znp-auth-v13 .pdot {width:7px;height:7px;border-radius:50%;flex-shrink:0;}
.znp-auth-v13 .prop span {font-size:11.5px;font-weight:500;color:var(--text-2);}
.znp-auth-v13 .card {
    background:var(--surface);border:1px solid var(--border);border-top:none;
    border-radius:0 0 var(--r-lg) var(--r-lg);
    box-shadow:0 16px 48px rgba(59,92,204,.12),0 4px 16px rgba(47,52,67,.06);overflow:hidden;
}
.znp-auth-v13 .tabs {display:grid;grid-template-columns:1fr 1fr;border-bottom:1px solid var(--border);background:var(--surface-2);}
.znp-auth-v13 .tab {
    padding:14px;text-align:center;font-size:13px;font-weight:500;color:var(--text-3);
    cursor:pointer;border:none;background:transparent;font-family:var(--font);
    border-bottom:2px solid transparent;margin-bottom:-1px;transition:all .2s;letter-spacing:.01em;
}
.znp-auth-v13 .tab.on {color:var(--blue);background:var(--surface);border-bottom-color:var(--blue);font-weight:600;}
.znp-auth-v13 .tab:hover:not(.on) {color:var(--text-2);background:rgba(255,255,255,.6);}
.znp-auth-v13 .tab:focus,.znp-auth-v13 .tab:focus-visible,
.znp-auth-v13 .btn:focus,.znp-auth-v13 .btn:focus-visible,
.znp-auth-v13 .bback:focus,.znp-auth-v13 .bback:focus-visible,
.znp-auth-v13 .socbtn:focus,.znp-auth-v13 .socbtn:focus-visible,
.znp-auth-v13 .pw-tog:focus,.znp-auth-v13 .pw-tog:focus-visible,
.znp-auth-v13 .otpsend:focus,.znp-auth-v13 .otpsend:focus-visible {outline:none;box-shadow:none;}
.znp-auth-v13 .pnl {display:none;padding:28px 40px 36px;min-width:0;}
.znp-auth-v13 #psi {width:100%;max-width:500px;margin:0 auto;}
.znp-auth-v13 .pnl.on {display:block;}
.znp-auth-v13 .steps {display:flex;align-items:center;margin-bottom:28px;}
.znp-auth-v13 .st {display:flex;align-items:center;gap:8px;flex:1;}
.znp-auth-v13 .snum {
    width:28px;height:28px;border-radius:50%;font-size:11px;font-weight:700;
    display:flex;align-items:center;justify-content:center;flex-shrink:0;
    transition:all .25s;box-shadow:0 2px 6px rgba(0,0,0,.1);
}
.znp-auth-v13 .snum.a {background:var(--orange);color:#fff;}
.znp-auth-v13 .snum.d {background:var(--blue);color:#fff;font-size:13px;}
.znp-auth-v13 .snum.i {background:#fff;color:var(--text-4);border:1.5px solid var(--border);box-shadow:none;cursor:default;}
.znp-auth-v13 .snum.a,.znp-auth-v13 .snum.d {cursor:pointer;}
.znp-auth-v13 .slbl {font-size:11.5px;font-weight:500;white-space:nowrap;}
.znp-auth-v13 .slbl.a {color:var(--orange);font-weight:600;}
.znp-auth-v13 .slbl.d {color:var(--blue);font-weight:600;}
.znp-auth-v13 .slbl.i {color:var(--text-4);}
.znp-auth-v13 .sln {flex:1;height:2px;background:var(--border);margin:0 6px;border-radius:2px;transition:background .3s;}
.znp-auth-v13 .sln.d {background:var(--blue);}
.znp-auth-v13 .sec {
    font-size:10px;font-weight:700;color:var(--text-4);text-transform:uppercase;
    letter-spacing:.09em;margin:22px 0 12px;display:flex;align-items:center;gap:8px;
}
.znp-auth-v13 .sec:first-child {margin-top:0;}
.znp-auth-v13 .secbar {width:14px;height:2px;border-radius:2px;background:var(--blue);flex-shrink:0;}
.znp-auth-v13 .nopts {display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:20px;}
.znp-auth-v13 .nopt {
    border:1.5px solid var(--border);border-radius:var(--r);padding:14px 12px;
    cursor:pointer;transition:all .2s;background:var(--surface-2);position:relative;overflow:hidden;
}
.znp-auth-v13 .nopt::before {content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:transparent;transition:background .2s;}
.znp-auth-v13 .nopt:hover {border-color:var(--blue);background:var(--blue-50);box-shadow:0 1px 3px rgba(59,92,204,.06);}
.znp-auth-v13 .nopt:hover::before {background:var(--blue-d);}
.znp-auth-v13 .nopt.on {border-color:var(--blue);background:var(--blue-50);box-shadow:0 0 0 3px rgba(59,92,204,.1);}
.znp-auth-v13 .nopt.on::before {background:var(--blue);}
.znp-auth-v13 .nlbl {font-size:13px;font-weight:600;color:var(--text);margin-bottom:3px;}
.znp-auth-v13 .nopt.on .nlbl {color:var(--blue);}
.znp-auth-v13 .nsub {font-size:11px;color:var(--text-4);line-height:1.4;}
.znp-auth-v13 .g2 {display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.znp-auth-v13 .g3 {display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
.znp-auth-v13 .g4 {display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:14px;}
.znp-auth-v13 .f {display:flex;flex-direction:column;gap:5px;margin-bottom:14px;}
.znp-auth-v13 .f:last-child {margin-bottom:0;}
.znp-auth-v13 .lbl {font-size:12px;font-weight:600;color:var(--text-2);display:flex;align-items:center;gap:4px;}
.znp-auth-v13 .req {color:var(--orange);}
.znp-auth-v13 .opt-lbl {font-size:11px;font-weight:400;color:var(--text-4);}
.znp-auth-v13 input[type=text],.znp-auth-v13 input[type=email],.znp-auth-v13 input[type=tel],
.znp-auth-v13 input[type=password],.znp-auth-v13 input[type=date],
.znp-auth-v13 input[type=number],.znp-auth-v13 select {
    width:100%;font-family:var(--font);font-size:13.5px;
    border:1.5px solid var(--border);border-radius:var(--r-sm);
    padding:10px 13px;color:var(--text);background:var(--surface);
    outline:none;transition:border-color .15s,box-shadow .15s;-webkit-appearance:none;
}
.znp-auth-v13 input:focus,.znp-auth-v13 select:focus {border-color:var(--blue);box-shadow:0 0 0 3px rgba(59,92,204,.12);}
.znp-auth-v13 input::placeholder {color:var(--text-4);font-weight:400;}
.znp-auth-v13 select {
    cursor:pointer;appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%239ca3af' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 12px center;padding-right:34px;
}
.znp-auth-v13 .hint {font-size:11px;color:var(--text-4);}
.znp-auth-v13 .hint.ok {color:var(--blue);}
.znp-auth-v13 .hint.er {color:#dc2626;}
.znp-auth-v13 .pfx {display:flex;border:1.5px solid var(--border);border-radius:var(--r-sm);overflow:hidden;transition:border .15s,box-shadow .15s;}
.znp-auth-v13 .pfx:focus-within {border-color:var(--blue);box-shadow:0 0 0 3px rgba(59,92,204,.12);}
.znp-auth-v13 .pfx-lbl {padding:10px 12px;background:var(--surface-2);color:var(--text-3);font-size:13px;font-weight:500;white-space:nowrap;border-right:1.5px solid var(--border);flex-shrink:0;font-family:var(--font);}
.znp-auth-v13 .pfx-inp {border:none;outline:none;padding:10px 13px;font-size:13.5px;font-family:var(--font);color:var(--text);flex:1;min-width:0;background:var(--surface);}
.znp-auth-v13 .pfx-inp::placeholder {color:var(--text-4);}
.znp-auth-v13 .phw {display:flex;border:1.5px solid var(--border);border-radius:var(--r-sm);overflow:hidden;transition:border .15s,box-shadow .15s;}
.znp-auth-v13 .phw:focus-within {border-color:var(--blue);box-shadow:0 0 0 3px rgba(59,92,204,.12);}
.znp-auth-v13 .phcode {padding:10px 12px;background:var(--surface-2);color:var(--text-2);font-size:13px;font-weight:600;border-right:1.5px solid var(--border);flex-shrink:0;font-family:var(--font);}
.znp-auth-v13 .phinp {border:none;outline:none;padding:10px 13px;font-size:13.5px;font-family:var(--font);color:var(--text);flex:1;background:var(--surface);}
.znp-auth-v13 .phinp::placeholder {color:var(--text-4);}
.znp-auth-v13 .emst {min-height:16px;font-size:11.5px;font-weight:500;margin-top:3px;}
.znp-auth-v13 .emst.ok {color:var(--blue);}
.znp-auth-v13 .emst.er {color:#dc2626;}
.znp-auth-v13 .emst.ch {color:var(--text-4);}
.znp-auth-v13 .upload {border:2px dashed var(--border);border-radius:var(--r);padding:20px 16px;text-align:center;cursor:pointer;transition:all .2s;background:var(--surface-2);}
.znp-auth-v13 .upload:hover {border-color:var(--blue);background:var(--blue-50);box-shadow:0 0 0 4px rgba(59,92,204,.07);}
.znp-auth-v13 .upload-ico {width:44px;height:44px;background:var(--blue-50);border:1px solid var(--blue-100);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;}
.znp-auth-v13 .ut {font-size:13px;color:var(--text-2);font-weight:500;}
.znp-auth-v13 .ut b {color:var(--blue);}
.znp-auth-v13 .ut-sub {font-size:11.5px;color:var(--text-4);margin-top:3px;}
.znp-auth-v13 .pills {display:flex;flex-wrap:wrap;gap:7px;margin-bottom:5px;align-items:flex-start;}
.znp-auth-v13 .pill {
    display:inline-flex;align-items:center;gap:4px;padding:5px 13px;
    border:1.5px solid var(--border);border-radius:50px;font-size:12.5px;font-weight:500;
    color:var(--text-3);cursor:pointer;transition:all .15s;background:var(--surface);
    user-select:none;white-space:nowrap;flex:0 0 auto;font-family:var(--font);
}
.znp-auth-v13 .pill:hover {border-color:var(--blue);color:var(--blue);background:var(--blue-50);}
.znp-auth-v13 .pill.on {border-color:var(--blue);background:var(--blue-50);color:var(--blue);font-weight:600;}
.znp-auth-v13 .pill.on::before {content:'\2713  ';font-size:10px;}
.znp-auth-v13 .pill.added::after {content:' ×';font-size:12px;font-weight:700;line-height:1;}
.znp-auth-v13 .skwrap {border:1.5px solid var(--border);border-radius:var(--r);overflow:visible;transition:border .15s;}
.znp-auth-v13 .skwrap:focus-within {border-color:var(--blue);box-shadow:0 0 0 3px rgba(59,92,204,.12);}
.znp-auth-v13 .skbox {display:flex;flex-wrap:wrap;gap:5px;padding:8px;min-height:38px;background:var(--surface-2);border-bottom:1px solid var(--border);}
.znp-auth-v13 .sktag {display:inline-flex;align-items:center;gap:5px;background:var(--blue-50);border:1px solid var(--blue-100);border-radius:50px;padding:3px 10px 3px 12px;font-size:12px;font-weight:500;color:var(--blue);}
.znp-auth-v13 .sktag button {appearance:none;border:1px solid var(--blue-100);background:#fff;color:var(--text-2);width:20px;height:20px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;font-size:12px;line-height:1;cursor:pointer;padding:0;box-shadow:none;}
.znp-auth-v13 .sktag button:hover {background:var(--blue);border-color:var(--blue);color:#fff;}
.znp-auth-v13 .skx {cursor:pointer;color:var(--blue-d);font-size:14px;line-height:1;transition:color .1s;}
.znp-auth-v13 .skx:hover {color:var(--blue);}
.znp-auth-v13 .skinpw {position:relative;}
.znp-auth-v13 .skinp {width:100%;border:none;border-radius:0;padding:9px 13px;font-size:13px;font-family:var(--font);color:var(--text);outline:none;background:var(--surface);}
.znp-auth-v13 .skdd {display:none;position:absolute;top:100%;left:0;right:0;background:var(--surface);border:1.5px solid var(--blue);border-top:none;border-radius:0 0 var(--r-sm) var(--r-sm);z-index:20;max-height:160px;overflow-y:auto;box-shadow:0 8px 24px rgba(30,58,95,.12);}
.znp-auth-v13 .skdd.on {display:block;}
.znp-auth-v13 .skddi {padding:9px 14px;font-size:13px;cursor:pointer;border-bottom:1px solid var(--border);color:var(--text-2);}
.znp-auth-v13 .skddi:hover {background:var(--blue-50);color:var(--blue);}
.znp-auth-v13 .sksugg {display:flex;flex-wrap:nowrap;gap:5px;margin-top:8px;overflow-x:auto;white-space:nowrap;-webkit-overflow-scrolling:touch;}
.znp-auth-v13 .ssugg {font-size:11.5px;font-weight:500;padding:4px 11px;border-radius:50px;border:1.5px dashed var(--blue-100);color:var(--blue);background:var(--blue-50);flex:0 0 auto;white-space:nowrap;transition:all .15s;font-family:var(--font);pointer-events:none;cursor:default;}
.znp-auth-v13 .ssugg:hover {background:var(--blue);color:#fff;border-color:var(--blue);}
.znp-auth-v13 .skpill {font-size:11.5px;font-weight:500;padding:4px 11px;border-radius:50px;border:1.5px dashed var(--blue-100);color:var(--blue);background:var(--blue-50);flex:0 0 auto;white-space:nowrap;transition:all .15s;font-family:var(--font);pointer-events:none;cursor:default;}
.znp-auth-v13 .skpill.on {background:var(--blue);color:#fff;border-color:var(--blue);}
@media (max-width: 767px) {
  .znp-auth-v13 .sksugg {flex-wrap:wrap;overflow-x:visible;white-space:normal;}
  .znp-auth-v13 .skpill, .znp-auth-v13 .ssugg {pointer-events:auto;cursor:pointer;}
  .znp-auth-v13 .skdd {z-index:9999;}
  /* Stack step buttons on mobile for better tap targets */
  .znp-auth-v13 .brow {flex-direction:column;align-items:stretch;gap:10px;}
  .znp-auth-v13 .brow .bback {width:100%;margin:0;border-radius:12px;padding:10px 12px;}
  .znp-auth-v13 .brow .btn {width:100%;margin-top:0;border-radius:12px;padding:12px 14px;font-size:15px}
}
.znp-auth-v13 .skprog-wrap {margin-top:10px;}
.znp-auth-v13 .skprog-meta {display:flex;justify-content:space-between;font-size:11px;color:var(--text-4);margin-bottom:5px;}
.znp-auth-v13 .skprog {height:4px;background:var(--surface-2);border-radius:4px;overflow:hidden;}
.znp-auth-v13 .skfill {height:100%;border-radius:4px;transition:width .3s,background .3s;background:var(--orange);}
.znp-auth-v13 .ctcbox {display:flex;align-items:stretch;border:1.5px solid var(--border);border-radius:var(--r-sm);overflow:hidden;background:var(--surface);transition:border-color .15s,box-shadow .15s;}
.znp-auth-v13 .ctcbox:focus-within {border-color:var(--blue);box-shadow:0 0 0 3px rgba(59,92,204,.12);}
.znp-auth-v13 .ctcpfx {display:flex;align-items:center;justify-content:center;min-width:42px;padding:0 12px;background:var(--surface-2);border-right:1.5px solid var(--border);font-size:13px;font-weight:700;color:#6f82b2;}
.znp-auth-v13 .ctcbox input {border:none !important;border-radius:0 !important;box-shadow:none !important;background:transparent;padding:10px 13px;}
.znp-auth-v13 .optgrid {display:flex;flex-wrap:wrap;gap:14px;margin-top:10px;padding-top:10px;border-top:1px solid var(--border);}
.znp-auth-v13 .optcheck {display:flex;align-items:center;gap:7px;font-size:11.5px;color:var(--text-3);cursor:pointer;}
.znp-auth-v13 .optcheck input {accent-color:#3B5CCC;width:13px;height:13px;cursor:pointer;}
.znp-auth-v13 .priv {background:var(--surface-2);border:1px solid rgba(59,92,204,.18);border-radius:var(--r-sm);padding:11px 14px;display:flex;align-items:center;gap:9px;margin-bottom:14px;}
.znp-auth-v13 .priv input {accent-color:var(--blue);width:15px;height:15px;flex-shrink:0;cursor:pointer;}
.znp-auth-v13 .priv label {font-size:12.5px;color:var(--text-2);font-weight:500;cursor:pointer;}
.znp-auth-v13 .social-banner {display:none;align-items:center;gap:10px;background:var(--blue-50);border:1px solid var(--blue-100);border-radius:var(--r-sm);padding:10px 14px;margin-bottom:18px;font-size:12.5px;color:var(--blue);font-weight:500;}
.znp-auth-v13 .social-banner svg {flex-shrink:0;}
.znp-auth-v13 .social-banner-r {margin-left:auto;font-size:12px;font-weight:600;cursor:pointer;text-decoration:underline;color:var(--blue);white-space:nowrap;}
.znp-auth-v13 .pwbars {display:flex;gap:4px;margin-top:6px;}
.znp-auth-v13 .pwb {flex:1;height:3px;border-radius:3px;background:var(--border);transition:background .3s;}
.znp-auth-v13 .pwb.w {background:#ef4444;}
.znp-auth-v13 .pwb.m {background:#f59e0b;}
.znp-auth-v13 .pwb.s {background:var(--blue);}
.znp-auth-v13 .btn {display:block;width:100%;padding:12px 20px;border-radius:50px;font-size:14px;font-weight:600;cursor:pointer;font-family:var(--font);text-align:center;border:none;transition:all .2s;margin-top:18px;letter-spacing:.01em;}
.znp-auth-v13 .btnb {background:linear-gradient(135deg,var(--blue) 0%,var(--blue-d) 100%);color:#fff;box-shadow:0 4px 14px rgba(59,92,204,.3),0 2px 4px rgba(59,92,204,.2);}
.znp-auth-v13 .btnb:hover {transform:translateY(-2px);box-shadow:0 8px 24px rgba(59,92,204,.35),0 3px 8px rgba(59,92,204,.2);}
.znp-auth-v13 .btng {background:linear-gradient(135deg,var(--blue) 0%,#2d47a3 100%);color:#fff;box-shadow:0 4px 14px rgba(59,92,204,.3),0 2px 4px rgba(59,92,204,.12);}
.znp-auth-v13 .btng:hover {transform:translateY(-2px);box-shadow:0 8px 24px rgba(59,92,204,.3),0 3px 8px rgba(59,92,204,.12);}
.znp-auth-v13 .bback {padding:12px 20px;border:1.5px solid var(--border);background:var(--surface);color:var(--text-3);border-radius:50px;font-size:13.5px;font-weight:500;cursor:pointer;font-family:var(--font);transition:all .2s;flex-shrink:0;}
.znp-auth-v13 .bback:hover {border-color:var(--blue);color:var(--blue);}
.znp-auth-v13 .brow {display:flex;gap:10px;margin-top:18px;}
.znp-auth-v13 .brow .btn {margin-top:0;flex:1;}
.znp-auth-v13 .errbox {background:#fef2f2;border:1px solid #fecaca;border-radius:var(--r-sm);padding:12px 16px;margin-top:14px;display:none;}
.znp-auth-v13 .errbox ul {padding-left:16px;font-size:12.5px;color:#dc2626;line-height:1.9;margin-top:4px;}
.znp-auth-v13 #frnote {background:var(--orange-50);border:1px solid #ffe4d6;border-radius:var(--r-sm);padding:10px 14px;margin-bottom:16px;font-size:12.5px;color:#9a3412;display:none;}
.znp-auth-v13 .ordiv {display:flex;align-items:center;gap:12px;margin:16px 0;}
.znp-auth-v13 .orline {flex:1;height:1px;background:var(--border);}
.znp-auth-v13 .ortxt {font-size:12px;color:var(--text-4);font-weight:500;}
.znp-auth-v13 .socg {display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.znp-auth-v13 .socbtn {display:flex;align-items:center;justify-content:center;gap:8px;padding:10px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-size:13px;font-weight:500;color:var(--text-2);cursor:pointer;font-family:var(--font);background:var(--surface);transition:all .2s;}
.znp-auth-v13 .socbtn:hover {border-color:var(--blue);color:var(--blue);background:var(--surface-2);box-shadow:0 1px 3px rgba(59,92,204,.06);}
.znp-auth-v13 .otpw {display:flex;gap:8px;}
.znp-auth-v13 .otpw input {flex:1;}
.znp-auth-v13 .otpsend {padding:10px 16px;background:var(--blue);color:#fff;border:none;border-radius:var(--r-sm);font-size:13px;font-weight:600;cursor:pointer;font-family:var(--font);white-space:nowrap;flex-shrink:0;transition:all .2s;}
.znp-auth-v13 .otpsend:hover {background:#2d47a3;}
.znp-auth-v13 .cylimlbl {display:none;font-size:11.5px;color:var(--orange);font-weight:500;margin-top:4px;}
.znp-auth-v13 .foot {text-align:center;font-size:12.5px;color:var(--text-3);padding:14px 32px;border-top:1px solid var(--border);background:var(--surface-2);}
.znp-auth-v13 .foot a {color:var(--blue);font-weight:600;cursor:pointer;text-decoration:none;}
.znp-auth-v13 .foot a:hover {text-decoration:underline;}
.znp-auth-v13 .terms {font-size:11px;color:var(--text-4);text-align:center;margin-top:12px;line-height:1.7;}
.znp-auth-v13 .terms a {color:var(--blue);text-decoration:none;}
.znp-auth-v13 .verbox {background:var(--surface);border-radius:var(--r-lg);max-width:420px;margin:8px auto;padding:32px 28px;text-align:center;border:1px solid var(--border);box-shadow:0 4px 16px rgba(30,58,95,.08);}
.znp-auth-v13 #cvok {display:none;font-size:12px;color:var(--blue);font-weight:500;margin-top:6px;}
.znp-auth-v13 .gap9 {height:14px;}
/* Password toggle */
.znp-auth-v13 .pw-wrap {position:relative;}
.znp-auth-v13 .pw-wrap input {padding-right:44px;}
.znp-auth-v13 .pw-tog {position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-4);cursor:pointer;padding:4px;display:flex;align-items:center;justify-content:center;transition:color .2s;}
.znp-auth-v13 .pw-tog:hover {color:var(--text-2);}
/* Alerts & errors */
.znp-auth-v13 .znp-alert {padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:16px;}
.znp-auth-v13 .znp-alert-error {background:#fef2f2;border:1px solid #fecaca;color:#dc2626;}
.znp-auth-v13 .znp-alert-success {background:#f0fdf4;border:1px solid #bbf7d0;color:#16a34a;}
.znp-auth-v13 .is-invalid,.znp-auth-v13 .phw.is-invalid,.znp-auth-v13 .pfx.is-invalid,.znp-auth-v13 .ctcbox.is-invalid {border-color:#dc2626 !important;box-shadow:0 0 0 3px rgba(220,38,38,.08) !important;}
.znp-auth-v13 .znp-fe-err,.znp-auth-v13 .field-error {display:block;color:#dc2626;font-size:11px;margin-top:4px;line-height:1.4;}
/* jQuery UI autocomplete */
.znp-auth-v13 .ui-autocomplete {background:var(--surface);border:1.5px solid var(--border);border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,.12);max-height:200px;overflow-y:auto;overflow-x:hidden;padding:4px 0;z-index:9999;list-style:none;margin:4px 0 0;}
.znp-auth-v13 .ui-autocomplete .ui-menu-item {padding:0;}
.znp-auth-v13 .ui-autocomplete .ui-menu-item-wrapper {padding:9px 14px;font-size:13px;font-family:var(--font);color:var(--text);cursor:pointer;display:block;}
.znp-auth-v13 .ui-autocomplete .ui-menu-item-wrapper.ui-state-active,
.znp-auth-v13 .ui-autocomplete .ui-menu-item-wrapper:hover {background:var(--blue-50);color:var(--blue);border:none;outline:none;}
.znp-auth-v13 .ui-autocomplete .highlight {font-weight:700;color:var(--blue);}
/* Success modal */
.znp-auth-v13 .znp-modal {display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;padding:20px;}
.znp-auth-v13 .znp-modal.open {display:flex;}
.znp-auth-v13 .znp-modal-overlay {position:absolute;inset:0;background:rgba(10,18,50,.32);opacity:0;transition:opacity 280ms ease;}
.znp-auth-v13 .znp-modal.open .znp-modal-overlay {opacity:1;}
.znp-auth-v13 .znp-modal-content {position:relative;background:#fff;border-radius:20px;padding:36px 32px 0;width:100%;max-width:400px;box-shadow:0 32px 80px rgba(10,18,50,.22),0 4px 16px rgba(10,18,50,.08);z-index:2;text-align:center;overflow:hidden;transform:translateY(20px) scale(.97);opacity:0;transition:transform 320ms cubic-bezier(.16,1,.3,1),opacity 240ms ease;}
.znp-auth-v13 .znp-modal.open .znp-modal-content {transform:translateY(0) scale(1);opacity:1;}
.znp-auth-v13 .znp-modal-topclose {position:absolute;right:14px;top:14px;width:28px;height:28px;border-radius:50%;background:#f3f4f6;border:none;cursor:pointer;color:#6b7280;display:flex;align-items:center;justify-content:center;transition:background 150ms;}
.znp-auth-v13 .znp-modal-topclose:hover {background:#e5e7eb;color:#111827;}
.znp-auth-v13 .znp-modal-icon-wrap {width:76px;height:76px;border-radius:50%;background:linear-gradient(135deg,#e8effe,#dbeafe);display:inline-flex;align-items:center;justify-content:center;margin-bottom:18px;position:relative;}
.znp-auth-v13 .znp-modal-icon-wrap::before {content:'';position:absolute;inset:-6px;border-radius:50%;border:2px solid rgba(59,130,246,.18);}
.znp-auth-v13 .znp-check {width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#1a3faa);box-shadow:0 8px 24px rgba(37,99,235,.3);display:inline-grid;place-items:center;}
.znp-auth-v13 .znp-check svg {width:26px;height:26px;stroke:#fff;stroke-width:2.5;fill:none;}
.znp-auth-v13 .znp-check .chkpath {stroke-dasharray:48;stroke-dashoffset:48;animation:znpChkDraw 400ms ease forwards 200ms;}
.znp-auth-v13 .znp-modal-content h3 {margin:0 0 8px;font-size:20px;font-weight:800;color:#0f172a;font-family:var(--font);}
.znp-auth-v13 .znp-modal-content .znp-modal-msg {font-size:13.5px;color:#475569;line-height:1.6;margin:0 0 24px;}
.znp-auth-v13 .znp-modal-cta {display:block;width:100%;padding:13px 0;background:linear-gradient(135deg,#2563eb,#1a3faa);color:#fff;font-weight:700;font-size:14px;border:none;border-radius:12px;cursor:pointer;margin-bottom:20px;transition:opacity 150ms;font-family:var(--font);}
.znp-auth-v13 .znp-modal-cta:hover {opacity:.9;}
.znp-auth-v13 .znp-modal-bar-wrap {height:3px;background:#f1f5f9;position:absolute;bottom:0;left:0;right:0;}
.znp-auth-v13 .znp-modal-bar {height:100%;background:linear-gradient(90deg,#2563eb,#60a5fa);width:100%;transform-origin:left;animation:znpBarShrink var(--znp-bar-dur,6s) linear forwards;}
.znp-auth-v13 .znp-modal.paused .znp-modal-bar {animation-play-state:paused;}
@keyframes znpFadeUp {from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
@keyframes znpChkDraw {to{stroke-dashoffset:0;}}
@keyframes znpBarShrink {to{transform:scaleX(0);}}
@media (max-width:640px) {
    .znp-auth-v13 .wrap {padding:16px 12px 48px;}
    .znp-auth-v13 .pnl {padding:20px 18px 24px;}
    .znp-auth-v13 .g2,.znp-auth-v13 .g3,.znp-auth-v13 .g4 {grid-template-columns:1fr;gap:12px;}
    .znp-auth-v13 .nopts {grid-template-columns:1fr;gap:8px;}
    .znp-auth-v13 .socg {grid-template-columns:1fr;}
    .znp-auth-v13 .props {flex-wrap:wrap;}
    .znp-auth-v13 .prop {flex:1 1 calc(50% - 1px);}
    .znp-auth-v13 .prop:nth-child(2) {border-right:none;}
    .znp-auth-v13 .prop:nth-child(3),.znp-auth-v13 .prop:nth-child(4) {border-top:1px solid var(--border);}
    .znp-auth-v13 .prop:nth-child(4) {border-right:none;}
    .znp-auth-v13 .top h1 {font-size:18px;}
    .znp-auth-v13 .slbl {display:none;}
    .znp-auth-v13 .sln {margin:0 4px;}
}
</style>
@endpush

@section('content')
@include('znp.header')

<div class="znp-auth-v13">
  <div class="wrap">

    <div class="top">
      <div class="top-eyebrow">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        India's exclusive zero-notice talent portal
      </div>
      <h1>Ready to join immediately? <em>Sign up now!</em></h1>
      {{-- <p>Connect with employers who need to hire fast — zero wait, zero notice.</p> --}}
    </div>

    <div class="props">
      <div class="prop"><div class="pdot" style="background:#3B5CCC"></div><span>Instant Matching</span></div>
      <div class="prop"><div class="pdot" style="background:#7c3aed"></div><span>Verified Employers</span></div>
      <div class="prop"><div class="pdot" style="background:#3B5CCC"></div><span>Privacy First</span></div>
      <div class="prop"><div class="pdot" style="background:#F2994A"></div><span>Always Free</span></div>
    </div>

    <div class="card">
      <div class="tabs">
        <button class="tab on" id="tsu" onclick="swTab('su')">Create account</button>
        <button class="tab" id="tsi" onclick="swTab('si')">Sign in</button>
      </div>

      {{-- ── SIGN UP PANEL ── --}}
      <div class="pnl on" id="psu">

        {{-- Success modal --}}
        @if(session('new_message'))
          <div id="znp-success-modal" class="znp-modal" role="dialog" aria-modal="true">
            <div class="znp-modal-overlay" onclick="jsaCloseSuccessModal()"></div>
            <div class="znp-modal-content" role="document">
              <button class="znp-modal-topclose" aria-label="Close" onclick="jsaCloseSuccessModal()">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                  <line x1="1" y1="1" x2="11" y2="11"/><line x1="11" y1="1" x2="1" y2="11"/>
                </svg>
              </button>
              <div class="znp-modal-icon-wrap">
                <div class="znp-check" aria-hidden="true">
                  <svg viewBox="0 0 24 24"><polyline class="chkpath" points="20 6 9 17 4 12"></polyline></svg>
                </div>
              </div>
              <h3>You're registered!</h3>
              <p class="znp-modal-msg">{!! session('new_message') !!}</p>
              <button id="jsa-success-close" class="znp-modal-cta">Continue to Sign In</button>
              <div class="znp-modal-bar-wrap"><div class="znp-modal-bar" id="jsa-modal-bar"></div></div>
            </div>
          </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="jsa-signup-form">
          @csrf
          <input type="hidden" name="_from_signup" value="1">
          <input type="hidden" name="nop_days" id="nop_days_hidden" value="{{ old('nop_days', 1) }}">
          <div id="keyskills-hidden-wrap"></div>
          <div id="prefcity-hidden-wrap"></div>

          {{-- Step indicator --}}
          <div class="steps">
            <div class="st"><div class="snum a" id="n1" onclick="stepClick(1)" style="cursor:pointer">1</div><div class="slbl a" id="l1">Your details</div></div>
            <div class="sln" id="ln1"></div>
            <div class="st"><div class="snum i" id="n2" onclick="stepClick(2)">2</div><div class="slbl i" id="l2">Professional</div></div>
            <div class="sln" id="ln2"></div>
            <div class="st"><div class="snum i" id="n3" onclick="stepClick(3)">3</div><div class="slbl i" id="l3">CV &amp; password</div></div>
          </div>

          {{-- ─── STEP 1: Your details ─── --}}
          <div id="s1">
            <div class="social-banner" id="social-banner">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              <span id="social-banner-text">Signed in with Google — name &amp; email pre-filled.</span>
              <span class="social-banner-r" onclick="clearSocial()">Use email instead ×</span>
            </div>

            @if ($errors->any() && old('_from_signup'))
              <div class="znp-alert znp-alert-error">
                <div><strong>Please update the following:</strong>
                  <ul style="margin:6px 0 0 16px;padding:0;">
                    @foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                  </ul>
                </div>
              </div>
            @endif

            <div class="sec"><span class="secbar"></span>Notice period status</div>
            <div class="nopts">
              <div class="nopt on" id="npi" onclick="setN('i')">
                <div class="nlbl">Immediate joiner</div>
                <div class="nsub">Available to start right away</div>
              </div>
              <div class="nopt" id="nps" onclick="setN('s')">
                <div class="nlbl">Serving notice</div>
                <div class="nsub">Last day within 90 days</div>
              </div>
              <div class="nopt" id="npf" onclick="setN('f')">
                <div class="nlbl">Fresher</div>
                <div class="nsub">No prior employment</div>
              </div>
            </div>

            <div class="g2" style="margin-bottom:14px">
              <div class="f" style="margin-bottom:0">
                <label class="lbl" id="lwdlbl">Last working date <span class="req">*</span></label>
                <input type="date" name="immediate_last_date" id="lwdinp"
                  value="{{ (string)old('nop_days') === '2' ? old('last_working_day') : old('immediate_last_date') }}"
                       class="{{ $errors->has('immediate_last_date') ? 'is-invalid' : '' }}">
                <span class="hint" id="lwdhint">Must be today or earlier</span>
                @if($errors->has('immediate_last_date'))<span class="hint er">{{ $errors->first('immediate_last_date') }}</span>@endif
                @if($errors->has('last_working_day'))<span class="hint er">{{ $errors->first('last_working_day') }}</span>@endif
              </div>
              <div class="f" style="margin-bottom:0" id="proofrow">
                <label class="lbl" id="prooflbl">Proof of last working date <span class="req">*</span></label>
                <select name="lwd_proof" class="{{ $errors->has('lwd_proof') ? 'is-invalid' : '' }}">
                  <option value="">Select proof</option>
                  <option value="Resignation Acceptance Mail" {{ old('lwd_proof')=='Resignation Acceptance Mail'?'selected':'' }}>Resignation acceptance email</option>
                  <option value="Relieving Letter" {{ old('lwd_proof')=='Relieving Letter'?'selected':'' }}>Relieving letter</option>
                  <option value="EPFO Service History" {{ old('lwd_proof')=='EPFO Service History'?'selected':'' }}>EPFO service history</option>
                </select>
              </div>
            </div>

            <div class="sec"><span class="secbar"></span>Personal details</div>
            <div class="g3" style="margin-bottom:14px">
              <div class="f" style="margin-bottom:0">
                <label class="lbl">First name <span class="req">*</span></label>
                <input type="text" name="first_name" id="fn" placeholder="First name"
                       value="{{ old('first_name') }}" onblur="titleCase(this)"
                       class="{{ $errors->has('first_name') ? 'is-invalid' : '' }}">
                @if($errors->has('first_name'))<span class="hint er">{{ $errors->first('first_name') }}</span>@endif
              </div>
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Last name <span class="req">*</span></label>
                <input type="text" name="last_name" id="ln" placeholder="Last name"
                       value="{{ old('last_name') }}" onblur="titleCase(this)"
                       class="{{ $errors->has('last_name') ? 'is-invalid' : '' }}">
                @if($errors->has('last_name'))<span class="hint er">{{ $errors->first('last_name') }}</span>@endif
              </div>
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Date of birth <span class="req">*</span></label>
                <input type="date" name="date_of_birth" id="dob" value="{{ old('date_of_birth') }}"
                       class="{{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}">
                @if($errors->has('date_of_birth'))<span class="hint er">{{ $errors->first('date_of_birth') }}</span>@endif
              </div>
            </div>
            <div class="gap9"></div>
            <div class="g3" style="margin-bottom:14px">
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Email address <span class="req">*</span></label>
                <input type="email" name="email" id="em" placeholder="yourname@email.com"
                       value="{{ old('email') }}" oninput="chkEm(this)"
                       class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                <div class="emst" id="emst">@if($errors->has('email'))<span style="color:#dc2626">{{ $errors->first('email') }}</span>@endif</div>
              </div>
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Mobile number <span class="req">*</span></label>
                <div class="phw">
                  <div class="phcode">+91</div>
                  <input class="phinp" type="tel" name="phone" maxlength="10"
                         placeholder="10-digit number" value="{{ old('phone') }}">
                </div>
                @if($errors->has('phone'))<span class="hint er">{{ $errors->first('phone') }}</span>@endif
              </div>
              <div class="f" style="margin-bottom:0">
                <label class="lbl">LinkedIn <span class="opt-lbl">(optional)</span></label>
                <div class="pfx">
                  <div class="pfx-lbl">linkedin.com/in/</div>
                  <input class="pfx-inp" type="text" name="linkedin_url" id="liinp"
                         placeholder="your-profile" oninput="cleanLI(this)"
                         value="{{ old('linkedin_url') }}">
                </div>
              </div>
            </div>

            <div class="sec"><span class="secbar"></span>Education</div>
            <div class="g3" style="margin-bottom:14px">
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Education status <span class="req">*</span></label>
                <select name="education_status" id="edu-status"
                        class="{{ $errors->has('education_status') ? 'is-invalid' : '' }}">
                  <option value="">Select status</option>
                  <option value="Completed"    {{ old('education_status')=='Completed'   ?'selected':'' }}>Completed</option>
                  <option value="Pursuing"     {{ old('education_status')=='Pursuing'    ?'selected':'' }}>Pursuing</option>
                  <option value="Discontinued" {{ old('education_status')=='Discontinued'?'selected':'' }}>Discontinued</option>
                </select>
                @if($errors->has('education_status'))<span class="hint er">{{ $errors->first('education_status') }}</span>@endif
              </div>
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Highest education <span class="req">*</span></label>
                <select name="degree_title" id="degree_title_select"
                        class="{{ $errors->has('degree_title') ? 'is-invalid' : '' }}"
                        onchange="jsaDegreeChange(this.value)">
                  <option value="">Select qualification</option>
                  @foreach($educations as $edu)
                    <option value="{{ $edu->id }}" {{ old('degree_title')==$edu->id?'selected':'' }}>{{ $edu->education }}</option>
                  @endforeach
                </select>
                @if($errors->has('degree_title'))<span class="hint er">{{ $errors->first('degree_title') }}</span>@endif
              </div>
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Year of completion <span class="req">*</span></label>
                <select name="year_of_completion" id="edu-year"
                        class="{{ $errors->has('year_of_completion') ? 'is-invalid' : '' }}">
                  <option value="">Select year</option>
                </select>
                @if($errors->has('year_of_completion'))<span class="hint er">{{ $errors->first('year_of_completion') }}</span>@endif
              </div>
            </div>

            <div id="course-spec-row" style="{{ in_array(old('degree_title'), ['2','3','4']) ? '' : 'display:none;' }}">
              <div class="g2" style="margin-bottom:14px">
                <div class="f" style="margin-bottom:0">
                  <label class="lbl">Course <span class="req">*</span></label>
                  <select name="course" id="course_select"
                          class="{{ $errors->has('course') ? 'is-invalid' : '' }}"
                          onchange="jsaCourseChange(this.value)">
                    <option value="">Select course</option>
                  </select>
                  @if($errors->has('course'))<span class="hint er">{{ $errors->first('course') }}</span>@endif
                </div>
                <div class="f" style="margin-bottom:0">
                  <label class="lbl">Specialization <span class="req">*</span></label>
                  <select name="specilation" id="specilation_select"
                          class="{{ $errors->has('specilation') ? 'is-invalid' : '' }}">
                    <option value="">Select specialization</option>
                  </select>
                  @if($errors->has('specilation'))<span class="hint er">{{ $errors->first('specilation') }}</span>@endif
                </div>
              </div>
              <div class="f" style="margin-bottom:14px">
                <label class="lbl">University / College <span class="req">*</span></label>
                <input type="text" id="jsa-university-input" name="organization"
                       placeholder="Search university / college"
                       value="{{ old('organization') }}" autocomplete="off"
                       class="{{ $errors->has('organization') ? 'is-invalid' : '' }}">
                @if($errors->has('organization'))<span class="hint er">{{ $errors->first('organization') }}</span>@endif
              </div>
            </div>

            <div class="errbox" id="s1err"><strong style="font-size:12.5px;color:#dc2626">Please update before continuing:</strong><ul id="s1erl"></ul></div>
            <button type="button" class="btn btnb" onclick="valS1()">Continue — professional details →</button>
            <div class="terms">By continuing you agree to our <a href="{{ url('terms-and-conditons') }}" target="_blank" rel="noopener noreferrer">Terms of Service</a> &amp; <a href="{{ url('privacy-policy') }}" target="_blank" rel="noopener noreferrer">Privacy Policy</a></div>
          </div>
          {{-- end step 1 --}}

          {{-- ─── STEP 2: Professional ─── --}}
          <div id="s2" style="display:none">
            <div id="frnote">You selected <strong>Fresher</strong> (no prior full-time role yet — internships are fine). Use CTC fields for stipend or internship pay if applicable, and describe any internship or project work in your title, company, and skills below.</div>

            <div class="sec"><span class="secbar"></span>Professional details</div>
            <div class="g2" id="wfields" style="margin-bottom:14px">
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Current / last job title <span class="req">*</span></label>
                <input type="text" name="latestdesg" id="s2t" placeholder="e.g. Senior .NET Developer"
                       value="{{ old('latestdesg') }}" onblur="titleCase(this)"
                       class="{{ $errors->has('latestdesg') ? 'is-invalid' : '' }}">
                @if($errors->has('latestdesg'))<span class="hint er">{{ $errors->first('latestdesg') }}</span>@endif
              </div>
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Current / last company <span class="req">*</span></label>
                <input type="text" id="jsa-company-input" name="latestcom" placeholder="Company name"
                       value="{{ old('latestcom') }}" onblur="titleCase(this)" autocomplete="off"
                       class="{{ $errors->has('latestcom') ? 'is-invalid' : '' }}">
                @if($errors->has('latestcom'))<span class="hint er">{{ $errors->first('latestcom') }}</span>@endif
              </div>
            </div>
            <div class="gap9"></div>
            <div class="g2" style="margin-bottom:14px">
              <div class="f" style="margin-bottom:0" id="exprow">
                <label class="lbl">Experience (years.months) <span class="req">*</span></label>
                <input type="number" id="s2exp" min="0" max="40" step="0.1" placeholder="e.g. 6.9"
                       value="{{ old('totalexp') !== null && old('totalexp') !== '' ? (old('totalexpmonth') ? old('totalexp').'.'.old('totalexpmonth') : old('totalexp')) : '' }}">
                <input type="hidden" name="totalexp" id="s2exp_yr" value="{{ old('totalexp', '') }}">
                <input type="hidden" name="totalexpmonth" id="s2exp_mo" value="{{ old('totalexpmonth', '') }}">
                <span class="hint" id="exphint-fr" style="display:none">Use decimals for months after the dot — e.g. 2.6 = 2 years 6 months; 0.6 = 6 months.</span>
                @if($errors->has('totalexp'))<span class="hint er">{{ $errors->first('totalexp') }}</span>@endif
              </div>
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Industry / domain <span class="req">*</span></label>
                <select id="s2dom" name="industry_domain" onchange="loadSugg(this.value)"
                        class="{{ $errors->has('industry_domain') ? 'is-invalid' : '' }}">
                  <option value="">Select domain</option>
                  <option value="it">Information Technology</option>
                  <option value="bfs">Banking &amp; Financial Services</option>
                  <option value="health">Healthcare &amp; Pharma</option>
                  <option value="ecom">E-commerce &amp; Retail</option>
                  <option value="mfg">Manufacturing</option>
                  <option value="consult">Consulting</option>
                  <option value="edu">Education &amp; EdTech</option>
                  <option value="startup">Startup / Product</option>
                  <option value="other">Other</option>
                </select>
                @if($errors->has('industry_domain'))<span class="hint er">{{ $errors->first('industry_domain') }}</span>@endif
              </div>
            </div>

            <div class="g2" id="ctcrow" style="margin-bottom:14px">
              <div class="f" style="margin-bottom:0">
                <label class="lbl" id="ctc-cur-lbl">Current annual CTC <span class="req">*</span></label>
                <div class="pfx {{ $errors->has('expect_ctc_lakhs') ? 'is-invalid' : '' }}">
                  <div class="pfx-lbl">₹ L</div>
                  <input class="pfx-inp" type="text" name="expect_ctc_lakhs" id="s2ctc" placeholder="e.g. 12.9"
                         value="{{ old('expect_ctc_lakhs') }}" oninput="fmtLakhs(this)">
                </div>
                <input type="hidden" name="expect_ctc_thousand" id="s2ctc_th" value="{{ old('expect_ctc_thousand', 0) }}">
                <span class="hint">Enter in lakhs — e.g. 12.9 means ₹12,90,000</span>
                @if($errors->has('expect_ctc_lakhs'))<span class="hint er">{{ $errors->first('expect_ctc_lakhs') }}</span>@endif
              </div>
              <div class="f" style="margin-bottom:0">
                <label class="lbl" id="ctc-exp-lbl">Expected annual CTC <span class="req">*</span></label>
                <div class="pfx {{ $errors->has('expect_ctc_lakhs3') ? 'is-invalid' : '' }}">
                  <div class="pfx-lbl">₹ L</div>
                  <input class="pfx-inp" type="text" name="expect_ctc_lakhs3" id="s2ectc" placeholder="e.g. 18.5"
                         value="{{ old('expect_ctc_lakhs3') }}" oninput="fmtLakhs(this)">
                </div>
                <input type="hidden" name="expect_ctc_thousand3" id="s2ectc_th" value="{{ old('expect_ctc_thousand3', 0) }}">
                <span class="hint">Enter in lakhs — e.g. 18.5 means ₹18,50,000</span>
                @if($errors->has('expect_ctc_lakhs3'))<span class="hint er">{{ $errors->first('expect_ctc_lakhs3') }}</span>@endif
              </div>
            </div>
            <div class="gap9"></div>

            <div class="f">
              <label class="lbl">Key skills <span class="req">*</span><span id="skct" style="margin-left:auto;font-size:11px;font-weight:500;color:var(--text-4)">0 / 10 min</span></label>
              <div class="skwrap">
                <div class="skbox" id="sktags"></div>
                <div class="skinpw">
                  <input class="skinp" type="text" id="skinp"
                         placeholder="Type a skill + Enter, or pick from suggestions below…"
                         onkeydown="skKey(event)" 
                         oninput="handleSkillsInput(this.value)"
                         autocomplete="off">
                  <div class="skdd" id="skdd"></div>
                </div>
              </div>
              <div style="font-size:11px;color:var(--text-4);margin:8px 0 4px;font-weight:500">Suggestions for your domain</div>
              <div class="sksugg" id="sksugg"></div>
              <div class="skprog-wrap">
                <div class="skprog-meta"><span>Skills progress</span><span id="skpct">0%</span></div>
                <div class="skprog"><div class="skfill" id="skbar" style="width:0%"></div></div>
              </div>
              @if($errors->has('keyskills'))<span class="hint er">{{ $errors->first('keyskills') }}</span>@endif
            </div>

            <div class="sec"><span class="secbar"></span>Location &amp; preferences</div>
            <div class="g2" style="margin-bottom:14px">
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Current city <span class="req">*</span></label>
                <input type="text" id="jsa-city-input" name="current_city" placeholder="e.g. Mumbai"
                       value="{{ old('current_city') }}" autocomplete="off" onblur="capitalizeFirst(this)"
                       class="{{ $errors->has('current_city') ? 'is-invalid' : '' }}">
                @if($errors->has('current_city'))<span class="hint er">{{ $errors->first('current_city') }}</span>@endif
              </div>
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Locality <span class="req">*</span></label>
                <input type="text" id="jsa-locality-input" name="locality" placeholder="e.g. Andheri East"
                       value="{{ old('locality') }}" autocomplete="off" onblur="capitalizeFirst(this)"
                       class="{{ $errors->has('locality') ? 'is-invalid' : '' }}">
                @if($errors->has('locality'))<span class="hint er">{{ $errors->first('locality') }}</span>@endif
              </div>
            </div>

            <div class="f">
              <label class="lbl">Preferred cities <span class="req">*</span><span id="cyct" style="margin-left:auto;font-size:11px;font-weight:500;color:var(--text-4)">0 / 3</span></label>
              <div class="pills" id="cypills">
                <span class="pill {{ in_array('Bengaluru',(array)old('prefered_city',[]))?'on':'' }}" onclick="togCity(this,'Bengaluru')">Bengaluru</span>
                <span class="pill {{ in_array('Hyderabad',(array)old('prefered_city',[]))?'on':'' }}" onclick="togCity(this,'Hyderabad')">Hyderabad</span>
                <span class="pill {{ in_array('Mumbai',(array)old('prefered_city',[]))?'on':'' }}" onclick="togCity(this,'Mumbai')">Mumbai</span>
                <span class="pill {{ in_array('Chennai',(array)old('prefered_city',[]))?'on':'' }}" onclick="togCity(this,'Chennai')">Chennai</span>
                <span class="pill {{ in_array('Delhi',(array)old('prefered_city',[]))?'on':'' }}" onclick="togCity(this,'Delhi')">Delhi</span>
                <span class="pill {{ in_array('Pune',(array)old('prefered_city',[]))?'on':'' }}" onclick="togCity(this,'Pune')">Pune</span>
                <span class="pill {{ in_array('Gurgaon',(array)old('prefered_city',[]))?'on':'' }}" onclick="togCity(this,'Gurgaon')">Gurgaon</span>
                <span class="pill {{ in_array('Kolkata',(array)old('prefered_city',[]))?'on':'' }}" onclick="togCity(this,'Kolkata')">Kolkata</span>
                <span class="pill {{ in_array('Remote / WFH',(array)old('prefered_city',[]))?'on':'' }}" onclick="togCity(this,'Remote / WFH')">Remote / WFH</span>
              </div>
              <div style="display:flex;gap:6px;margin-top:8px">
                <input type="text" id="cityinp" placeholder="Any other city — press Enter to add"
                       onblur="capitalizeFirst(this)" onkeydown="if(event.key==='Enter'){event.preventDefault();addCity()}"
                       style="max-width:280px">
              </div>
              <div class="cylimlbl" id="cylim">Max 3 cities — remove one to add another.</div>
              <span class="hint" style="margin-top:4px">Select up to 3 cities you're open to working in</span>
            </div>

            <div class="f">
              <label class="lbl">Preferred work mode <span class="req">*</span></label>
              <div class="pills">
                <span class="pill {{ old('work_option')=='WFO'   ?'on':'' }}" onclick="togP(this,'work_option','WFO')">Work from office</span>
                <span class="pill {{ old('work_option')=='Hybrid'?'on':'' }}" onclick="togP(this,'work_option','Hybrid')">Hybrid</span>
                <span class="pill {{ old('work_option')=='Remote'?'on':'' }}" onclick="togP(this,'work_option','Remote')">Remote</span>
                <span class="pill {{ old('work_option')=='Flexible'?'on':'' }}" onclick="togP(this,'work_option','Flexible')">Flexible</span>
                {{-- <span class="pill {{ old('work_option')=='Open to all'?'on':'' }}" onclick="togP(this,'work_option','Open to all')">Open to all</span> --}}
              </div>
              <input type="hidden" name="work_option" id="work_option_hidden" value="{{ old('work_option','') }}">
              @if($errors->has('work_option'))<span class="hint er">{{ $errors->first('work_option') }}</span>@endif
            </div>
            <div class="f">
              <label class="lbl">Preferred job type <span class="req">*</span></label>
              <div class="pills">
                <span class="pill {{ old('work_type')=='Full Time'  ?'on':'' }}" onclick="togP(this,'work_type','Full Time')">Permanent</span>
                <span class="pill {{ old('work_type')=='Contract'   ?'on':'' }}" onclick="togP(this,'work_type','Contract')">Contract</span>
                <span class="pill {{ old('work_type')=='Open to both'?'on':'' }}" onclick="togP(this,'work_type','Open to both')">Open to both</span>
              </div>
              <input type="hidden" name="work_type" id="work_type_hidden" value="{{ old('work_type','') }}">
              @if($errors->has('work_type'))<span class="hint er">{{ $errors->first('work_type') }}</span>@endif
            </div>
            <div class="g2" style="margin-bottom:4px">
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Mode of separation <span class="req">*</span></label>
                <select name="mode_of_separation" id="modesep"
                        class="{{ $errors->has('mode_of_separation') ? 'is-invalid' : '' }}" required>
                  <option value="">Select reason for leaving</option>
                  <option value="Resignation"      {{ old('mode_of_separation')=='Resignation'     ?'selected':'' }}>Resignation</option>
                  <option value="Layoff"           {{ old('mode_of_separation')=='Layoff'          ?'selected':'' }}>Layoff</option>
                  <option value="Fresher"          {{ old('mode_of_separation')=='Fresher'         ?'selected':'' }}>Fresher — no prior full-time employment (internships OK)</option>
                  <option value="Contract Closure" {{ old('mode_of_separation')=='Contract Closure'?'selected':'' }}>Contract closure</option>
                  <option value="Internship Closure" {{ old('mode_of_separation')=='Internship Closure'?'selected':'' }}>Internship closure</option>
                </select>
                @if($errors->has('mode_of_separation'))<span class="hint er">{{ $errors->first('mode_of_separation') }}</span>@endif
              </div>
              <div class="f" style="margin-bottom:0">
                <label class="lbl">Gender <span class="req">*</span></label>
                <select name="gender_id" id="gender" class="{{ $errors->has('gender_id') ? 'is-invalid' : '' }}" required>
                  <option value="">Select gender</option>
                  <option value="1" {{ old('gender_id')=='1'?'selected':'' }}>Male</option>
                  <option value="2" {{ old('gender_id')=='2'?'selected':'' }}>Female</option>
                  {{-- <option value="3" {{ old('gender_id')=='3'?'selected':'' }}>Other</option> --}}
                  <option value="4" {{ old('gender_id')=='4'?'selected':'' }}>Prefer not to say</option>
                </select>
                @if($errors->has('gender_id'))<span class="hint er">{{ $errors->first('gender_id') }}</span>@endif
              </div>
            </div>

            <div class="errbox" id="s2err"><strong style="font-size:12.5px;color:#dc2626">Please update before continuing:</strong><ul id="s2erl"></ul><div style="font-size:11px;color:#f87171;margin-top:4px">Your data is saved — nothing was lost.</div></div>
            <div class="brow"><button type="button" class="bback" onclick="goStep(1)">← Back</button><button type="button" class="btn btnb" style="margin-top:0" onclick="valS2()">Continue — CV &amp; password →</button></div>
          </div>
          {{-- end step 2 --}}

          {{-- ─── STEP 3: CV & Password ─── --}}
          <div id="s3" style="display:none">
            <div class="sec"><span class="secbar"></span>Upload your CV <span class="req">*</span></div>
            <div class="f">
              <div class="upload" onclick="document.getElementById('cvmain').click()" style="padding:24px">
                <div class="upload-ico">
                  <svg width="22" height="22" fill="none" stroke="#3B5CCC" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="11" x2="12" y2="17"/><polyline points="9 14 12 11 15 14"/></svg>
                </div>
                <div class="ut"><b>Click to upload your CV</b></div>
                <div class="ut-sub">PDF, DOC or DOCX · Max 2MB</div>
                <input type="file" id="cvmain" name="resume" style="display:none"
                       accept=".pdf,.doc,.docx" onchange="readCV(this)">
              </div>
              <div id="cvok"></div>
              <span class="hint" style="margin-top:6px">Visible only to employers you apply to or explicitly approve.</span>
              @if($errors->has('resume'))<span class="hint er">{{ $errors->first('resume') }}</span>@endif
            </div>

            <div class="priv">
              <input type="checkbox" id="hidecv" name="hide_cv_from_current_employer" value="1" {{ old('hide_cv_from_current_employer', 1) ? 'checked' : '' }}>
              <label for="hidecv">Hide my CV from my current employer</label>
            </div>

            <div class="sec"><span class="secbar"></span>Set a password</div>
            <div class="f">
              <label class="lbl">Password <span class="req">*</span></label>
              <span class="hint" style="margin-bottom:2px">Min. 8 characters — strength indicator below.</span>
              <div class="pw-wrap">
                <input type="password" name="password" id="pw" placeholder="Min. 8 characters"
                       oninput="chkPW(this.value)"
                       class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                <button type="button" class="pw-tog" onclick="jsaTogglePw('pw',this)">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              <div class="pwbars"><div class="pwb" id="pb1"></div><div class="pwb" id="pb2"></div><div class="pwb" id="pb3"></div><div class="pwb" id="pb4"></div></div>
              <span class="hint" id="pwhint">Use letters, numbers and a symbol</span>
              @if($errors->has('password'))<span class="hint er">{{ $errors->first('password') }}</span>@endif
            </div>
            <div class="f">
              <label class="lbl">Confirm password <span class="req">*</span></label>
              <div class="pw-wrap">
                <input type="password" name="password_confirmation" id="pwc" placeholder="Re-enter password"
                       class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}">
                <button type="button" class="pw-tog" onclick="jsaTogglePw('pwc',this)">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              @if($errors->has('password_confirmation'))<span class="hint er">{{ $errors->first('password_confirmation') }}</span>@endif
            </div>

            <div class="priv" style="margin-top:14px;align-items:flex-start;gap:11px;background:transparent;border-color:var(--border)">
              <input type="checkbox" checked id="accuracyCheck" name="accuracy_confirmed" value="1"
                     {{ old('accuracy_confirmed', 1) ? 'checked' : '' }}
                     style="margin-top:3px;accent-color:#3B5CCC;width:15px;height:15px;flex-shrink:0;cursor:pointer" required>
              <label for="accuracyCheck" style="font-size:12px;color:var(--text-4);font-weight:400;line-height:1.7;cursor:pointer">
                I confirm that the details I've shared are accurate. I understand profiles with inaccurate notice period information may be deactivated.
              </label>
            </div>

            <div style="margin-top:14px;padding:13px 16px;background:var(--surface-2);border:1px solid var(--border);border-radius:var(--r-sm)">
              <div style="font-size:11.5px;color:var(--text-3);line-height:1.8">
                By creating your account you agree to ZeroNoticePeriod's
                <a href="#" style="color:#3B5CCC;text-decoration:none;font-weight:600">Terms of Service</a> and
                <a href="#" style="color:#3B5CCC;text-decoration:none;font-weight:600">Privacy Policy</a>.
                You consent to receiving job match alerts by email. You can unsubscribe at any time.
              </div>
              <div class="optgrid">
                <label class="optcheck">
                  <input type="checkbox" checked name="terms_of_use" value="1" {{ old('terms_of_use')?'checked':'' }} required style="accent-color:#3B5CCC;width:13px;height:13px;cursor:pointer">
                  I agree to Terms &amp; Conditions <span style="color:#F2994A">*</span>
                </label>
                <label class="optcheck">
                  <input type="checkbox" name="pref_job_alerts" value="1" {{ old('pref_job_alerts', 1) ? 'checked' : '' }} checked style="accent-color:#3B5CCC;width:13px;height:13px;cursor:pointer"> Job match &amp; application alerts
                </label>
                <label class="optcheck">
                  <input type="checkbox" name="pref_platform_tips" value="1" {{ old('pref_platform_tips', 1) ? 'checked' : '' }} checked style="accent-color:#3B5CCC;width:13px;height:13px;cursor:pointer"> Platform tips, feature updates
                </label>
                <label class="optcheck">
                  <input type="checkbox" name="pref_promotions" value="1" {{ old('pref_promotions', 1) ? 'checked' : '' }} checked style="accent-color:#3B5CCC;width:13px;height:13px;cursor:pointer"> Promotions
                </label>
              </div>
              @if($errors->has('terms_of_use'))<div class="hint er" style="margin-top:6px">{{ $errors->first('terms_of_use') }}</div>@endif
            </div>

            <div class="brow">
              <button type="button" class="bback" onclick="goStep(2)">← Back</button>
              <button type="button" class="btn btng" style="margin-top:0" onclick="submitForm()">Create account &amp; find jobs →</button>
            </div>
            <div class="terms">By continuing you agree to our <a href="{{ url('/terms-and-conditons') }}" target="_blank">Terms of service</a> &amp; <a href="{{ url('/privacy-policy') }}" target="_blank">Privacy policy</a></div>
          </div>
          {{-- end step 3 --}}

          {{-- Verify screen --}}
          <div id="sverify" style="display:none;padding-top:0">
            <div class="verbox">
              <div style="width:52px;height:52px;background:var(--surface-2);border:1px solid rgba(59,92,204,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
                <svg width="22" height="22" fill="none" stroke="#3B5CCC" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              </div>
              <div style="font-size:18px;font-weight:700;color:var(--text);margin-bottom:6px;letter-spacing:-.3px">Check your inbox</div>
              <div style="font-size:13.5px;color:var(--text-3);line-height:1.7;margin-bottom:16px">
                We've sent a verification link to <strong id="vemail" style="color:#3B5CCC"></strong>.<br><br>
                Click the link to activate your account and start applying to jobs.
              </div>
              <button class="btn btnb" style="margin-top:0" onclick="swTab('si')">Go to sign in →</button>
            </div>
          </div>

        </form>
      </div>
      {{-- end sign-up panel --}}

      {{-- ── SIGN IN PANEL ── --}}
      <div class="pnl" id="psi">
        @if(session('error_message1'))
          <div class="znp-alert znp-alert-error">{{ session('error_message1') }}</div>
        @endif
        @if(session('error_message'))
          <div class="znp-alert znp-alert-error">{{ session('error_message') }}</div>
        @endif
        @if(session('verify_message'))
          <div class="znp-alert znp-alert-error">{!! session('verify_message') !!}</div>
        @endif

        <div style="text-align:center;margin-bottom:22px">
          <div style="font-size:17px;font-weight:700;color:var(--text);letter-spacing:-.3px;margin-bottom:5px">Welcome back</div>
          <div style="font-size:13.5px;color:var(--text-3)">Sign in to your jobseeker account</div>
        </div>

        <form method="POST" action="{{ route('login') }}" id="jsa-signin-form">
          @csrf
          <div class="f">
            <label class="lbl">Email address <span class="req">*</span></label>
            <input type="email" name="email" placeholder="yourname@email.com"
                   value="{{ old('email') }}"
                   class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required>
            @if($errors->has('email'))<span class="hint er">{{ $errors->first('email') }}</span>@endif
          </div>
          <div class="f">
            <label class="lbl" style="justify-content:space-between">
              Password <span class="req">*</span>
              <a href="{{ route('password.request') }}" style="font-size:11.5px;color:#3B5CCC;font-weight:500;text-decoration:none">Forgot password?</a>
            </label>
            <div class="pw-wrap">
              <input type="password" name="password" id="si-pw" placeholder="Enter password" required>
              <button type="button" class="pw-tog" onclick="jsaTogglePw('si-pw',this)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
          </div>
          <button type="submit" class="btn btnb">Sign in →</button>
        </form>

        <div class="alt-action" style="margin-top:14px;text-align:center;font-size:12px;color:var(--text-3)">
          Sign in as an Employer? <a href="{{ route('employer.login') }}" style="color:#3B5CCC;font-weight:600">Employer sign in</a>
        </div>
      </div>
      {{-- end sign-in panel --}}

      <div class="foot" id="foot">Already have an account? <a onclick="swTab('si')">Sign in here</a></div>
    </div>
    {{-- end card --}}

  </div>
</div>
{{-- end znp-auth-v13 --}}

@include('znp.footer')
@endsection

@push('scripts')
<script>
/* ─────────────────────────────────────────────────────────────────
   ZNP Jobseeker Auth v13 — all UI logic
   ───────────────────────────────────────────────────────────────── */
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    'X-Requested-With': 'XMLHttpRequest',
    Accept: 'application/json'
  }
});

/* ── Skill domain suggestions ── */
var SD = {
  it:      ['Java','Python','JavaScript','React','Node.js','SQL','AWS','Docker','Kubernetes','TypeScript','Angular'],
  bfs:     ['Excel','Financial Modelling','SQL','Python','Risk Analysis','IFRS','Credit Analysis','Bloomberg','Power BI'],
  health:  ['Clinical Research','Pharmacovigilance','Medical Writing','SAS','SPSS','GCP','Regulatory Affairs'],
  ecom:    ['SQL','Python','Google Analytics','A/B Testing','Tableau','Power BI','Product Management','Jira'],
  mfg:     ['AutoCAD','SolidWorks','SAP ERP','Six Sigma','Lean Manufacturing','Quality Control','Supply Chain'],
  consult: ['PowerPoint','Excel','Stakeholder Management','Project Management','Agile','Business Analysis'],
  edu:     ['Curriculum Design','LMS','eLearning','Instructional Design','Python','Public Speaking','Content Creation'],
  startup: ['Product Management','Agile','Jira','Figma','Growth Hacking','SQLite','NoSQL','CI/CD','Firebase','React'],
  other:   []
};

/* ── City preferred logic ── */
var selCities = [];
@if(old('prefered_city'))
  selCities = @json(old('prefered_city', []));
@endif

/* ── Skills state ── */
var jsaSkills = [];
@if(old('keyskills'))
  jsaSkills = @json(old('keyskills', []));
@endif

var emailCheckTimer = null;
var emailCheckXhr = null;
var emailExists = false;

window.clearSocial = function () {
  var banner = document.getElementById('social-banner');
  if (banner) banner.style.display = 'none';
};

/* ─── swTab: switch between create-account / sign-in ─── */
window.swTab = function (which) {
  var classes = { su: { on: 'psu', off: 'psi', ton: 'tsu', toff: 'tsi' },
                  si: { on: 'psi', off: 'psu', ton: 'tsi', toff: 'tsu' } };
  var c = classes[which];
  if (!c) return;
  document.getElementById(c.on).classList.add('on');
  document.getElementById(c.off).classList.remove('on');
  document.getElementById(c.ton).classList.add('on');
  document.getElementById(c.toff).classList.remove('on');
  var foot = document.getElementById('foot');
  if (foot) {
    if (which === 'su') {
      foot.innerHTML = 'Already have an account? <a onclick="swTab(\'si\')">Sign in here</a>';
    } else {
      foot.innerHTML = 'Don\'t have an account? <a onclick="swTab(\'su\')">Create one now</a>';
    }
  }
};

/* ─── goStep: multi-step navigation ─── */
var curStep = 1;
window.goStep = function (n) {
  [1, 2, 3].forEach(function (i) {
    var s = document.getElementById('s' + i);
    if (s) s.style.display = (i === n) ? '' : 'none';
    var num = document.getElementById('n' + i);
    var lbl = document.getElementById('l' + i);
    var ln  = document.getElementById('ln' + (i < 3 ? i : ''));
    if (num) {
      num.className = 'snum ' + (i < n ? 'd' : i === n ? 'a' : 'i');
      num.textContent = i < n ? '✓' : String(i);
    }
    if (lbl) lbl.className = 'slbl ' + (i < n ? 'd' : i === n ? 'a' : 'i');
    if (ln)  ln.className  = 'sln' + (i < n ? ' d' : '');
  });
  curStep = n;
  window.scrollTo({ top: 0, behavior: 'smooth' });
};

/* ─── stepClick: allow clicking back to already-completed steps ─── */
window.stepClick = function (n) {
  if (n < curStep) goStep(n);
};

/* ─── setN: notice period card selection ─── */
window.setN = function (type) {
  ['npi', 'nps', 'npf'].forEach(function (id) { document.getElementById(id).classList.remove('on'); });
  var today      = new Date().toISOString().split('T')[0];
  var maxServing = new Date(Date.now() + 90 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
  var maxFuture  = new Date(Date.now() + 5 * 365 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
  var lwdInp   = document.getElementById('lwdinp');
  var lwdLbl   = document.getElementById('lwdlbl');
  var lwdHint  = document.getElementById('lwdhint');
  var proofRow = document.getElementById('proofrow');
  var hidHid   = document.getElementById('nop_days_hidden');
  var frNote   = document.getElementById('frnote');
  var proofSel = document.querySelector('[name="lwd_proof"]');

  var expHintFr = document.getElementById('exphint-fr');
  var ctcCurLbl = document.getElementById('ctc-cur-lbl');
  if (type === 'i') {
    document.getElementById('npi').classList.add('on');
    if (hidHid)  hidHid.value = '1';
    if (lwdInp)  { lwdInp.name = 'immediate_last_date'; lwdInp.max = today; lwdInp.min = ''; lwdInp.style.display = ''; }
    if (lwdLbl)  lwdLbl.innerHTML = 'Last working date <span class="req">*</span>';
    if (lwdHint) lwdHint.textContent = 'Must be today or earlier';
    if (proofRow) proofRow.style.display = '';
    if (proofSel) proofSel.value = proofSel.value || '';
    if (frNote)  frNote.style.display = 'none';
    if (expHintFr) expHintFr.style.display = 'none';
    if (ctcCurLbl) ctcCurLbl.innerHTML = 'Current annual CTC <span class="req">*</span>';
    var modesepI = document.getElementById('modesep');
    if (modesepI && modesepI.value === 'Fresher') modesepI.value = '';
  } else if (type === 's') {
    document.getElementById('nps').classList.add('on');
    if (hidHid)  hidHid.value = '2';
    if (lwdInp)  { lwdInp.name = 'last_working_day'; lwdInp.max = maxServing; lwdInp.min = today; lwdInp.style.display = ''; }
    if (lwdLbl)  lwdLbl.innerHTML = 'Last day of notice <span class="req">*</span>';
    if (lwdHint) lwdHint.textContent = 'Must be a future date within 90 days';
    if (proofRow) proofRow.style.display = '';
    if (proofSel) proofSel.value = proofSel.value || '';
    if (frNote)  frNote.style.display = 'none';
    if (expHintFr) expHintFr.style.display = 'none';
    if (ctcCurLbl) ctcCurLbl.innerHTML = 'Current annual CTC <span class="req">*</span>';
    var modesepS = document.getElementById('modesep');
    if (modesepS && modesepS.value === 'Fresher') modesepS.value = '';
  } else {
    document.getElementById('npf').classList.add('on');
    if (hidHid)  hidHid.value = '3';
    if (lwdInp)  { lwdInp.name = 'immediate_last_date'; lwdInp.min = ''; lwdInp.max = maxFuture; lwdInp.style.display = ''; }
    if (lwdLbl)  lwdLbl.innerHTML = 'Course completion date <span class="req">*</span>';
    if (lwdHint) lwdHint.textContent = 'Expected graduation / course end date (required)';
    if (proofRow) proofRow.style.display = 'none';
    if (proofSel) proofSel.value = '';
    if (frNote)  frNote.style.display = '';
    if (expHintFr) expHintFr.style.display = '';
    if (ctcCurLbl) ctcCurLbl.innerHTML = 'Current annual CTC / stipend <span class="req">*</span>';
    var modesep = document.getElementById('modesep');
    if (modesep) modesep.value = 'Fresher';
  }
};

/* ─── chkEm: real-time email check ─── */
window.chkEm = function (inp) {
  var el = document.getElementById('emst');
  if (!el) return;
  var v = inp.value.trim();
  emailExists = false;
  if (emailCheckTimer) clearTimeout(emailCheckTimer);
  if (emailCheckXhr && emailCheckXhr.abort) emailCheckXhr.abort();
  if (!v) { el.innerHTML = ''; inp.classList.remove('is-invalid'); return; }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
    inp.classList.add('is-invalid');
    el.innerHTML = '<span style="color:#dc2626;font-size:11px">Invalid email format</span>';
    return;
  }
  inp.classList.remove('is-invalid');
  el.innerHTML = '<span style="color:#94a3b8;font-size:11px">Checking email…</span>';
  emailCheckTimer = setTimeout(function () {
    emailCheckXhr = $.ajax({
      type: 'POST',
      url: '{{ url("check-email") }}',
      dataType: 'json',
      data: { email: v, _token: '{{ csrf_token() }}' },
      success: function (data) {
        emailExists = !!(data && data.exists);
        if (emailExists) {
          inp.classList.add('is-invalid');
          el.innerHTML = '<span style="color:#dc2626;font-size:11px">This email is registered. Please sign in.</span>';
        } else {
          inp.classList.remove('is-invalid');
          el.innerHTML = '<span style="color:#16a34a;font-size:11px">✓ Looks good</span>';
        }
      },
      error: function () {
        el.innerHTML = '<span style="color:#94a3b8;font-size:11px">Could not verify email right now</span>';
      }
    });
  }, 350);
};

// Populate year of completion dropdown based on education status
window.populateEduYear = function (status, selected) {
  var yr = document.getElementById('edu-year');
  if (!yr) return;
  var thisYear = new Date().getFullYear();
  var html = '<option value="">Select year</option>';
  if (status === 'Pursuing') {
    for (var y = thisYear; y <= thisYear + 15; y++) html += '<option value="' + y + '">' + y + '</option>';
  } else {
    for (var y = thisYear + 5; y >= 1960; y--) html += '<option value="' + y + '">' + y + '</option>';
  }
  yr.innerHTML = html;
  if (selected) yr.value = selected;
};

// Re-populate year dropdown when education status changes
var _eduStatusEl = document.getElementById('edu-status');
if (_eduStatusEl) {
  _eduStatusEl.addEventListener('change', function () { populateEduYear(this.value); });
}

/* ─── cleanLI: strip full LinkedIn URL to just handle ─── */
window.cleanLI = function (inp) {
  inp.value = inp.value
    .replace(/^https?:\/\/(www\.)?linkedin\.com\/in\//i, '')
    .replace(/\/$/, '');
};

/* ─── fmtLakhs: CTC text input formatter (updates hidden thousands field) ─── */
window.fmtLakhs = function (inp) {
  // sanitize input: allow digits and at most one decimal digit; cap integer to 999
  if (!inp) return;
  var s = String(inp.value || '');
  s = s.replace(/[^0-9.]/g, '');
  var parts = s.split('.');
  if (parts.length > 1) {
    parts = [parts[0], parts.slice(1).join('')];
    parts[1] = parts[1].slice(0, 1); // only one decimal digit
  }
  var intPart = parts[0] ? parts[0].replace(/^0+(?=\d)/, '') : '0';
  if (intPart === '') intPart = '0';
  var intNum = parseInt(intPart, 10) || 0;
  if (intNum > 999) intNum = 999;
  parts[0] = String(intNum);
  s = parts.length > 1 ? parts[0] + '.' + parts[1] : parts[0];
  if (inp.value !== s) inp.value = s;
  var v = parseFloat(s);
  if (!isNaN(v) && v >= 0) {
    var name = inp.getAttribute('name');
    var thName = name === 'expect_ctc_lakhs' ? 'expect_ctc_thousand' : 'expect_ctc_thousand3';
    var hid = document.querySelector('[name="' + thName + '"]');
    if (hid) {
      var rs = Math.round(v * 100000);
      hid.value = Math.round((rs % 100000) / 1000);
    }
  }
};

// Validate experience input: allow integer up to 40 and a single decimal digit (years.months)
window.validateS2Exp = function (inp) {
  if (!inp) return;
  var s = String(inp.value || '');
  s = s.replace(/[^0-9.]/g, '');
  var parts = s.split('.');
  if (parts.length > 1) {
    parts = [parts[0], parts.slice(1).join('')];
    parts[1] = parts[1].slice(0, 1);
  }
  var intPart = parts[0] ? parts[0].replace(/^0+(?=\d)/, '') : '0';
  if (intPart === '') intPart = '0';
  var intNum = parseInt(intPart, 10) || 0;
  if (intNum > 40) intNum = 40;
  parts[0] = String(intNum);
  var out = parts.length > 1 ? parts[0] + '.' + parts[1] : parts[0];
  if (inp.value !== out) inp.value = out;
};

// Attach input listener for experience field (if present)
var _s2exp = document.getElementById('s2exp');
if (_s2exp) _s2exp.addEventListener('input', function () { validateS2Exp(this); });

/* ─── togP: exclusive pill selection for work mode / job type ─── */
window.togP = function (el, hidName, val) {
  var pills = el.closest('.pills');
  if (pills) pills.querySelectorAll('.pill').forEach(function (p) { p.classList.remove('on'); });
  el.classList.add('on');
  var hid = document.querySelector('[name="' + hidName + '"]');
  if (hid) hid.value = val;
};

/* ─── titleCase ─── */
window.titleCase = function (inp) {
  inp.value = inp.value.replace(/\w\S*/g, function (w) {
    return w.charAt(0).toUpperCase() + w.slice(1).toLowerCase();
  });
};

/* ─── capitalizeFirst: capitalize only first letter ─── */
window.capitalizeFirst = function (inp) {
  if (inp && inp.value) {
    inp.value = inp.value.charAt(0).toUpperCase() + inp.value.slice(1);
  }
};

/* ─── handleSkillsInput: main handler for skills input dropdown ─── */
window.handleSkillsInput = function (val) {
  val = (val || '').trim();
  var dd = document.getElementById('skdd');
  if (!dd) {
    console.warn('Dropdown element not found');
    return;
  }
  
  console.log('handleSkillsInput called with:', val);
  
  // First try local domain suggestions
  var domEl = document.getElementById('s2dom');
  var pool  = domEl && SD[domEl.value] ? SD[domEl.value] : [];
  var fl = pool.filter(function (s) {
    return s.toLowerCase().indexOf(val.toLowerCase()) !== -1 && 
           !jsaSkills.some(function (existing) { return existing.toLowerCase() === s.toLowerCase(); });
  }).slice(0, 8);
  
  console.log('Local pool:', pool, 'Filtered:', fl);
  
  // If local suggestions found, show them immediately
  if (fl.length > 0 && val.length >= 1) {
    console.log('Showing local suggestions:', fl);
    dd.innerHTML = fl.map(function (s) {
      return '<div class="skddi" onclick="addSk(\'' + s.replace(/'/g, "\\'") + '\')">' + s + '</div>';
    }).join('');
    dd.classList.add('on');
    return;
  }
  
  // Clear and hide if less than 2 chars
  if (!val || val.length < 2) {
    console.log('Less than 2 chars, hiding dropdown');
    dd.innerHTML = '';
    dd.classList.remove('on');
    return;
  }
  
  // Otherwise, make AJAX call for 2+ characters
  console.log('Calling AJAX for 2+ char input:', val);
  $.ajax({
    url: '{{ url("autocomplete/search") }}',
    dataType: 'json',
    data: { query: val },
    success: function (data) {
      console.log('AJAX returned:', data);
      var results = $.map(data || [], function (v) { return v; })
               .filter(function (s) { 
                 return !jsaSkills.some(function (existing) { return existing.toLowerCase() === s.toLowerCase(); });
               })
               .slice(0, 8);
      dd.innerHTML = results.map(function (s) {
        return '<div class="skddi" onclick="addSk(\'' + s.replace(/'/g, "\\'") + '\')">' + s + '</div>';
      }).join('');
      dd.classList.toggle('on', results.length > 0);
    },
    error: function (xhr, status, error) {
      console.error('AJAX error:', error);
      dd.classList.remove('on');
    }
  });
};

/* ─── readCV: show file name on selection ─── */
window.readCV = function (inp) {
  var el = document.getElementById('cvok');
  if (!el) return;
  el.style.display = 'block';
  if (inp.files && inp.files[0]) {
    var f = inp.files[0];
    var ok = f.size <= 2 * 1024 * 1024;
    el.innerHTML = ok
      ? '<div style="display:flex;align-items:center;gap:6px;margin-top:8px;font-size:12px;color:#16a34a"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>' + f.name + '</div>'
      : '<div style="font-size:12px;color:#dc2626;margin-top:6px">File is too large (max 2MB). Please compress and re-upload.</div>';
    if (!ok) inp.value = '';
  } else {
    el.style.display = 'none';
  }
};

/* ─── chkPW: password strength indicator ─── */
window.chkPW = function (v) {
  var bars  = [document.getElementById('pb1'), document.getElementById('pb2'),
               document.getElementById('pb3'), document.getElementById('pb4')];
  var hints = ['Too Weak', 'Weak', 'Moderate', 'Strong'];
  var cols  = ['#dc2626', '#f97316', '#f59e0b', '#16a34a'];
  var score = 0;
  if (v.length >= 8)        score++;
  if (/[A-Z]/.test(v))      score++;
  if (/\d/.test(v))         score++;
  if (/[^A-Za-z0-9]/.test(v)) score++;
  bars.forEach(function (b, i) {
    if (!b) return;
    b.style.background = i < score ? cols[score - 1] : '';
    b.style.opacity    = i < score ? '1' : '0.18';
  });
  var hint = document.getElementById('pwhint');
  if (hint) hint.textContent = v.length ? hints[score > 0 ? score - 1 : 0] : 'Use letters, numbers and a symbol';
};

/* ─── Skills management ─── */
window.addSk = function (name) {
  if (!name) return;
  // Capitalize first letter
  name = name.charAt(0).toUpperCase() + name.slice(1);
  // Check if skill already exists (case-insensitive)
  var exists = jsaSkills.some(function (s) { return s.toLowerCase() === name.toLowerCase(); });
  if (exists || jsaSkills.length >= 20) return;
  jsaSkills.push(name);
  renderSk();
  var inp = document.getElementById('skinp');
  if (inp) { inp.value = ''; }
  var dd = document.getElementById('skdd');
  if (dd) dd.innerHTML = '';
};
window.rmSk = function (i) {
  jsaSkills.splice(i, 1);
  renderSk();
};
window.renderSk = function () {
  var box = document.getElementById('sktags');
  if (!box) return;
  box.innerHTML = '';
  jsaSkills.forEach(function (s, i) {
    var t = document.createElement('span');
    t.className = 'sktag';
    t.innerHTML = s + '<button type="button" onclick="rmSk(' + i + ')" title="Remove">×</button>';
    box.appendChild(t);
  });
  // Sync hidden inputs
  var wrap = document.getElementById('keyskills-hidden-wrap');
  if (wrap) {
    wrap.innerHTML = '';
    jsaSkills.forEach(function (s) {
      var inp = document.createElement('input');
      inp.type = 'hidden'; inp.name = 'keyskills[]'; inp.value = s;
      wrap.appendChild(inp);
    });
  }
  // Update counter/progress
  var ct   = document.getElementById('skct');
  var pct  = document.getElementById('skpct');
  var bar  = document.getElementById('skbar');
  var MIN  = 10;
  var pv   = Math.min(100, Math.round(jsaSkills.length / MIN * 100));
  if (ct)  ct.textContent  = jsaSkills.length + ' / ' + MIN + ' min';
  if (pct) pct.textContent = pv + '%';
  if (bar) { bar.style.width = pv + '%'; bar.style.background = pv >= 100 ? '#16a34a' : '#3B5CCC'; }
  // Update suggestion pills - case-insensitive comparison
  document.querySelectorAll('.znp-auth-v13 .skpill').forEach(function (pill) {
    var pillText = pill.textContent.trim();
    var isSelected = jsaSkills.some(function (s) { return s.toLowerCase() === pillText.toLowerCase(); });
    pill.classList.toggle('on', isSelected);
  });
};

/* fDD: filter skills dropdown - now works on all devices */
window.fDD = function (term) {
  var dd = document.getElementById('skdd');
  if (!dd) return;
  // Show dropdown for 2+ characters on all devices (mobile and desktop)
  if (!term || term.length < 2) { dd.innerHTML = ''; dd.classList.remove('on'); return; }
  // Combine domain suggestions + AJAX (simple local filter for now)
  var domEl = document.getElementById('s2dom');
  var pool  = domEl && SD[domEl.value] ? SD[domEl.value] : [];
  var fl    = pool.filter(function (s) {
    return s.toLowerCase().indexOf(term.toLowerCase()) !== -1 && 
           !jsaSkills.some(function (existing) { return existing.toLowerCase() === s.toLowerCase(); });
  }).slice(0, 8);
  dd.innerHTML = fl.map(function (s) {
    return '<div class="skddi" onclick="addSk(\'' + s.replace(/'/g, "\\'") + '\')">' + s + '</div>';
  }).join('');
  dd.classList.toggle('on', fl.length > 0);
};

/* skKey: keyboard handling inside skills input */
window.skKey = function (e) {
  var inp = document.getElementById('skinp');
  if (!inp) return;
  if (e.key === 'Enter' || e.key === ',') {
    e.preventDefault();
    var v = inp.value.trim().replace(/,$/, '');
    if (v) { 
      // Capitalize first letter before adding
      v = v.charAt(0).toUpperCase() + v.slice(1);
      addSk(v); 
    }
  } else if (e.key === 'Backspace' && inp.value === '' && jsaSkills.length) {
    rmSk(jsaSkills.length - 1);
  }
};

/* AJAX skills autocomplete for skill input */
window.loadSuggAjax = function (term) {
  if (!term || term.length < 2) return;
  $.ajax({
    url: '{{ url("autocomplete/cvskills") }}',
    dataType: 'json',
    data: { query: term },
    success: function (data) {
      var dd = document.getElementById('skdd');
      if (!dd) return;
      var fl = $.map(data, function (v) { return v; })
               .filter(function (s) { 
                 return !jsaSkills.some(function (existing) { return existing.toLowerCase() === s.toLowerCase(); });
               })
               .slice(0, 8);
      dd.innerHTML = fl.map(function (s) {
        return '<div class="skddi" onclick="addSk(\'' + s.replace(/'/g, "\\'") + '\')">' + s + '</div>';
      }).join('');
      dd.classList.toggle('on', fl.length > 0);
    }
  });
};

/* loadSugg: populate domain suggestion pills */
window.loadSugg = function (domain) {
  var el = document.getElementById('sksugg');
  if (!el) return;
  var list = SD[domain] || [];
  el.innerHTML = list.slice(0, 16).map(function (s) {
    var on = jsaSkills.indexOf(s) !== -1 ? ' on' : '';
    return '<span class="skpill' + on + '" data-skill="' + s.replace(/"/g, '&quot;') + '">' + s + '</span>';
  }).join('');
};

// Delegate clicks on domain suggestion pills: on all screens, clicking a pill should add the skill
document.addEventListener('click', function (e) {
  var t = e.target;
  if (!t || !t.classList) return;
  if (t.classList.contains('skpill')) {
    var skill = t.getAttribute('data-skill') || t.textContent.trim();
    if (skill) {
      try { addSk(skill); } catch (err) { console && console.warn && console.warn('addSk missing', err); }
    }
  }
});

/* Skills dropdown handler is now managed by the inline oninput handler */


/* ─── City preferred pills ─── */
window.togCity = function (el, name) {
  if (el.classList.contains('on')) {
    el.classList.remove('on');
    selCities = selCities.filter(function (c) { return c !== name; });
  } else {
    if (selCities.length >= 3) {
      document.getElementById('cylim') && (document.getElementById('cylim').style.display = 'block');
      return;
    }
    el.classList.add('on');
    selCities.push(name);
  }
  syncCities();
};

window.addCity = function () {
  var inp = document.getElementById('cityinp');
  if (!inp) return;
  var v = inp.value.trim();
  if (!v) return;
  // Capitalize first letter
  v = v.charAt(0).toUpperCase() + v.slice(1);
  // Check for duplicates (case-insensitive)
  var isDuplicate = selCities.some(function (city) {
    return city.toLowerCase() === v.toLowerCase();
  });
  if (isDuplicate) {
    alert('This city is already selected');
    inp.value = '';
    return;
  }
  if (selCities.length >= 3) {
    document.getElementById('cylim') && (document.getElementById('cylim').style.display = 'block');
    return;
  }
  selCities.push(v);
  // Add pill to UI
  var pills = document.getElementById('cypills');
  if (pills) {
    var sp = document.createElement('span');
    sp.className = 'pill on added';
    sp.textContent = v;
    sp.onclick = function () { togCity(sp, v); };
    pills.appendChild(sp);
  }
  inp.value = '';
  syncCities();
};

function syncCities() {
  var wrap = document.getElementById('prefcity-hidden-wrap');
  if (!wrap) return;
  wrap.innerHTML = '';
  selCities.forEach(function (c) {
    var inp = document.createElement('input');
    inp.type = 'hidden'; inp.name = 'prefered_city[]'; inp.value = c;
    wrap.appendChild(inp);
  });
  var ct = document.getElementById('cyct');
  if (ct) ct.textContent = selCities.length + ' / 3';
  var lim = document.getElementById('cylim');
  if (lim) lim.style.display = selCities.length >= 3 ? 'block' : 'none';
}

/* ─── jsaTogglePw: toggle password visibility ─── */
window.jsaTogglePw = function (id, btn) {
  var inp = document.getElementById(id);
  if (!inp) return;
  var isPass = inp.type === 'password';
  inp.type = isPass ? 'text' : 'password';
  btn.style.color = isPass ? 'var(--blue)' : '';
};

/* ─── sendMagicLink ─── */
window.sendMagicLink = function (btn) {
  var email = document.getElementById('otpEmail').value.trim();
  if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    alert('Please enter a valid email address');
    return;
  }
  btn.textContent = 'Sending…';
  btn.disabled = true;
  $.ajax({
    url: '{{ url("magic-link/send") }}', // configure this route when magic link feature is ready
    method: 'POST',
    data: { email: email, _token: '{{ csrf_token() }}' },
    success: function () {
      btn.textContent = 'Sent ✓';
    },
    error: function () {
      btn.textContent = 'Send link';
      btn.disabled = false;
      alert('Could not send. Please try signing in with password.');
    }
  });
};

/* ─── valS1: validate step 1 and advance ─── */
window.valS1 = function () {
  var errs = [];
  function req(id, label) {
    var el = document.getElementById(id) || document.querySelector('[name="' + id + '"]');
    if (!el || !el.value.trim()) errs.push(label + ' is required');
  }
  req('fn', 'First name');
  req('ln', 'Last name');
  var em = document.getElementById('em');
  if (!em || !em.value.trim()) errs.push('Email is required');
  else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em.value.trim())) errs.push('Valid email is required');
  else if (emailExists) errs.push('This email is already registered. Please sign in instead.');
  var ph = document.querySelector('[name="phone"]');
  if (!ph || !/^\d{10}$/.test(ph.value.trim())) errs.push('Valid 10-digit mobile is required');
  var dob = document.getElementById('dob');
  if (!dob || !dob.value) errs.push('Date of birth is required');

  // NOP date validation (hidden uses 1 / 2 / 3)
  var nop = document.getElementById('nop_days_hidden').value;
  var lwdEl = document.getElementById('lwdinp');
  if (nop === '1') {
    if (!lwdEl || !lwdEl.value) errs.push('Last working date is required');
  } else if (nop === '2') {
    if (!lwdEl || !lwdEl.value) errs.push('Last day of notice is required');
  } else if (nop === '3') {
    if (!lwdEl || !lwdEl.value) errs.push('Course completion date is required');
  }
  if ((nop === '1' || nop === '2')) {
    var prf = document.querySelector('[name="lwd_proof"]');
    if (!prf || !prf.value) errs.push('Proof of last working date is required');
  }
  // Education
  var eduSt = document.getElementById('edu-status');
  if (!eduSt || !eduSt.value) errs.push('Education status is required');
  var deg = document.getElementById('degree_title_select');
  if (!deg || !deg.value) errs.push('Highest education is required');
  var yr = document.getElementById('edu-year');
  if (!yr || !yr.value) errs.push('Year of completion is required');

  var csRow = document.getElementById('course-spec-row');
  var csVisible = csRow && csRow.offsetParent !== null && window.getComputedStyle(csRow).display !== 'none';
  if (csVisible) {
    var crs = document.getElementById('course_select');
    var spc = document.getElementById('specilation_select');
    if (!crs || !crs.value) errs.push('Course is required');
    if (!spc || !spc.value) errs.push('Specialization is required');
    var org = document.getElementById('jsa-university-input');
    if (!org || !org.value.trim()) errs.push('University / college is required');
  }

  var errBox = document.getElementById('s1err');
  var errList = document.getElementById('s1erl');
  if (errs.length) {
    errList.innerHTML = errs.map(function(e){ return '<li>' + e + '</li>'; }).join('');
    errBox.style.display = 'block';
    errBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    return;
  }
  errBox.style.display = 'none';
  goStep(2);
};

/* ─── valS2: validate step 2 and advance ─── */
window.valS2 = function () {
  var errs = [];
  function reqEl(name, label) {
    var el = document.querySelector('[name="' + name + '"]');
    if (!el || !el.value.trim()) errs.push(label + ' is required');
  }
  reqEl('latestdesg',        'Job title');
  reqEl('latestcom',         'Company name');
  // Validate s2exp and split into hidden fields
  var expInp = document.getElementById('s2exp');
  if (!expInp || expInp.value === '' || isNaN(parseFloat(expInp.value))) {
    errs.push('Experience is required (e.g. 6.9 for 6 years 9 months)');
  } else {
    var expVal = parseFloat(expInp.value);
    var expYr = Math.floor(expVal);
    var expMo = Math.min(11, Math.round((expVal - expYr) * 10));
    var expYrHid = document.getElementById('s2exp_yr');
    var expMoHid = document.getElementById('s2exp_mo');
    if (expYrHid) expYrHid.value = expYr;
    if (expMoHid) expMoHid.value = expMo;
    if (expVal > 40) errs.push('Experience cannot exceed 40 years');
  }
  // Validate CTC inputs are numeric and within sensible bounds
  var ctcCurEl = document.querySelector('[name="expect_ctc_lakhs"]');
  if (ctcCurEl && ctcCurEl.value.trim()) {
    var cVal = parseFloat(ctcCurEl.value);
    if (isNaN(cVal)) errs.push('Current CTC is invalid');
    else if (cVal > 999) errs.push('Current CTC seems too large');
  }
  var ctcExpEl = document.querySelector('[name="expect_ctc_lakhs3"]');
  if (ctcExpEl && ctcExpEl.value.trim()) {
    var ceVal = parseFloat(ctcExpEl.value);
    if (isNaN(ceVal)) errs.push('Expected CTC is invalid');
    else if (ceVal > 999) errs.push('Expected CTC seems too large');
  }
  reqEl('gender_id',         'Gender');
  reqEl('expect_ctc_lakhs',  'Current CTC');
  reqEl('expect_ctc_lakhs3', 'Expected CTC');
  reqEl('work_option',       'Work mode preference');
  reqEl('work_type',         'Job type preference');
  reqEl('mode_of_separation','Mode of separation');
  reqEl('current_city',      'Current city');
  reqEl('locality',          'Locality');
  var csRow2 = document.getElementById('course-spec-row');
  var csVis2 = csRow2 && csRow2.offsetParent !== null && window.getComputedStyle(csRow2).display !== 'none';
  if (csVis2) {
    var crs2 = document.getElementById('course_select');
    var spc2 = document.getElementById('specilation_select');
    if (!crs2 || !crs2.value) errs.push('Course is required');
    if (!spc2 || !spc2.value) errs.push('Specialization is required');
    var org2 = document.getElementById('jsa-university-input');
    if (!org2 || !org2.value.trim()) errs.push('University / college is required');
  }
  if (jsaSkills.length < 10) errs.push('At least 10 key skills are required (' + jsaSkills.length + ' added)');
  if (selCities.length === 0) errs.push('At least 1 preferred city is required');

  var errBox = document.getElementById('s2err');
  var errList = document.getElementById('s2erl');
  if (errs.length) {
    errList.innerHTML = errs.map(function(e){ return '<li>' + e + '</li>'; }).join('');
    errBox.style.display = 'block';
    errBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    return;
  }
  errBox.style.display = 'none';
  goStep(3);
};

/* ─── submitForm: final validation then submit ─── */
window.submitForm = function () {
  if (curStep < 3) {
    if (curStep === 1) valS1();
    if (curStep === 2) valS2();
    if (curStep < 3) return;
  }
  var accCheck = document.getElementById('accuracyCheck');
  if (!accCheck || !accCheck.checked) {
    accCheck && accCheck.closest('.priv') && accCheck.closest('.priv').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    alert('Please confirm that the information you\'ve shared is accurate.');
    return;
  }
  var terms = document.querySelector('[name="terms_of_use"]');
  if (!terms || !terms.checked) {
    alert('Please agree to the Terms & Conditions to create your account.');
    return;
  }
  var resume = document.getElementById('cvmain');
  if (!resume || !resume.files || !resume.files.length) {
    alert('Please upload your CV before creating the account.');
    return;
  }
  var pw = document.getElementById('pw');
  var pwc = document.getElementById('pwc');
  if (!pw || pw.value.length < 8) {
    alert('Password must be at least 8 characters long.');
    return;
  }
  if (!pwc || pw.value !== pwc.value) {
    alert('Password and confirm password must match.');
    return;
  }
  // show email in verify screen (soft transition, actual submit happens anyway)
  var em = document.getElementById('em');
  var vemail = document.getElementById('vemail');
  if (vemail && em) vemail.textContent = em.value;
  document.getElementById('jsa-signup-form').submit();
};

/* ─── Degree / Course AJAX ─── */
window.jsaDegreeChange = function (val) {
  var csRow  = document.getElementById('course-spec-row');
  var csEl = document.getElementById('course_select');
  var spEl = document.getElementById('specilation_select');
  if (!val) {
    if (csRow) csRow.style.display = 'none';
    if (csEl) csEl.innerHTML = '<option value="">Select course</option>';
    if (spEl) spEl.innerHTML = '<option value="">Select specialization</option>';
    return;
  }
  if (csRow) csRow.style.display = '';
  if (!csEl) return;
  csEl.innerHTML = '<option value="">Loading…</option>';
  if (spEl) spEl.innerHTML = '<option value="">Select specialization</option>';
  $.ajax({
    type: 'POST', url: '{{ url("gety") }}',
    data: { degree: val, _token: '{{ csrf_token() }}' },
    success: function (data) {
      var list = data || [];
      if (!list.length) {
        if (csRow) csRow.style.display = 'none';
        csEl.innerHTML = '<option value="">Select course</option>';
        if (spEl) spEl.innerHTML = '<option value="">Select specialization</option>';
        return;
      }
      var html = '<option value="">Select course</option>';
      $.each(list, function (i, item) {
        html += '<option value="' + item.id + '">' + item.course + '</option>';
      });
      csEl.innerHTML = html;
    },
    error: function () {
      if (csRow) csRow.style.display = 'none';
      csEl.innerHTML = '<option value="">Select course</option>';
    }
  });

  // Populate year of completion
  populateEduYear(document.getElementById('edu-status') ? document.getElementById('edu-status').value : '', @if(old('year_of_completion'))'{{ old('year_of_completion') }}'@else null @endif);
};

window.jsaCourseChange = function (courseId) {
  var spEl = document.getElementById('specilation_select');
  if (!spEl) return;
  if (!courseId) { spEl.innerHTML = '<option value="">Select specialization</option>'; return; }
  spEl.innerHTML = '<option value="">Loading…</option>';
  $.ajax({
    type: 'POST', url: '{{ url("getspecs") }}',
    data: { course: courseId, _token: '{{ csrf_token() }}' },
    success: function (data) {
      var html = '<option value="">Select specialization</option>';
      $.each(data, function (i, item) {
        html += '<option value="' + item.id + '">' + item.specs + '</option>';
      });
      spEl.innerHTML = html;
    },
    error: function () { spEl.innerHTML = '<option value="">Select specialization</option>'; }
  });
};

/* ─── Restore old() values after validation error ─── */
(function restoreOldValues() {
  // Restore NOP state from old value
  var nopVal = '{{ old('nop_days', 1) }}';
  if (String(nopVal) === '2') setN('s');
  else if (String(nopVal) === '3')   setN('f');
  else                                setN('i');

  // Restore skills
  if (jsaSkills.length) renderSk();
  goStep(1);
  // Restore cities
  if (selCities.length) {
    selCities.forEach(function (c) {
      var pill = document.querySelector('.znp-auth-v13 .pill[onclick*="' + c + '"]');
      if (pill && !pill.classList.contains('on')) pill.classList.add('on');
    });
    syncCities();
  }

  // Restore degree-dependent fields
  @if(old('degree_title'))
  (function () {
    var oldCourse = '{{ old('course') }}';
    var oldSpec   = '{{ old('specilation') }}';
    var degSelect = document.getElementById('degree_title_select');
    if (!degSelect) return;
    // Populate year dropdown for existing degree
    var yr = document.getElementById('edu-year');
    if (yr) populateEduYear(document.getElementById('edu-status') ? document.getElementById('edu-status').value : '', '{{ old('year_of_completion') }}');
    var csRow = document.getElementById('course-spec-row');
    $.ajax({
      type: 'POST', url: '{{ url("gety") }}',
      data: { degree: '{{ old('degree_title') }}', _token: '{{ csrf_token() }}' },
      success: function (data) {
        var list = data || [];
        var csEl = document.getElementById('course_select');
        if (!csEl) return;
        if (!list.length) {
          if (csRow) csRow.style.display = 'none';
          csEl.innerHTML = '<option value="">Select course</option>';
          return;
        }
        if (csRow) csRow.style.display = '';
        var html = '<option value="">Select course</option>';
        $.each(list, function (i, item) {
          html += '<option value="' + item.id + '"' + (oldCourse == item.id ? ' selected' : '') + '>' + item.course + '</option>';
        });
        csEl.innerHTML = html;
        if (!oldCourse) return;
        $.ajax({
          type: 'POST', url: '{{ url("getspecs") }}',
          data: { course: oldCourse, _token: '{{ csrf_token() }}' },
          success: function (sData) {
            var spEl = document.getElementById('specilation_select');
            if (!spEl) return;
            var sHtml = '<option value="">Select specialization</option>';
            $.each(sData, function (i, item) {
              sHtml += '<option value="' + item.id + '"' + (oldSpec == item.id ? ' selected' : '') + '>' + item.specs + '</option>';
            });
            spEl.innerHTML = sHtml;
          }
        });
      },
      error: function () { if (csRow) csRow.style.display = 'none'; }
    });
  }());
  @endif

  // Navigate to correct step on validation error
  @if($errors->any() && old('_from_signup'))
  @if($errors->hasAny(['resume','password','password_confirmation','terms_of_use']))
  goStep(3);
  @elseif($errors->hasAny(['latestdesg','latestcom','totalexp','gender_id','expect_ctc_lakhs','expect_ctc_lakhs3','work_option','work_type','mode_of_separation','current_city','locality','keyskills']))
  goStep(2);
  @else
  goStep(1);
  @endif
  swTab('su');
  @elseif($errors->any() && !old('_from_signup'))
  swTab('si');
  @elseif(session('error_message') || session('error_message1') || session('verify_message'))
  swTab('si');
  @endif
}());
</script>

<script>
$(function () {

  /* ─── helper: highlight matching text ─── */
  function acHL($menu, term) {
    $menu.find('li').each(function () {
      var item = $(this).data('ui-autocomplete-item');
      if (!item) return;
      var hl = item.label.replace(
        new RegExp($.ui.autocomplete.escapeRegex(term), 'gi'),
        '<span class="highlight">$&</span>'
      );
      $(this).find('.ui-menu-item-wrapper').html(hl);
    });
  }

  /* 1. Current City */
  $('#jsa-city-input').autocomplete({
    minLength: 1,
    appendTo: '.znp-auth-v13',
    source: function (req, res) {
      $.ajax({ url: '{{ url("autocomplete/search-location-job1") }}', dataType: 'json',
        data: { query: req.term },
        success: function (data) { res($.map(data, function (v) { return { label: v, value: v }; })); }
      });
    },
    focus: function () { return false; },
    open:  function () { acHL($(this).autocomplete('widget'), this.value); },
    select: function (e, ui) { this.value = ui.item.value; return false; }
  });

  /* 2. Current Locality */
  $('#jsa-locality-input').autocomplete({
    minLength: 1,
    appendTo: '.znp-auth-v13',
    source: function (req, res) {
      $.ajax({ url: '{{ url("autocomplete/search-location-job1") }}', dataType: 'json',
        data: { query: req.term },
        success: function (data) { res($.map(data, function (v) { return { label: v, value: v }; })); }
      });
    },
    focus: function () { return false; },
    open:  function () { acHL($(this).autocomplete('widget'), this.value); },
    select: function (e, ui) { this.value = ui.item.value; return false; }
  });

  /* 3. Latest Company */
  $('#jsa-company-input').autocomplete({
    minLength: 1,
    appendTo: '.znp-auth-v13',
    source: function (req, res) {
      $.ajax({ url: '{{ url("search-companies") }}', dataType: 'json',
        data: { q: req.term },
        success: function (data) { res($.map(data, function (c) { return { label: c.name, value: c.name }; })); }
      });
    },
    focus: function () { return false; },
    open:  function () { acHL($(this).autocomplete('widget'), this.value); },
    select: function (e, ui) { this.value = ui.item.value; return false; }
  });

  /* 4. Key Skills: Handled by inline oninput handler above */


  /* 5. University */
  $('#jsa-university-input').autocomplete({
    minLength: 2,
    appendTo: '.znp-auth-v13',
    source: function (req, res) {
      $.ajax({ url: '{{ url("search-university") }}', dataType: 'json',
        data: { q: req.term },
        success: function (data) { res($.map(data, function (u) { return { label: u.educations, value: u.educations }; })); }
      });
    },
    focus: function () { return false; },
    open:  function () { acHL($(this).autocomplete('widget'), this.value); },
    select: function (e, ui) { this.value = ui.item.value; return false; }
  });

  /* Close skill dropdown on outside click */
  $(document).on('click', function (e) {
    if (!$(e.target).closest('.skwrap').length) {
      var dd = document.getElementById('skdd');
      if (dd) {
        dd.classList.remove('on');
        // Don't clear innerHTML - let the input handler manage content
      }
    }
  });
});
</script>

<script>
/* ── Success modal ── */
document.addEventListener('DOMContentLoaded', function () {
  var AUTOCLOSE_MS = 6000;
  var modal = document.getElementById('znp-success-modal');
  if (!modal) return;

  var bar = document.getElementById('jsa-modal-bar');
  if (bar) bar.style.animationDuration = (AUTOCLOSE_MS / 1000) + 's';

  setTimeout(function () { modal.classList.add('open'); }, 16);

  var prevFocus = document.activeElement;
  var timer = null;

  function jsaClose() {
    modal.classList.remove('open');
    if (timer) { clearTimeout(timer); timer = null; }
    if (prevFocus && prevFocus.focus) prevFocus.focus();
    swTab('si');
  }
  window.jsaCloseSuccessModal = jsaClose;

  var cta = document.getElementById('jsa-success-close');
  if (cta) { cta.focus(); cta.addEventListener('click', jsaClose); }
  timer = setTimeout(jsaClose, AUTOCLOSE_MS);

  modal.addEventListener('mouseenter', function () {
    if (timer) { clearTimeout(timer); timer = null; }
  });
  modal.addEventListener('mouseleave', function () {
    if (!timer) timer = setTimeout(jsaClose, 2500);
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') jsaClose();
  });
});
</script>
@endpush
