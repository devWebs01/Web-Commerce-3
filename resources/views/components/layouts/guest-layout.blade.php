<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
            rel="stylesheet">

        <title>{{ $title ?? "" }} | {{ $setting->name }}</title>

        @livewireStyles

        <!-- Bootstrap core CSS -->
        <link href="{{ asset("/guest/vendor/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet">

        <!-- Additional CSS Files -->
        <link rel="stylesheet" href="{{ asset("/guest/css/fontawesome.css") }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="{{ asset("/guest/css/templatemo-villa-agency.css") }}">
        <link rel="stylesheet" href="{{ asset("/guest/css/owl.css") }}">
        <link rel="stylesheet" href="{{ asset("/guest/css/animate.css") }}">
        <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

        @stack("css")

        <style>
            @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Reddit+Sans:ital,wght@0,200..900;1,200..900&display=swap');

            * {
                font-family: "Reddit Sans", sans-serif;
                font-optical-sizing: auto;
                font-weight: <weight>;
                font-style: normal;
            }

            .pagination {
                justify-content: center;
                --bs-pagination-active-bg: #000000;
                --bs-pagination-color: black;
            }

            .active>.page-link,
            .page-link.active {
                border-color: #000000;
            }

            .nav-pills .nav-link {
                color: black;
            }

            .nav-pills .nav-link.active,
            .nav-pills .show>.nav-link {
                color: white;
                background-color: black;
            }

            #font-custom {
                font-family: "DM Serif Display", serif;
                font-weight: 400;
                font-style: normal;
            }

            .font-stroke {
                text-shadow: 2px 2px #646262;
            }

            .btn-custom {
                padding: 12px 24px;
                background-color: white;
                border-radius: 6px;
                position: relative;
                overflow: hidden;
            }

            .btn-custom span {
                color: black;
                position: relative;
                z-index: 1;
                transition: color 0.6s cubic-bezier(0.53, 0.21, 0, 1);
            }

            .btn-custom::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                border-radius: 6px;
                transform: translate(-100%, -50%);
                width: 100%;
                height: 100%;
                background-color: hsl(244, 63%, 69%);
                transition: transform 0.6s cubic-bezier(0.53, 0.21, 0, 1);
            }

            .btn-custom:hover span {
                color: white;
            }

            .btn-custom:hover::before {
                transform: translate(0, -50%);
            }

            #parallax {
                /* Create the parallax scrolling effect */
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }

            .glitch {
                position: relative;
                font-size: 80px;
                font-weight: 700;
                line-height: 1.2;
                color: #000000;
                letter-spacing: 5px;
                animation: shift 4s ease-in-out infinite alternate;
                z-index: 1;
            }

            .glitch:before {
                content: attr(data-glitch);
                position: absolute;
                top: 0;
                left: -2px;
                text-shadow: -1px 0 #9afa95;
                width: 100%;
                color: #ffffff;
                overflow: hidden;
                clip: rect(0, 900px, 0, 0);
                animation: noise-before 3s infinite linear alternate-reverse;
            }

            .glitch:after {
                content: attr(data-glitch);
                position: absolute;
                top: 0;
                left: 2px;
                text-shadow: 1px 0 #ff1212;
                width: 100%;
                color: #000000;
                overflow: hidden;
                clip: rect(0, 900px, 0, 0);
                animation: noise-after 2s infinite linear alternate-reverse;
            }

            .item {
                display: flex;
                flex-direction: column;
                height: 100%;
                padding: 15px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);

                img {
                    object-fit: cover;
                    width: 100%;
                    height: 300px;
                }
            }

            .main-button {
                margin-top: auto;

                a {
                    border-radius: 0;
                }
            }

            .container {
                max-width: 1320px;
                margin-left: auto;
                margin-right: auto;
                padding-left: 1rem;
                padding-right: 1rem;
            }

            @media (max-width: 576px) {
                .container {
                    padding-left: 0.75rem;
                    padding-right: 0.75rem;
                }
            }
        </style>

        @vite([])
    </head>

    <body>

        <header class="px-3">
            <nav class="navbar navbar-expand-lg bg-body mb-3">
                <div class="container-fluid px-4 py-3 rounded-3 bg-dark">
                    <button class="navbar-toggler bg-white border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Brand (di tengah untuk layar besar, atas untuk kecil) -->
                    <a class="navbar-brand mx-auto d-lg-none text-center" href="/">
                        <span id="font-custom" class="text-white fw-bold fs-2">{{ $setting->name }}</span>
                    </a>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
                        <!-- Kiri -->
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-white fw-semibold" aria-current="page"
                                    href="/">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white fw-semibold"
                                    href="{{ route("catalog-products") }}">Katalog</a>
                            </li>
                        </ul>

                        <!-- Brand tengah (hanya muncul di layar besar) -->
                        <a class="navbar-brand d-none d-lg-block mx-auto" href="/">
                            <span id="font-custom" class="text-white fw-bold fs-2">{{ $setting->name }}</span>
                        </a>

                        <!-- Kanan -->
                        <div class="d-flex align-items-center gap-3">

                            @include("components.navigations.guest-nav")

                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- ***** Header Area End ***** -->
        @include("components.partials.payment")
        {{ $slot }}

        <footer class="py-4">
            <div class="container">
                <div class="row align-items-center py-4">
                    <div class="col-12 col-lg-3 text-center text-lg-start">
                        <span id="font-custom" class="text-white fw-bold fs-2">{{ $setting->name }}</span>
                    </div>
                    <div class="col-12 col-lg-6 navbar-expand text-center">
                        <ul class="list-unstyled d-block d-lg-flex justify-content-center mb-3 mb-lg-0">
                            <li class="nav-item">
                                <a class="text-white text-decoration-none me-lg-3" href="/">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a class="text-white text-decoration-none me-lg-3"
                                    href="{{ route("catalog-products") }}">Katalog</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-3 text-center text-lg-end text-white">
                        <a class="me-2 text-white" href="">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a class="me-2 text-white" href="">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a class="me-2 text-white" href="">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />

        <!-- Bootstrap core JavaScript -->
        <script src="{{ asset("/guest/vendor/jquery/jquery.min.js") }}"></script>
        <script src="{{ asset("/guest/vendor/bootstrap/js/bootstrap.min.js") }}"></script>
        <script src="{{ asset("/guest/js/isotope.min.js") }}"></script>
        <script src="{{ asset("/guest/js/owl-carousel.js") }}"></script>
        <script src="{{ asset("/guest/js/counter.js") }}"></script>
        <script src="{{ asset("/guest/js/custom.js") }}"></script>
        @stack("scripts")
        @livewireScripts
    </body>

</html>
