<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[British Software Development](https://www.britishsoftware.co)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## ZNP New Pages — Development Convention

> **All new ZNP public pages must follow these rules without exception.**

### Page List

| Page          | URL (Dev)              | Blade File                         | Status    |
|---------------|------------------------|------------------------------------|-----------|
| Home          | `/`                    | `resources/views/znp/home.blade.php`          | ✅ Done   |
| Jobs          | `/jobs`                | `resources/views/znp/jobs.blade.php`          | ✅ Done   |
| Employer Auth | `/company/employer-auth` | `resources/views/znp/employer-auth.blade.php` | ✅ Done   |
| About         | `/about-page`          | pending                            | ⬜ Pending|
| Employers     | `/employers-page`      | pending                            | ⬜ Pending|

> Full page tracker with temp/real URLs: see `ZNP_PAGE_PROMPT_TEMPLATE.md`

### Mandatory Rules for Every New Page

1. **Layout**: `@extends('layouts.znp')` — never use `layouts/app.blade.php`
2. **CSS scope**: All styles inside `@push('styles')`, scoped to `.znp-{pagename}` — never write unscoped or `body {}` styles in page blades
3. **Scope reset block** — every page blade starts styles with:
   ```css
   .znp-{pagename}, .znp-{pagename} * { font-family: 'Inter', sans-serif !important; box-sizing: border-box; }
   .znp-{pagename} { font-size: 12px; background: var(--bg); color: var(--text); }
   ```
4. **No re-imports**: Inter font, Bootstrap, Font Awesome, jQuery — all loaded by `layouts/znp.blade.php`
5. **Header & footer outside wrapper**:
   ```blade
   @include('znp.header')  {{-- OUTSIDE .znp-{page} --}}
   <div class="znp-{pagename}"> ... </div>
   @include('znp.footer')  {{-- OUTSIDE .znp-{page} --}}
   ```
6. **Design source**: Convert from client-supplied HTML file pixel-perfect — use exact font sizes, padding, and spacings from the HTML, not approximations
7. **JS**: Vanilla JS only in `@push('scripts')` — prefix function names with `znp` to avoid global conflicts
