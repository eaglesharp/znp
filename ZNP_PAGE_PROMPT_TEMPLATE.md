# ZNP_PAGE_PROMPT_TEMPLATE.md
# ─────────────────────────────────────────────────────────────────
# HOW TO USE THIS FILE
# ─────────────────────────────────────────────────────────────────
# 1. At the start of a NEW Copilot session → paste ZNP_COPILOT_CONTEXT.md first
# 2. For EACH new page → copy the "COPILOT PROMPT" block below
# 3. Fill in the 5 tagged fields (marked with ← FILL THIS)
# 4. Paste the client HTML body content in the marked section
# 5. Send — that's it. One prompt per page.
#
# Pre-flight checklist before pasting to Copilot:
#   [ ] Removed <html>, <head>, <body> tags from client HTML
#   [ ] Removed existing header section from client HTML
#   [ ] Removed existing footer section from client HTML
#   [ ] Decided pagename (lowercase, no spaces)
#   [ ] Decided temp URL
#   [ ] Decided which existing controller + new method name
#   [ ] Noted which DB models are needed
# ─────────────────────────────────────────────────────────────────


# ═══════════════════════════════════════════════════════════════════
# COPILOT PROMPT — copy everything below this line for each new page
# ═══════════════════════════════════════════════════════════════════

## Task: Convert Client HTML → ZNP Blade Page

Follow all rules from ZNP_COPILOT_CONTEXT.md shared at the start of this session.
Do not ask clarifying questions — use the context file for any convention decisions.

---

### Page Info

| Field            | Value                                                    |
|------------------|----------------------------------------------------------|
| Page name        | {pagename}          ← FILL THIS  e.g. jobs              |
| Temp URL         | /{page-slug}        ← FILL THIS  e.g. /jobs-page        |
| Controller       | {ControllerName}    ← FILL THIS  e.g. JobController     |
| New method name  | {methodName}        ← FILL THIS  e.g. newIndex          |
| View file        | znp/{pagename}.blade.php  (auto-derived from page name) |

---

### DB / Data Needed

← FILL THIS — delete rows that don't apply

- [ ] PostJob — fetch latest N active jobs (`PostJob::status()->latest()->take(N)->get()`)
- [ ] Company — via `$job->company` relation (logo + name)
- [ ] Seo — page key: `{seo_page_key}` ← FILL THIS if SEO needed, else delete row
- [ ] None — this is a static page, no DB queries needed

---

### What to Generate

1. **Route** — single new line in `routes/web.php` (no changes to existing routes)
2. **Controller method** — new method only, inside `{ControllerName}.php`
3. **Blade view** — `resources/views/znp/{pagename}.blade.php`
   - Extends `layouts.znp`
   - Scoped CSS under `.znp-{pagename}` in `@push('styles')`
   - `@include('znp.header')` at top of content
   - `@include('znp.footer')` at bottom of content
   - Page JS in `@push('scripts')` if needed
4. **Confirmation** — one-line note confirming zero existing files were changed

---

### Client HTML (body content only — header and footer already removed)

```html
← PASTE CLIENT HTML HERE
```

# ═══════════════════════════════════════════════════════════════════
# END OF COPILOT PROMPT
# ═══════════════════════════════════════════════════════════════════




# ─────────────────────────────────────────────────────────────────
# REFERENCE: Session Opener Message
# ─────────────────────────────────────────────────────────────────
# Use this as your FIRST message in every new Copilot session.
# Copy everything between the dashes and paste it to Copilot.
# ─────────────────────────────────────────────────────────────────

---SESSION OPENER (paste as first message)---

Before we start, here is the full context for all ZNP blade conversion tasks
in this session. Apply these rules to every page I give you without me
repeating them.

[PASTE FULL CONTENTS OF ZNP_COPILOT_CONTEXT.md HERE]

Reply with "ZNP context loaded — ready for first page." and nothing else.

---END SESSION OPENER---




# ─────────────────────────────────────────────────────────────────
# REFERENCE: Page Tracker
# ─────────────────────────────────────────────────────────────────
# Keep this updated as you complete pages.
# When ALL pages are done → swap temp URLs to real URLs in web.php
# ─────────────────────────────────────────────────────────────────

| Page       | Real URL       | Temp URL         | Controller Method     | Blade File              | Status      |
|------------|----------------|------------------|-----------------------|-------------------------|-------------|
| Home       | /              | /home-page       | HomeController@newIndex | znp/home.blade.php    | ✅ Done     |
| Jobs       | /jobs          | /jobs-page       |                       |                         | ⬜ Pending  |
| About      | /about         | /about-page      |                       |                         | ⬜ Pending  |
| Employers  | /employers     | /employers-page  |                       |                         | ⬜ Pending  |
|            |                |                  |                       |                         |             |
|            |                |                  |                       |                         |             |
|            |                |                  |                       |                         |             |

# Add new rows as client sends more HTML files.
# Final step: once all rows are ✅ Done, do a find-replace in web.php
# changing all temp URLs to real URLs in one pass.
