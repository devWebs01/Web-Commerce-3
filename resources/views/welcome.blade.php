<?php

use function Livewire\Volt\{state, rules, computed};
use App\Models\Category;
use App\Models\Product;
use function Laravel\Folio\name;

name('welcome');

state([
    'products' => fn() => Product::inRandomOrder()->limit(6)->get(),
]);

?>

<x-guest-layout>
    <x-slot name="title">Selamat Datang</x-slot>

    <style>
        .hover {
            --c: #ff8e56;
            /* the color */

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
    </style>

    @volt
        <div>
            <div class="container main-banner">
                <div class="owl-carousel owl-banner">
                    <div class="item item-1 rounded rounded-5"
                        style="background-image: url('/guest/apola_image/banner1.jpg'); width: 100%; height: 900px; object-fit: cover;">
                        <div class="header-text">
                            <h2 id="font-custom" class="text-white font-stroke">
                                Tren fashion terbaru, hanya di jarak selangkah.
                            </h2>
                        </div>
                    </div>
                    <div class="item item-2 rounded rounded-5"
                        style="background-image: url('/guest/apola_image/banner2.jpg'); width: 100%; height: 900px; object-fit: cover;">
                        <div class="header-text">
                            <h2 id="font-custom" class="text-white font-stroke">Percayakan gaya Anda pada kami.
                            </h2>
                        </div>
                    </div>
                    <div class="item item-3 rounded rounded-5"
                        style="background-image: url('/guest/apola_image/banner3.jpg'); width: 100%; height: 900px; object-fit: cover;">
                        <div class="header-text">
                            <h2 id="font-custom" class="text-dark font-stroke">Bergaya sesuai kepribadian Anda dengan
                                koleksi eksklusif kami.
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="properties section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 offset-lg-4">
                            <div class="section-heading text-center">
                                <h6>| Koleksi Kami</h6>
                                <h2 id="font-custom" class="fw-bold">Lihat apa yang bisa kamu temukan disini</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6">
                                <div class="item">
                                    <a href="{{ route('product-detail', ['product' => $product->id]) }}"><img
                                            src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}"
                                            class="object-fit-cover" style="width: 100%; height: 300px;"></a>
                                    <span class="category">
                                        {{ Str::limit($product->category->name, 13, '...') }}
                                    </span>
                                    <h6>
                                        {{ 'Rp. ' . Number::format($product->price, locale: 'id') }}
                                    </h6>
                                    <h4>
                                        <a href="{{ route('product-detail', ['product' => $product->id]) }}">
                                            {{ Str::limit($product->title, 50, '...') }}
                                        </a>
                                    </h4>
                                    <div class="main-button">
                                        <a href="{{ route('product-detail', ['product' => $product->id]) }}">Beli
                                            Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <section class="py-5">
                <div class="container">
                    <!--- Heading -->
                    <div class="row text-center mb-0">
                        <div class="col-12 col-lg-10 col-xl-8 mx-auto text-center section-heading">
                            <h6>| Bersama APOLA</h6>
                            <h2 class="fw-bold" id="font-custom">Dapatkan produk favorit kamu
                                <span class="hover">diantar ke depan pintumu</span>
                            </h2>
                        </div>
                    </div><!--- Steps Wrap -->
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <div class="row">
                                <!-- Step -->
                                <div class="col-lg-4">
                                    <div class="text-center position-relative">
                                        <!-- Step Icon -->
                                        <div class="step-icon mx-auto border border-2 border rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:150px;height:150px">
                                            <img src="/guest/apola_image/LOGO-JNT.png" class="m-3">

                                        </div>
                                    </div>
                                </div><!-- Step -->
                                <div class="col-lg-4">
                                    <div class="text-center position-relative">
                                        <!-- Step Icon -->
                                        <div class="step-icon mx-auto border border-2 border rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 150px;height: 150px;">
                                            <img src="/guest/apola_image/LOGO-TIKI.png" class="m-3">
                                        </div>

                                    </div>
                                </div><!-- Step -->
                                <div class="col-lg-4">
                                    <div class="text-center position-relative">
                                        <!--- Step Icon -->
                                        <div class="step-icon mx-auto border border-2 border rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 150px;height: 150px;">
                                            <img src="/guest/apola_image/LOGO-POS-IND.png" class="m-3">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <div class="video section" id="parallax" style="background-image: url('/guest/apola_image/thumbnail.jpg');">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 offset-lg-4">
                            <div class="section-heading text-center">
                                <div class="glitch-wrapper">
                                    <button class="btn btn-dark btn-sm rounded">| APOLA.CO.ID</button>
                                    <h2 class="glitch" data-glitch="Beli Sekarang!!!"></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="video-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="video-frame ratio ratio-16x9">
                                <video class="rounded-5" muted loop autoplay>
                                    <source src="{{ asset('/guest/apola_image/videos.mp4') }}" type="video/mp4">
                                </video>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-guest-layout>
