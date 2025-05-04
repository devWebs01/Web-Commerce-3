<?php

use App\Models\Product;
use function Laravel\Folio\name;
use function Livewire\Volt\{state};

name("welcome");

state([
    "products" => fn() => Product::inRandomOrder()->limit(6)->get(),
]);

?>

<x-guest-layout>
    <x-slot name="title">CABERACER - Modifikasi Visual Kendaraan</x-slot>

    <style>
        .hover {
            --c: #565cff;
            color: #0000;
            background:
                linear-gradient(90deg, #fff 50%, var(--c) 0) calc(100% - var(--_p, 0%))/200% 100%,
                linear-gradient(var(--c) 0 0) 0% 100%/var(--_p, 0%) 100% no-repeat;
            -webkit-background-clip: text, padding-box;
            background-clip: text, padding-box;
            transition: 0.5s;
            font-weight: bolder;
        }

        .hover:hover {
            --_p: 100%
        }

        /* Styling untuk slider height */
        .main-banner .owl-carousel .item {
            height: 50vh;
            /* Set tinggi slider menjadi 50% dari tinggi layar pada layar kecil */
        }

        @media (min-width: 768px) {
            .main-banner .owl-carousel .item {
                height: 70vh;
                /* Tinggi slider lebih besar pada layar besar */
            }
        }

        .video-content {
            position: relative;
            width: 100%;
            /* height: 100vh; */
            /* full viewport height */
            overflow: hidden;
        }

        .video-frame video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: 300px;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }
    </style>

    @volt
        <div>
            <!-- Banner Utama -->
            <div class="container main-banner">
                <div class="owl-carousel owl-banner">
                    <div class="item rounded "
                        style="background-image: url('https://i.pinimg.com/originals/23/06/22/2306226d78a452b706699c469cc5e1ec.jpg'); width:100%; max-height:900px; min-height: 500px;
           background-size: cover; background-position: center; background-repeat: no-repeat;">
                        <div class="header-text">
                            <h2 id="font-custom" class="text-white font-stroke fs-1 fs-sm-2 fs-md-3">
                                Ubah Kendaraanmu Jadi Karya Seni Bergerak
                            </h2>
                        </div>
                    </div>
                    <div class="item rounded "
                        style="background-image: url('https://i.pinimg.com/originals/bf/d9/77/bfd9774c993ada1dfb8144bf7b6d73a7.jpg'); width:100%; max-height:900px; min-height: 500px;
           background-size: cover; background-position: center; background-repeat: no-repeat;">
                        <div class="header-text">
                            <h2 id="font-custom" class="text-white font-stroke fs-1 fs-sm-2 fs-md-3">
                                Desain Decal & Striping Premium, Tahan Lama
                            </h2>
                        </div>
                    </div>
                    <div class="item rounded "
                        style="background-image: url('https://i.pinimg.com/originals/20/c9/d9/20c9d9921d5486f120cb96784720b044.jpg'); width:100%; max-height:900px; min-height: 500px;
           background-size: cover; background-position: center; background-repeat: no-repeat;">
                        <div class="header-text">
                            <h2 id="font-custom" class="text-white font-stroke fs-1 fs-sm-2 fs-md-3">
                                Wrapping Kendaraan: Ganti Warna Tanpa Cat Permanen
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Koleksi Layanan -->
            <div class="properties section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 offset-lg-4">
                            <div class="section-heading text-center">
                                <h6>| Layanan Kami</h6>
                                <h2 id="font-custom" class="fw-bold">Kustom Visual untuk Motor & Mobil</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="item">
                                    <a href="{{ route("product-detail", ["product" => $product->id]) }}">
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}"
                                            class="object-fit-cover" style="width:100%; height:300px;">
                                    </a>
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <span class="category fw-bold">
                                            {{ Str::limit($product->category->name, 13, "...") }}
                                        </span>
                                        <h6>
                                            {{ formatRupiah($product->price) }}
                                        </h6>
                                    </div>

                                    <h4>
                                        <a href="{{ route("product-detail", ["product" => $product->id]) }}">
                                            {{ Str::limit($product->title, 50, "...") }}
                                        </a>
                                    </h4>
                                    <div class="main-button">
                                        <a class="rounded-3"
                                            href="{{ route("product-detail", ["product" => $product->id]) }}">Beli
                                            Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Proses Pemesanan -->
            <section class="py-5">
                <div class="container">
                    <div class="row text-center mb-0">
                        <div class="col-12 col-lg-10 col-xl-8 mx-auto section-heading">
                            <h6>| Mengapa CABERACER?</h6>
                            <h2 class="fw-bold" id="font-custom">
                                Proses Mudah & Cepat
                                <span class="hover">Hasil Maksimal</span>
                            </h2>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-4 text-center mb-4">
                                    <div class="step-icon mx-auto border border-2 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:150px;height:150px;">
                                        <i class="fa-solid display-3 fa-headset">

                                        </i>
                                    </div>
                                    <p class="mt-2 fw-bold">Konsultasi & Desain</p>
                                </div>
                                <div class="col-md-4 text-center mb-4">
                                    <div class="step-icon mx-auto border border-2 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:150px;height:150px;">
                                        <i class="fa-solid display-3 fa-cubes">

                                        </i>
                                    </div>
                                    <p class="mt-2 fw-bold">Produksi & Quality Check</p>
                                </div>
                                <div class="col-md-4 text-center mb-4">
                                    <div class="step-icon mx-auto border border-2 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:150px;height:150px;">
                                        <i class="fa-solid display-3 fa-truck-fast">

                                        </i>
                                    </div>
                                    <p class="mt-2 fw-bold">Pengiriman & Pemasangan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Video Showcase -->
            <div class="video section" id="parallax" style="background-image: url('/guest/web_image/thumbnail.jpg');">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8">
                        <button class="btn btn-dark btn-sm rounded">| Kunjungi Lokasi Kami</button>

                        <h2 class="fw-bold py-2 text-white">Langsung datang ke <strong class="hover">CabeRacer Workshop
                                Jambi</strong>
                            dan rasakan
                            sendiri kualitas layanan serta produk terbaik kami!</h2>
                        <p class="text-white">Temukan kami dengan mudah melalui peta di bawah ini. Kami siap
                            melayani Anda
                            secara langsung dengan sepenuh hati.</p>

                        <a href="https://maps.google.com/maps/dir//CabeRacer+Workshop+Jambi+9J3Q%2BQQX+Lkr.+Sel.+Kec.+Jambi+Sel.,+Kota+Jambi,+Jambi+36127/@-1.6455095,103.6394985,11z/data=!4m5!4m4!1m0!1m2!1m1!1s0x2e2585e0fe876bcd:0xee149e08d342028c"
                            class="btn btn-primary mb-0">Lihat Peta</a>
                    </div>
                </div>
            </div>

            <div class="video-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="video-frame ratio ratio-16x9">
                                <video class="rounded" controls muted loop autoplay>
                                    <source src="{{ asset("/guest/web_image/videos.mp4") }}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-guest-layout>
