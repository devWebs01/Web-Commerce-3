<?php

use function Livewire\Volt\{state, rules, computed};
use App\Models\Category;
use App\Models\Product;
use function Laravel\Folio\name;

name('welcome');

state([
    'products' => fn() => Product::latest()->limit(6)->get(),
]);

?>

<x-guest-layout>
    <x-slot name="title">Selamat Datang</x-slot>
    <style>
        .hover {
            --c: #9c9259;
            /* the color */

            color: #0000;
            background:
                linear-gradient(90deg, #fff 50%, var(--c) 0) calc(100% - var(--_p, 0%))/200% 100%,
                linear-gradient(var(--c) 0 0) 0% 100%/var(--_p, 0%) 100% no-repeat;
            -webkit-background-clip: text, padding-box;
            background-clip: text, padding-box;
            transition: 0.5s;
            border-radius: 10px;
        }

        .hover:hover {
            --_p: 100%
        }
    </style>
    @volt
        <div>

            <section class="my-lg-9 py-5">
                <div class="container">
                    <div class="row flex-row-reverse align-items-center ">
                        <div class="col-lg-8">
                            <div class="image-holder text-end">
                                <img src="https://demo.templatesjungle.com/serene/images/banner-image1.png" alt="banner"
                                    class="img-fluid ">
                            </div>
                        </div>
                        <div class="col-lg-4 mt-5 mt-lg-0">
                            <div class="banner-content ">
                                <h6 class="sub-heading">Produk Kecantikkan</h6>
                                <h2 id="font-custom" class="display-3 fw-semibold my-2 my-lg-3">Perawatan kulit mudah &
                                    terjangkau.
                                </h2>
                                <p class="fs-5">Dapatkan perawatan kulit terbaik dengan produk-produk berkualitas tinggi
                                    yang aman, alami, dan organik. Nikmati hasil yang maksimal dengan harga terjangkau. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- <section class="my-5">
                <div class="container-lg">
                    <div class="row align-items-center ">
                        <div class="col-lg-6">
                            <div class="image-holder">
                                <img src="https://demo.templatesjungle.com/serene/images/banner-image2.png" alt="banner"
                                    class="img-fluid ">
                            </div>
                        </div>
                        <div class="col-lg-6 mt-5 mt-lg-0">
                            <div class="banner-content ">
                                <ul class="nav nav-tabs d-block border-0" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link border-0 text-start p-0" id="safe-tab" disabled
                                            data-bs-toggle="tab" data-bs-target="#safe-tab-pane" type="button"
                                            role="tab" aria-controls="safe-tab-pane" aria-selected="true">
                                            <h6 class="sub-heading m-0">01</h6>
                                            <h2 id="font-custom" class="display-3 hover fw-semibold mb-5 ">100% Aman</h2>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link border-0 text-start p-0" id="natural-tab"
                                            data-bs-toggle="tab" data-bs-target="#natural-tab-pane" type="button"
                                            role="tab" aria-controls="natural-tab-pane" aria-selected="false"
                                            tabindex="-1" disabled>
                                            <h6 class="sub-heading m-0">02</h6>
                                            <h2 id="font-custom" class="display-3 hover fw-semibold mb-5">Natural</h2>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link border-0 text-start p-0 rounded" id="organic-tab"
                                            data-bs-toggle="tab" data-bs-target="#organic-tab-pane" type="button"
                                            role="tab" aria-controls="organic-tab-pane" aria-selected="false"
                                            tabindex="-1" disabled>
                                            <h6 class="sub-heading m-0">03</h6>
                                            <h2 id="font-custom" class="hover display-3 fw-semibold mb-5">Organik</h2>
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="safe-tab-pane" role="tabpanel"
                                        aria-labelledby="safe-tab" tabindex="0">
                                        <p class="fs-5">Dengan produk kami, Anda dapat merasakan manfaat perawatan kulit
                                            yang aman, lembut, dan efektif. Kulit Anda akan terjaga dengan baik, terhidar
                                            dari iritasi dan masalah kulit lainnya.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> --}}

            <div class="container-lg py-5">
                <div class="row flex-row-reverse align-items-center ">
                    <div class="col-lg-8">
                        <div class="image-holder text-end">
                            <img src="https://demo.templatesjungle.com/serene/images/banner-image3.png" alt="banner"
                                class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-4  mt-5 mt-lg-0">
                        <div class="banner-content ">
                            <h6 class="sub-heading">Aran Terbatas? Tak Masalah!</h6>
                            <h2 id="font-custom" class="display-3 fw-semibold my-2 my-lg-3">Dapatkan Kemudahan Berbelanja
                            </h2>
                            <p class="fs-5">Dapatkan produk berkualitas dengan proses
                                pembelian yang mudah. Nikmati pengalaman belanja yang lancar, tanpa terkendala apa pun.
                            </p>
                            <a href="{{ route('catalog-products') }}"
                                class="btn btn-outline-dark text-uppercase mt-4 mt-lg-5">Belanja Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container pt-5">
                <div class="row align-items-center my-lg-9">
                    <div class="col-lg-6">
                        <div class="banner-content ">
                            <h6>Populer Sekarang</h6>
                            <h2 id="font-custom" class="display-3 fw-semibold my-2 my-lg-3">Produk Perawatan Kulit
                                Terpopuler
                            </h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <p class="fs-5">Temukan produk perawatan kulit terpopuler kami yang dapat memenuhi kebutuhan Anda.
                            Lihat rangkaian produk kami di bawah ini: </p>
                        <a href="{{ route('catalog-products') }}"
                            class="btn btn-outline-dark text-uppercase mt-4 mt-lg-5">Lihat Semua Produk</a>
                    </div>
                </div>
                <hr>
            </div>

            <div class="properties section mt-5">
                <div class="container">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6">
                                <div class="item bg-body border ">
                                    <a href="{{ route('product-detail', ['product' => $product->id]) }}"><img
                                            src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}"
                                            class="object-fit-cover "
                                            style="width: 100%; height: 300px;"></a>
                                    <span class="category text-white" style="background-color: #9c9259;">
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
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="container">
                <section class="py-5 my-md-5 border rounded-5" style="background-color: #9c9259;">
                    <div class="container">
                        <div class="row justify-content-center text-center text-white py-4">
                            <div class="col-lg-8">
                                <span>Daftar Sekarang</span>
                                <h2 id="font-custom" class="display-5 fw-bold my-2">Mulai Hari Ini Juga!</h2>
                                <p class="lead text-white">Bergabunglah dengan kami dan rasakan manfaat dari produk-produk
                                    perawatan kulit berkualitas tinggi. </p>
                                <div class=" mt-5 d-grid col-3 mx-auto">
                                    <a class="btn btn-dark text-uppercase " href="{{ route('login') }}"
                                        type="submit">Daftar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    @endvolt
</x-guest-layout>
