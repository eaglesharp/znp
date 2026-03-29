# ZNP Page Development Guide

> **Single source of truth** — read this before building any new ZNP public page.
> Every rule here was established and verified across the Home page and the Jobs page.
> Follow this exactly. Do not improvise.

---

## 1. Overview

**ZeroNoticePeriod** — Laravel 8 job portal.
Goal: convert client-supplied HTML files into Laravel Blade pages using a shared design system.

| Layer     | Detail                                                             |
|-----------|--------------------------------------------------------------------|
| Framework | Laravel 8, PHP 8.0                                                 |
| Templates | Blade (`.blade.php`)                                               |
| CSS       | Inline `<style>` inside `@push('styles')`, scoped to `.znp-{page}`|
| Fonts     | Inter — loaded once in `layouts/znp.blade.php` (do NOT re-import) |
| Layout    | CSS Grid + Flexbox                                                 |
| JS        | Vanilla JS + jQuery (globally available via master layout)         |

---

## 2. Architecture — How a Page Renders

```
Browser request
    ↓
routes/web.php                   → maps URL to Controller@method
    ↓
Controller@method                → optional DB queries, return view(...)
    ↓
resources/views/znp/{page}.blade.php
    @extends('layouts.znp')      ← NEW clean layout (NOT layouts/app)
    @push('styles')              ← page-specific CSS injected into <head>
    @section('content')
        @include('znp.header')   ← shared nav (OUTSIDE page wrapper)
        <div class="znp-{page}"> ← page wrapper — contains page content only
            [page sections]
        </div>
        @include('znp.footer')   ← shared footer (OUTSIDE page wrapper)
    @push('scripts')             ← page JS injected before </body>
```

---

## 3. Master Layout — `resources/views/layouts/znp.blade.php`

The only layout used for all new ZNP pages. **Do NOT use `layouts/app.blade.php`.**
`layouts/app.blade.php` is legacy — full of Select2, Toastr, Owl Carousel, etc. not needed.

**What `layouts/znp.blade.php` already loads (do NOT re-import any of these):**
- Bootstrap 4 CSS + JS
- Font Awesome
- Inter font (Google Fonts) — preconnect + stylesheet
- jQuery UI CSS + JS
- `public/css/znp-common.css` (with cache-busting via `filemtime`)
- jQuery
- Bootstrap JS
- `@stack('styles')` slot in `<head>`
- `@stack('scripts')` slot before `</body>`
- `@yield('content')` slot in `<body>`

---

## 4. Master CSS File — `public/css/znp-common.css`

Shared design tokens and shared component classes loaded on every ZNP page.

### When to edit `znp-common.css`
Only when a change should apply **site-wide across all pages**.

### When NOT to edit it
When only one page needs a different value — use a scoped override in that page's `@push('styles')`.

### Design Tokens — ALWAYS use these variables, never hard-code colours

These are defined in both `znp-common.css` (as `:root`) and `znp/header.blade.php`:

```css
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
```

### Shared Classes in `znp-common.css` (home page values = standard)

These classes are available on every page from the master file.
The **home page approved values are the site-wide standard**:

| Class        | Standard value (home page)                        |
|--------------|---------------------------------------------------|
| `.job-card`  | `border-radius: 12px; padding: 18px 20px`         |
| `.jc-top`    | `display: flex; gap: 12px; margin-bottom: 12px`   |
| `.jc-avatar` | `38px; white text; coloured bg`                   |
| `.jc-title`  | `font-size: 12px; font-weight: 700`               |
| `.jc-company`| `font-size: 10.5px; color: var(--text-muted)`     |
| `.jc-tags`   | `gap: 6px; flex-wrap: wrap; margin-bottom: 14px`  |
| `.tag`       | `font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 100px` |

Tag colour classes also in master: `.t-remote .t-hybrid .t-wfo .t-urgent .t-new .t-contract .t-full .t-c2h`

---

## 5. ⚠️ Critical Rule — Header & Footer Placement

The header and footer **must always be OUTSIDE the `.znp-{page}` wrapper div**.

### CORRECT ✅
```blade
@section('content')
@include('znp.header')          {{-- outside .znp-page --}}
<div class="znp-page">
    {{-- page content only --}}
</div>
@include('znp.footer')          {{-- outside .znp-page --}}
@endsection
```

