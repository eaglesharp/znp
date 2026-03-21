<?php

if (!isset($seo)) {
    $seo = (object) ['seo_title' => $siteSetting->site_name, 'seo_description' => $siteSetting->site_name, 'seo_keywords' => $siteSetting->site_name, 'seo_other' => ''];
}

?>



<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" class="{{ session('localeDir', 'ltr') }}"
    dir="{{ session('localeDir', 'ltr') }}">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ZeroNoticePeriod</title>

    <link href="{{ asset('/') }}asset/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

    <link href="{{ asset('/') }}asset/bootstrap-tagsinput.css" rel="stylesheet">

    <link href="{{ asset('/') }}asset/select2.min.css" rel="stylesheet">

    <link href="{{ asset('/') }}asset/datepicker.min.css" rel="stylesheet">

    <link href="{{ asset('/') }}asset/css/style.css?v={{ time() }}" rel="stylesheet">

    <link href="{{ asset('/') }}asset/css/jb.css?v=2" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <link rel="stylesheet"
        href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css"
        integrity="sha512-/Ae8qSd9X8ajHk6Zty0m8yfnKJPlelk42HTJjOHDWs1Tjr41RfsSkceZ/8yyJGLkxALGMIYd5L2oGemy/x1PLg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <meta property='og:title' content='ZeroNoticePeriod' />
    <meta property='og:image' content='{{ asset('asset/images/link.png') }}' />
    <meta property='og:description' content='ZeroNoticePeriod' />
    <meta property='og:url' content='{{ url('/') }}' />
    <!--<link rel="icon" href="{{ asset('asset/images/favicon.png') }}" type="image/x-icon">-->


    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/63a57fcbb0d6371309d5cd21/1go5di0l3';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    @stack('styles')

    <style>
        .toast-message {
            color: rgb(255, 255, 255) !important;
        }

        .toast-success {
            background-color: #0642a9 !important;
        }
    </style>

</head>



<body>
    <!--<body oncontextmenu="return false;">-->



    @yield('content')





    <script src="{{ asset('/') }}asset/script/docx-preview.js"></script>
    <script src="{{ asset('/') }}asset/script/popper.min.js"></script>
    <script src="{{ asset('/') }}asset/script/jquery-3.5.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>

    <script src="{{ asset('/') }}asset/script/bootstrap.min.js"></script>

    <script src="{{ asset('/') }}asset/script/jquery.validate.js"></script>

    <script src="{{ asset('/') }}asset/script/bootstrap-tagsinput.min.js"></script>

    <script src="{{ asset('/') }}asset/script/select2.full.min.js"></script>

    <script src="{{ asset('/') }}asset/script/bootstrap-datepicker.min.js"></script>

    <script src="{{ asset('/') }}asset/script/script.js"></script>

    <script src="{{ asset('/') }}asset/script/collection.js"></script>

    <script src="{{ asset('/') }}js/bootstrap-multiselect.min.js"></script>


    <!-- additional -->




    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.js"></script>


    <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"
        integrity="sha512-2xXe2z/uA+2SyT/sTSt9Uq4jDKsT0lV4evd3eoE/oxKih8DSAsOF6LUb+ncafMJPAimWAXdu9W+yMXGrCVOzQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="{{ asset('/') }}asset/script/bulkmail.js"></script>


    @stack('scripts')


    <script>
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>

</body>



</html>
