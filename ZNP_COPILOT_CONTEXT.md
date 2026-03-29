# ZNP Blade Conversion — Copilot Quick Context
# Paste this at the start of every Copilot session. Do not skip any section.

---

## 1. Project Overview

**ZeroNoticePeriod** — a live Laravel 8 job portal running in production.
Goal: Convert client-supplied HTML design files into Laravel Blade pages, one page at a time.
All new pages are isolated from existing pages. Existing files are NEVER modified.

---

## 2. Tech Stack

| Layer       | Detail                                              |
|-------------|-----------------------------------------------------|
| Framework   | Laravel 8, PHP 8.0                                  |
| Templating  | Blade (.blade.php)                                  |
| CSS         | Inline `<style>` scoped to `.znp-{pagename}`        |
| Fonts       | Inter — loaded via Google Fonts on every new page   |
| Layout      | CSS Grid + Flexbox                                  |
| JS          | Vanilla JS + jQuery (globally available)            |

**Globally available on every page (already in master layout — do NOT re-import):**
Bootstrap 4 CSS + JS, jQuery, jQuery UI, Select2, Toastr, Owl Carousel, Font Awesome

---

## 3. New Page Architecture

Every new page follows this exact pattern — no exceptions:

```
Route (web.php)
    ↓
New method in EXISTING controller (never create a new controller)
    ↓
resources/views/znp/{pagename}.blade.php
    @extends('layouts.znp')         ← new isolated layout, NOT layouts/app.blade.php
    @push('styles')                 ← all page CSS here
    @section('content')
        @include('znp.header')      ← shared ZNP nav
        [converted HTML content]
        @include('znp.footer')      ← shared ZNP footer
    @push('scripts')                ← all page JS here
```

### New Master Layout — `resources/views/layouts/znp.blade.php`
- This is a clean minimal layout created specifically for new ZNP pages
- It does NOT inherit bloat from `layouts/app.blade.php`
- Contains only: `<html>`, `<head>` with `@stack('styles')`, `<body>` with `@yield('content')` and `@stack('scripts')`
- Bootstrap 4, jQuery, Font Awesome are still loaded here (they are required)

---

## 4. URL Strategy

- Every new page gets a **temporary URL** during development
- Real URLs are only swapped when ALL pages are complete
- Pattern: if real URL is `/jobs`, temp URL is `/jobs-page`

| Real URL (final) | Temp URL (dev)    |
|------------------|-------------------|
| `/`              | `/home-page`      |
| `/jobs`          | `/jobs-page`      |
| `/about`         | `/about-page`     |
| `/employers`     | `/employers-page` |

---

## 5. CSS Rules

### Scoping (mandatory)
```css
.znp-{pagename},
.znp-{pagename} * {
    font-family: 'Inter', sans-serif !important;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}
.znp-{pagename} a { color: inherit; text-decoration: none; }
.znp-{pagename} h1, .znp-{pagename} h2,
.znp-{pagename} h3, .znp-{pagename} h4 { margin: 0; font-weight: inherit; }
.znp-{pagename} p  { margin: 0; }
.znp-{pagename} ul { list-style: none; padding: 0; margin: 0; }
```

### CSS Design Tokens — ALWAYS use these, never hard-code colours
```css
/* These are defined in znp/header.blade.php :root — available globally */
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
```

### CSS Structure Order (inside @push('styles'))
1. Google Fonts import
2. Scoping reset block (`.znp-{pagename}` + `*`)
3. Section-by-section styles (top to bottom of page)
4. All `@media (max-width: 768px)` rules — always at the very bottom

---

## 6. Models & DB Reference

### PostJob
```php
PostJob::status()->latest()->take(N)->get()  // ALWAYS use .status() scope
```

| Field        | Type     | Notes                                              |
|--------------|----------|----------------------------------------------------|
| job_title    | string   | Job title                                          |
| job_type     | string   | "Permanent", "Contract", etc.                      |
| work_mode    | string   | "Hybrid", "Remote/WFH", "Work From Office"         |
| location     | string   | PHP serialized array — ALWAYS unserialize before use |
| search       | string   | Concatenated keywords for full-text search         |
| min_salary   | int      | In LPA                                             |
| max_salary   | int      | In LPA                                             |
| experience   | string   | Experience requirement                             |
| slug         | string   | URL identifier                                     |
| created_at   | datetime | Post date                                          |
| company()    | relation | BelongsTo Company                                  |

### Company
| Field        | Notes                                              |
|--------------|----------------------------------------------------|
| company_name | Display name                                       |
| profile_pic  | Logo filename — path: `publiccvs/{profile_pic}`    |

### Seo
```php
$seo = Seo::where('page_title', 'your_page_key')->first();
// Use in blade: {{ $seo->seo_title }}, {{ $seo->seo_description }}
```

---

## 7. Asset Paths

| Asset type     | Blade usage                                                    |
|----------------|----------------------------------------------------------------|
| ZNP images     | `{{ asset('znp/images/filename.svg') }}`                       |
| Company logos  | `{{ asset('publiccvs/' . $company->profile_pic) }}`            |
| Legacy assets  | `{{ asset('asset/css/file.css') }}`                            |

---

## 8. Hard Rules — Follow Every Time, No Exceptions

1. **Zero changes to existing files** — no edits to any existing route, controller, view, or stylesheet
2. **New controller method only** — add a new method inside the existing controller; never create a duplicate controller
3. **New blade file only** — `resources/views/znp/{pagename}.blade.php`; never modify existing views
4. **Extends `layouts/znp` only** — never use `layouts/app.blade.php` for new pages
5. **Strip client HTML header + footer** — replace with `@include('znp.header')` and `@include('znp.footer')`
6. **No inline styles** — all CSS goes inside `@push('styles')`, scoped under `.znp-{pagename}`
7. **No inline scripts** — all JS goes inside `@push('scripts')`
8. **Active jobs only** — always use `PostJob::status()` scope; never raw `PostJob::all()` or `PostJob::get()`
9. **Always unserialize location** — `@unserialize($job->location)` before looping or displaying
10. **Inter font** — always load via Google Fonts in `@push('styles')` on every new page
11. **Media queries last** — all responsive rules go at the bottom of the `<style>` block
12. **No Tawk chatbot** — do not add or re-add any Tawk.to script

---

## 9. Folder Structure (new pages only)

```
routes/
└── web.php                          ← append new route only

app/Http/Controllers/
└── ExistingController.php           ← add new method here only

resources/views/
├── layouts/
│   └── znp.blade.php                ← new clean master layout
└── znp/
    ├── header.blade.php             ← shared header (already built)
    ├── footer.blade.php             ← shared footer (already built)
    └── {pagename}.blade.php         ← new page goes here
```

---

## 10. Session Checklist — Before You Give Any Page

Confirm before submitting each page prompt:
- [ ] Client HTML header removed (keep only body content)
- [ ] Client HTML footer removed (keep only body content)  
- [ ] `<html>`, `<head>`, `<body>` tags removed
- [ ] Page name decided (`pagename` = lowercase, no spaces, e.g. `jobs`, `about`)
- [ ] Temp URL decided (e.g. `/jobs-page`)
- [ ] Controller + new method name decided
- [ ] DB models needed identified (PostJob / Company / Seo / none)