### WRONG ❌ — Never do this
```blade
@section('content')
<div class="znp-page">
    @include('znp.header')      {{-- WRONG — inside wrapper --}}
    {{-- page content --}}
    @include('znp.footer')      {{-- WRONG — inside wrapper --}}
</div>
@endsection
```

**Why this matters:**
- `.znp-{page}` block often overrides CSS variables (e.g. `--blue: #0056d2`)
- If header/footer are inside the wrapper, those variable overrides bleed into them
- Footer background uses `var(--blue)` — if the page overrides `--blue`, footer changes colour
- Header logo font uses inheritance — page's `font-size: 12px !important` reset would shrink the logo
- Result: header and footer look different on every page — **which is wrong**

**The rule:** Header and footer must look identical on every single page. They are shared components. They must never be affected by any page-specific CSS.

---

## 6. Shared Partials — Header & Footer

| File                                   | Purpose                              |
|----------------------------------------|--------------------------------------|
| `resources/views/znp/header.blade.php` | Logo + "Find Jobs" + "Post a Job" nav |
| `resources/views/znp/footer.blade.php` | Footer with links, address, socials  |

**Do NOT change header.blade.php or footer.blade.php for any page.**
They are shared. Any change affects all pages.

The header also defines `:root` CSS variables — same values as `znp-common.css`.
The footer uses `var(--blue)` for its background colour (`#1a3faa` dark navy).

---

## 7. New Page — Step-by-Step

### Step 1 — Add Route

```php
// routes/web.php — append new line, do NOT touch existing routes
Route::get('/{pagename}-page', 'SomeController@methodName');
```

Use a temp URL during development (e.g. `/about-page`, not `/about`).
Real URLs are only assigned when the full site goes live.

| Real URL (final) | Temp URL (dev)      |
|------------------|---------------------|
| `/`              | `/` (home is live)  |
| `/jobs`          | `/jobs-page`        |
| `/about`         | `/about-page`       |
| `/employers`     | `/employers-page`   |

### Step 2 — Add Controller Method

Add a new method to an **existing** controller. Never create a new controller file.

```php
// Inside existing app/Http/Controllers/SomeController.php
public function methodName()
{
    // Only query what this page actually needs
    $jobs = PostJob::status()->latest()->take(10)->get();
    return view('znp.pagename', compact('jobs'));
}
```

### Step 3 — Create the Blade View

File path: `resources/views/znp/{pagename}.blade.php`

```blade
@extends('layouts.znp')

@push('styles')
<style>
/* ── ZNP {PAGENAME}: SCOPE & RESET ── */
.znp-{pagename},
.znp-{pagename} * {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}
.znp-{pagename} { background: var(--bg); color: var(--text); font-size: 12px; }
.znp-{pagename} a              { color: inherit; text-decoration: none; }
.znp-{pagename} h1, .znp-{pagename} h2,
.znp-{pagename} h3, .znp-{pagename} h4 { margin: 0; font-weight: inherit; }
.znp-{pagename} p              { margin: 0; }
.znp-{pagename} ul             { list-style: none; padding: 0; margin: 0; }
.znp-{pagename} button         { font-family: inherit !important; }

/* ── ONLY if this page needs different token values from :root ── */
/* Delete this block entirely if all :root values work for this page */
.znp-{pagename} {
    /* --blue: #0056d2; */   /* only add if this page uses a different blue */
}

/* ── PAGE-SPECIFIC STYLES ── */
/* section by section, top to bottom */

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    /* all responsive rules here, always at the very bottom */
}
</style>
@endpush

@section('content')
@include('znp.header')
<div class="znp-{pagename}">

    {{-- page content here --}}

</div>
@include('znp.footer')
@endsection

@push('scripts')
<script>
    // page-specific JS here
</script>
@endpush
```

---

## 8. CSS Overrides — Shared Classes (Delta Pattern)

When a page needs a shared class (e.g. `.jc-title`) to look different from the master value,
write **only the delta** — the properties that change — as a scoped override.

```css
/* ── WRONG — do not redeclare all properties ── */
.znp-jobs .jc-title {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text);        /* same as master — unnecessary */
    line-height: 1.3;          /* same as master — unnecessary */
    margin-bottom: 3px;        /* same as master — unnecessary */
}

/* ── CORRECT — only the delta (what actually differs from master) ── */
.znp-jobs .jc-title {
    font-size: 13.5px;         /* master is 12px — this page needs 13.5px */
    font-weight: 600;          /* master is 700 — this page needs 600 */
    margin-bottom: 0;          /* master is 3px — layout gap handles spacing here */
}
```

