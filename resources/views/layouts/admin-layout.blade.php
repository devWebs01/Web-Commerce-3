<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? '' }} - Ecommerce Web</title>
    <link rel="shortcut icon" type="image/png" href="/admin/images/logos/favicon.png" />

    @livewireStyles

    <link rel="stylesheet" href="{{ asset('/admin/css/styles.min.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap');

        * {
            font-family: "DM Sans", sans-serif;
            font-optical-sizing: auto;
        }

        .btn-danger {
            --bs-btn-bg: #fc3a4e;
        }
    </style>

    @stack('css')

    @vite([])
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            @livewire('layout.admin-nav')
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header d-print-none">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="https://source.boringavatars.com/beam/120/{{ auth()->user()->name }}"
                                        alt="" width="50" height="50" class="rounded-circle border">
                                </a>
                                @livewire('layout.admin-header')
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    <nav class="d-print-none"
                        style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                        aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @if (isset($header))
                                {{ $header }}
                            @endif
                        </ol>
                    </nav>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/admin/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/admin/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('/admin/js/app.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('/admin/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('/admin/js/dashboard.js') }}"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    @stack('scripts')

    @livewireChartsScripts
    @livewireScripts
</body>

</html>
