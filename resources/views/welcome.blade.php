<?php

use App\Models\Cart;
use App\Models\Product;
use function Laravel\Folio\name;
use function Livewire\Volt\{state, uses};
use Jantinnerezo\LivewireAlert\LivewireAlert;

name("welcome");

state([
    "products" => fn() => Product::inRandomOrder()->limit(6)->get(),
]);

$addToCart = function ($product_id) {
    if (Auth::check() && auth()->user()->role == "customer") {
        $user_id = auth()->id();

        $existingCart = Cart::where("user_id", $user_id)->where("product_id", $product_id)->first();

        if ($existingCart) {
            $this->alert("warning", "Layanan sudah ada di list.", [
                "position" => "top",
                "timer" => "2000",
                "toast" => true,
                "timerProgressBar" => true,
                "text" => "",
            ]);
        } else {
            Cart::create([
                "user_id" => $user_id,
                "product_id" => $product_id,
                "quantity" => 1, // Default quantity
            ]);

            $this->alert("success", "Layanan berhasil ditambahkan ke list.", [
                "position" => "top",
                "timer" => "2000",
                "toast" => true,
                "timerProgressBar" => true,
                "text" => "",
            ]);
        }

        $this->dispatch("cart-updated");
    } else {
        $this->redirect("/login");
    }
};

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

        /* Styling untuk teks pada slider */
        .header-text h2 {
            font-size: 3rem;
            /* Ukuran default untuk layar besar */
        }

        /* Mengubah ukuran teks pada layar kecil */
        @media (max-width: 767px) {
            .header-text h2 {
                font-size: 2rem;
                /* Ukuran lebih kecil untuk layar kecil */
            }
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
    </style>

    @volt
        <div>
            <!-- Banner Utama -->
            <div class="container main-banner">
                <div class="owl-carousel owl-banner">
                    <div class="item rounded rounded-5"
                        style="background-image: url('/guest/apola_image/banner1.jpg'); width:100%; max-height:900px; min-height: 500px; object-fit:cover;">
                        <div class="header-text">
                            <h2 id="font-custom" class="text-white font-stroke fs-1 fs-sm-2 fs-md-3">
                                Ubah Kendaraanmu Jadi Karya Seni Bergerak
                            </h2>
                        </div>
                    </div>
                    <div class="item rounded rounded-5"
                        style="background-image: url('/guest/apola_image/banner2.jpg'); width:100%; max-height:900px; min-height: 500px; object-fit:cover;">
                        <div class="header-text">
                            <h2 id="font-custom" class="text-white font-stroke fs-1 fs-sm-2 fs-md-3">
                                Desain Decal & Striping Premium, Tahan Lama
                            </h2>
                        </div>
                    </div>
                    <div class="item rounded rounded-5"
                        style="background-image: url('/guest/apola_image/banner3.jpg'); width:100%; max-height:900px; min-height: 500px; object-fit:cover;">
                        <div class="header-text">
                            <h2 id="font-custom" class="text-dark font-stroke fs-1 fs-sm-2 fs-md-3">
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
                            <div class="col-lg-4 col-md-6">
                                <div class="item">
                                    <a href="{{ route("product-detail", ["product" => $product->id]) }}">
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}"
                                            class="object-fit-cover" style="width:100%; height:300px;">
                                    </a>
                                    <span class="category">
                                        {{ Str::limit($product->category->name, 13, "...") }}
                                    </span>
                                    <h6>
                                        {{ "Rp. " . Number::format($product->price, locale: "id") }}
                                    </h6>
                                    <h4>
                                        <a href="{{ route("product-detail", ["product" => $product->id]) }}">
                                            {{ Str::limit($product->title, 50, "...") }}
                                        </a>
                                    </h4>
                                    <div class="main-button">
                                        <a href="{{ route("product-detail", ["product" => $product->id]) }}">Pesan
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
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-4 text-center mb-4">
                                    <div class="step-icon mx-auto border border-2 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:150px;height:150px;">
                                        <i class="fa-solid display-3 fa-headset"></i>
                                    </div>
                                    <p class="mt-2 fw-bold">Konsultasi & Desain</p>
                                </div>
                                <div class="col-lg-4 text-center mb-4">
                                    <div class="step-icon mx-auto border border-2 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:150px;height:150px;">
                                        <i class="fa-solid display-3 fa-cubes"></i>
                                    </div>
                                    <p class="mt-2 fw-bold">Produksi & Quality Check</p>
                                </div>
                                <div class="col-lg-4 text-center mb-4">
                                    <div class="step-icon mx-auto border border-2 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:150px;height:150px;">
                                        <i class="fa-solid display-3 fa-truck-fast"></i>
                                    </div>
                                    <p class="mt-2 fw-bold">Pengiriman & Pemasangan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Video Showcase -->
            <div class="video section" id="parallax" style="background-image: url('/guest/apola_image/thumbnail.jpg');">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 offset-lg-4">
                            <div class="section-heading text-center">
                                <button class="btn btn-dark btn-sm rounded">| CABERACER.ID</button>
                                <h2 class="mt-3">Lihat Proses Kami</h2>
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
                                    <source src="{{ asset("/guest/apola_image/videos.mp4") }}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-guest-layout>