**Reference: Jobs page overrides vs. master values**

| Class        | Master (znp-common.css)   | Jobs page override           |
|--------------|---------------------------|------------------------------|
| `.jc-title`  | `12px / 700`              | `13.5px / 600`               |
| `.jc-avatar` | `38px, white text, bg`    | `44px, blue text, grey bg`   |
| `.tag`       | `11.5px / 600 / 4px 10px` | `11px / 500 / 3px 9px`       |
| `.job-card`  | `radius 12px / pad 18px`  | `radius 10px / pad 12px + border-left` |

---

## 9. CSS Structure Order Inside `@push('styles')`

Always write styles in this order:

```
1. Scope & reset block    (.znp-{page} and .znp-{page} *)
2. Token overrides block  (.znp-{page} { --blue: ...; })  — only if needed
3. Section styles         top to bottom of the page layout
4. Shared class overrides  (.znp-{page} .jc-title { ... }) — only delta values
5. @media queries         ALL responsive rules, always at the very bottom
```

---

## 10. Models — Key Fields Reference

### `PostJob`
**Always** use the `.status()` scope. Never do `PostJob::all()` or `PostJob::get()` without it.

```php
PostJob::status()->latest()->take(10)->get()
```

| Field        | Type     | Notes                                                   |
|--------------|----------|---------------------------------------------------------|
| `job_title`  | string   | Job title                                               |
| `job_type`   | string   | "Permanent", "Contract", etc.                           |
| `work_mode`  | string   | "Hybrid", "Remote/WFH", "Work From Office"              |
| `location`   | string   | **PHP serialized array** — always `@unserialize()` before use |
| `search`     | string   | Concatenated keywords for full-text search              |
| `min_salary` | int      | In LPA                                                  |
| `max_salary` | int      | In LPA                                                  |
| `experience` | string   | Experience requirement                                  |
| `slug`       | string   | URL identifier                                          |
| `created_at` | datetime | Post date                                               |
| `company()`  | relation | BelongsTo `Company`                                     |

### `Company`

| Field          | Notes                                              |
|----------------|----------------------------------------------------|
| `company_name` | Display name                                       |
| `profile_pic`  | Logo filename — path: `publiccvs/{profile_pic}`    |

### `Seo`

```php
$seo = Seo::where('page_title', 'your_page_key')->first();
```

| Field             | Use                       |
|-------------------|---------------------------|
| `seo_title`       | Page `<title>` tag        |
| `seo_description` | Meta description          |
| `seo_keywords`    | Meta keywords             |

### `Counter`

Admin-managed stat numbers (e.g. total jobs, companies).
```php
$counters = Counter::first();
// {{ $counters->total_jobs }}, {{ $counters->total_companies }} etc.
```

---

## 11. Asset Paths

| Asset type        | Blade helper                                                      |
|-------------------|-------------------------------------------------------------------|
| ZNP images/icons  | `{{ asset('znp/images/file.svg') }}`                              |
| Company logos     | `{{ asset('publiccvs/' . $company->profile_pic) }}`               |
| Common CSS        | `{{ asset('css/znp-common.css') }}` (already loaded by layout)    |
| Legacy CSS/JS     | `{{ asset('asset/css/file.css') }}`                               |

---

## 12. Hard Rules — No Exceptions

| # | Rule |
|---|------|
| 1 | **Use `@extends('layouts.znp')` only** — never `layouts/app` for new pages |
| 2 | **Header + footer OUTSIDE the page wrapper div** — see Section 5 |
| 3 | **Never change `znp/header.blade.php` or `znp/footer.blade.php`** — they are shared |
| 4 | **Never change `layouts/znp.blade.php`** for a specific page's needs |
| 5 | **Add new method to existing controller** — never create a new controller file |
| 6 | **Do NOT re-import Inter font** — already in `layouts/znp.blade.php` |
| 7 | **Do NOT re-import Bootstrap, jQuery, jQuery UI, Font Awesome** — already in layout |
| 8 | **Always use `PostJob::status()` scope** — never raw `PostJob::all()` or `::get()` |
| 9 | **Always `@unserialize($job->location)`** — it is a PHP serialized array |
| 10 | **Use CSS variables only** — never hard-code `#1a3faa`, always `var(--blue)` |
| 11 | **Only delta overrides on shared classes** — do not redeclare unchanged properties |
| 12 | **Media queries at the bottom** — all `@media` rules go last in the `<style>` block |
| 13 | **No Tawk.to script** — removed; never add it back |
| 14 | **Append routes only** — never modify or delete existing routes in `web.php` |
| 15 | **Home page visual output is frozen** — it is client-approved; do not change any CSS value on it |

