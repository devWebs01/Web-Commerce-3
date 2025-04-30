<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>{{ $title ?? '' }} | {{ $setting->name }}</title>

    @livewireStyles

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/guest/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('/guest/css/fontawesome.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('/guest/css/templatemo-villa-agency.css') }}">
    <link rel="stylesheet" href="{{ asset('/guest/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('/guest/css/animate.css') }}">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    @stack('css')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Reddit+Sans:ital,wght@0,200..900;1,200..900&display=swap');

        * {
            font-family: "Reddit Sans", sans-serif;
            font-optical-sizing: auto;
            /* font-weight: <weight>;
            font-style: normal; */
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

        @keyframes noise-before {
            0% {
                clip: rect(61px, 9999px, 52px, 0);
            }

            5% {
                clip: rect(33px, 9999px, 144px, 0);
            }

            10% {
                clip: rect(121px, 9999px, 115px, 0);
            }

            15% {
                clip: rect(144px, 9999px, 162px, 0);
            }

            20% {
                clip: rect(62px, 9999px, 180px, 0);
            }

            25% {
                clip: rect(34px, 9999px, 42px, 0);
            }

            30% {
                clip: rect(147px, 9999px, 179px, 0);
            }

            35% {
                clip: rect(99px, 9999px, 63px, 0);
            }

            40% {
                clip: rect(188px, 9999px, 122px, 0);
            }

            45% {
                clip: rect(154px, 9999px, 14px, 0);
            }

            50% {
                clip: rect(63px, 9999px, 37px, 0);
            }

            55% {
                clip: rect(161px, 9999px, 147px, 0);
            }

            60% {
                clip: rect(109px, 9999px, 175px, 0);
            }

            65% {
                clip: rect(157px, 9999px, 88px, 0);
            }

            70% {
                clip: rect(173px, 9999px, 131px, 0);
            }

            75% {
                clip: rect(62px, 9999px, 70px, 0);
            }

            80% {
                clip: rect(24px, 9999px, 153px, 0);
            }

            85% {
                clip: rect(138px, 9999px, 40px, 0);
            }

            90% {
                clip: rect(79px, 9999px, 136px, 0);
            }

            95% {
                clip: rect(25px, 9999px, 34px, 0);
            }

            100% {
                clip: rect(173px, 9999px, 166px, 0);
            }
        }

        @keyframes noise-after {
            0% {
                clip: rect(26px, 9999px, 33px, 0);
            }

            5% {
                clip: rect(140px, 9999px, 198px, 0);
            }

            10% {
                clip: rect(184px, 9999px, 89px, 0);
            }

            15% {
                clip: rect(121px, 9999px, 6px, 0);
            }

            20% {
                clip: rect(181px, 9999px, 99px, 0);
            }

            25% {
                clip: rect(154px, 9999px, 133px, 0);
            }

            30% {
                clip: rect(134px, 9999px, 169px, 0);
            }

            35% {
                clip: rect(26px, 9999px, 187px, 0);
            }

            40% {
                clip: rect(147px, 9999px, 137px, 0);
            }

            45% {
                clip: rect(31px, 9999px, 52px, 0);
            }

            50% {
                clip: rect(191px, 9999px, 109px, 0);
            }

            55% {
                clip: rect(74px, 9999px, 54px, 0);
            }

            60% {
                clip: rect(145px, 9999px, 75px, 0);
            }

            65% {
                clip: rect(153px, 9999px, 198px, 0);
            }

            70% {
                clip: rect(99px, 9999px, 136px, 0);
            }

            75% {
                clip: rect(118px, 9999px, 192px, 0);
            }

            80% {
                clip: rect(1px, 9999px, 83px, 0);
            }

            85% {
                clip: rect(145px, 9999px, 98px, 0);
            }

            90% {
                clip: rect(121px, 9999px, 154px, 0);
            }

            95% {
                clip: rect(156px, 9999px, 44px, 0);
            }

            100% {
                clip: rect(67px, 9999px, 122px, 0);
            }
        }

        @keyframes shift {

            0%,
            40%,
            44%,
            58%,
            61%,
            65%,
            69%,
            73%,
            100% {
                transform: skewX(0deg);
            }

            41% {
                transform: skewX(10deg);
            }

            42% {
                transform: skewX(-10deg);
            }

            59% {
                transform: skewX(40deg) skewY(10deg);
            }

            60% {
                transform: skewX(-40deg) skewY(-10deg);
            }

            63% {
                transform: skewX(10deg) skewY(-5deg);
            }

            70% {
                transform: skewX(-50deg) skewY(-20deg);
            }

            71% {
                transform: skewX(10deg) skewY(-10deg);
            }
        }
    </style>

    @vite([])
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg bg-body mb-3">
            <div class="container border rounded-5 p-3">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <span id="font-custom" class=" fw-bold fs-2">{{ $setting->name }}</span>
                </a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">
                                </i>Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('catalog-products') }}">
                                Katalog
                            </a>
                        </li>
                    </ul>
                    <div class="gap-5">
                        @livewire('layout.guest-nav')
                    </div>
                </div>

            </div>
        </nav>
    </header>
    <!-- ***** Header Area End ***** -->
    @include('layouts.payment')
    {{ $slot }}

    <footer class="py-0 sticky-md-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-3 text-center text-lg-start">
                    <span id="font-custom" class="text-white fw-bold fs-2">{{ $setting->name }}</span>
                </div>
                <div class="col-12 col-lg-6 navbar-expand text-center">
                    <p class="fw-bold">
                        {{ $setting->province->name }},
                        {{ $setting->city->name }},
                        {{ $setting->city->postal_code }},
                        Indonesia
                    </p>
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
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('/guest/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/guest/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/guest/js/isotope.min.js') }}"></script>
    <script src="{{ asset('/guest/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('/guest/js/counter.js') }}"></script>
    <script src="{{ asset('/guest/js/custom.js') }}"></script>

    @stack('scripts')

    @livewireScripts

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-livewire-alert::scripts />
</body>

</html>
