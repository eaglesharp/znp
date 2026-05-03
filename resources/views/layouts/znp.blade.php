<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', 'Immediate joiner & zero-notice jobs in India | ZeroNoticePeriod')</title>

    {{-- Bootstrap 4 --}}
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- Inter font (used across all ZNP new-design pages) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- jQuery UI CSS (needed for autocomplete widget on home/search pages) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    {{-- ZNP master stylesheet: design tokens + shared components --}}
    <link href="{{ asset('css/znp-common.css') }}?v={{ filemtime(public_path('css/znp-common.css')) }}" rel="stylesheet">

    {{-- Page-specific styles injected here --}}
    @stack('styles')
</head>
<body>

    @yield('content')

    {{-- jQuery --}}
    <script src="{{ asset('asset/script/jquery-3.5.1.min.js') }}"></script>

    {{-- Bootstrap JS --}}
    <script src="{{ asset('asset/script/bootstrap.min.js') }}"></script>

    {{-- jQuery UI JS (needed for autocomplete widget on home/search pages) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    {{-- Page-specific scripts injected here --}}
    @stack('scripts')

</body>
</html>