---

## 13. Folder Structure

```
routes/
└── web.php                           ← append new route line only

app/Http/Controllers/
└── ExistingController.php            ← add new method here only

public/
└── css/
    └── znp-common.css                ← master shared CSS (design tokens + shared classes)

resources/views/
├── layouts/
│   ├── znp.blade.php                 ← master layout for all new ZNP pages
│   └── app.blade.php                 ← legacy layout (existing pages only — do NOT use)
└── znp/
    ├── header.blade.php              ← shared header (do NOT change)
    ├── footer.blade.php              ← shared footer (do NOT change)
    ├── home.blade.php                ← Home page (approved, frozen — do NOT change)
    └── {pagename}.blade.php          ← new pages go here
```

---

## 14. Existing Pages — Reference Implementations

### Home Page — `resources/views/home.blade.php`
- Route: `GET /` → `HomeController@index` (or equivalent)
- Wrapper: `<div class="znp-home">`
- Status: client-approved, visual output frozen
- Uses: hero, stats bar, city tabs + job cards, categories, employers carousel, how-it-works, dual CTA, email CTA, footer

### Jobs Page — `resources/views/znp/jobs.blade.php`
- Route: `GET /jobs-page` → `Job\JobController@jobsPage`
- Wrapper: `<div class="znp-jobs">`
- Uses: search hero + tag carousel, filter sidebar (12 sections, sticky), jobs list, pagination
- Token overrides: `--blue: #0056d2` (brighter blue for the page content only)
- Card delta: `border-radius: 10px`, `padding: 12px 14px`, `border-left` accent stripe

---

## 15. New Page Checklist

Before starting any new page, confirm:

- [ ] Client HTML `<html>`, `<head>`, `<body>` tags stripped
- [ ] Client HTML header section stripped (replaced with `@include('znp.header')`)
- [ ] Client HTML footer section stripped (replaced with `@include('znp.footer')`)
- [ ] `pagename` decided — lowercase, no spaces (e.g. `about`, `employers`)
- [ ] Temp URL decided (e.g. `/about-page`)
- [ ] Existing controller identified to add new method to
- [ ] DB models needed identified (PostJob / Company / Seo / Counter / none)
- [ ] `@extends('layouts.znp')` at line 1
- [ ] Header and footer placed OUTSIDE `.znp-{pagename}` wrapper
- [ ] All CSS scoped under `.znp-{pagename}`
- [ ] Token override block only added if needed
- [ ] All media queries at the bottom of the `<style>` block

---

## 16. Quick Copy — Page Boilerplate

```blade
@extends('layouts.znp')

@push('styles')
<style>
/* ── ZNP PAGENAME: SCOPE & RESET ── */
.znp-pagename,
.znp-pagename * {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}
.znp-pagename { background: var(--bg); color: var(--text); font-size: 12px; }
.znp-pagename a                                              { color: inherit; text-decoration: none; }
.znp-pagename h1, .znp-pagename h2,
.znp-pagename h3, .znp-pagename h4                          { margin: 0; font-weight: inherit; }
.znp-pagename p                                              { margin: 0; }
.znp-pagename ul                                             { list-style: none; padding: 0; margin: 0; }
.znp-pagename button                                         { font-family: inherit !important; }

/* ── RESPONSIVE ── */
@media (max-width: 768px) {

}
</style>
@endpush

@section('content')
@include('znp.header')
<div class="znp-pagename">

    {{-- content here --}}

</div>
@include('znp.footer')
@endsection

@push('scripts')
<script>

</script>
@endpush
```

---

*Last updated: March 2026 — reflects CSS architecture refactor (znp-common.css, layouts/znp.blade.php, header/footer placement rule)*
