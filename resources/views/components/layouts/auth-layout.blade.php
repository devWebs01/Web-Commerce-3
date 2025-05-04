<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? "" }}</title>
        <link rel="shortcut icon" type="image/png" href="/admin/images/logos/favicon.png" />

        @livewireStyles

        <link rel="stylesheet" href="{{ asset("/guest/css/fontawesome.css") }}">

        <link rel="stylesheet" href="{{ asset("/admin/css/styles.min.css") }}" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Reddit+Sans:ital,wght@0,200..900;1,200..900&display=swap');

            * {
                font-family: "Reddit Sans", sans-serif;
                font-optical-sizing: auto;
                font-weight: <weight>;
                font-style: normal;
            }

            #font-custom {
                font-family: "DM Serif Display", serif;
                font-weight: 400;
                font-style: normal;
            }
        </style>

        @stack("css")

        @vite([])
    </head>

    <body>

        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
            data-sidebar-position="fixed" data-header-position="fixed">
            <div
                class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
                <div class="d-flex align-items-center justify-content-center w-100">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script src="{{ asset("/admin/libs/jquery/dist/jquery.min.js") }}"></script>
        <script src="{{ asset("/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js") }}"></script>
        <script src="{{ asset("/admin/js/sidebarmenu.js") }}"></script>
        <script src="{{ asset("/admin/js/app.min.js") }}"></script>
        <script src="{{ asset("/admin/libs/apexcharts/dist/apexcharts.min.js") }}"></script>
        <script src="{{ asset("/admin/libs/simplebar/dist/simplebar.js") }}"></script>
        <script src="{{ asset("/admin/js/dashboard.js") }}"></script>
        <!-- solar icons -->
        <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

        @stack("scripts")

        @livewireScripts
    </body>

</html>
