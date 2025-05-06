<?php

use function Laravel\Folio\name;
use function Livewire\Volt\{state, computed};
use App\Models\{Category, Product, Cart, Variant, User};

name("cashier.index");

state(["search"])->url();

state([
    // Get Data
    "categories" => fn() => Category::get(),
    "category_id" => "",
    "user" => fn() => User::whereEmail("offline@testing.com")->first(),
    "user_id" => fn() => $this->user->id,

    // Select Product & Variant
    "variant_id" => "",
    "qty" => 1,
    "variant_type" => "",
    "variant_stock" => "",
    "variant" => "",
    "product_id" => "",
]);

$selectVariant = function (Variant $variant) {
    $this->variant = $variant->stock;
    $this->variant_id = $variant->id;
    $this->variant_type = $variant->type;
    $this->variant_stock = $variant->stock;
};

// addToCart sekarang terima productId juga
$addToCart = function (int $productId) {
    // validasi sudah ada variant
    if (!$this->variant_id) {
        $this->alert("error", "Silakan pilih varian terlebih dahulu");
        return;
    }
    $existing = Cart::where("user_id", $this->user_id)->where("variant_id", $this->variant_id)->first();

    if ($existing) {
        $newQty = $existing->qty + $this->qty;
        if ($newQty > $this->variant_stock) {
            $this->alert("error", "Stok tidak mencukupi");
            return;
        }
        $existing->update(["qty" => $newQty]);
    } else {
        Cart::create([
            "user_id" => $this->user_id,
            "product_id" => $productId,
            "variant_id" => $this->variant_id,
            "qty" => $this->qty,
        ]);
    }

    $this->dispatch("cart-updated");
};

$products = computed(function () {
    // Dapatkan semua buku jika tidak ada search dan category
    if (!$this->search && !$this->category_id) {
        return Product::latest()->get();
    }

    // Dapatkan buku berdasarkan search
    elseif ($this->search && !$this->category_id) {
        return Product::where("title", "like", "%" . $this->search . "%")
            ->latest()
            ->get();
    }

    // Dapatkan buku berdasarkan category
    elseif (!$this->search && $this->category_id) {
        return Product::where("category_id", $this->category_id)->latest()->get();
    }

    // Dapatkan buku berdasarkan search dan category
    else {
        return Product::where("title", "like", "%" . $this->search . "%")
            ->where("category_id", $this->category_id)
            ->latest()
            ->get();
    }
});

$selectedCategoryId = function ($id) {
    if ($id) {
        $this->category_id = $id;
    } else {
        return null;
    }
};

?>

<x-admin-layout>
    <x-slot name="title">Kasir</x-slot>

    @volt
        <div class="card">
            <div class="card-body">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Hey, {{ auth()->user()->name }}
                    </h3>
                </div>
                <!-- Main Grid -->
                <div class="row">
                    <!-- Left / Main content -->
                    <div class="col-lg-8">
                        <!-- Banner -->
                        <div class="banner d-flex align-items-center px-4 mb-4"
                            style="background: linear-gradient(135deg, #ff7e5f, #feb47b);">
                            <div>
                                <h4 class="text-white">
                                    Pembelian di Tempat<br>
                                    <small class="fs-6">Nikmati hidangan langsung di restoran kami!</small>
                                </h4>
                                <p class="text-white-50">
                                    Datang langsung ke kasir, pilih menu favoritmu, dan bayar di tempat.
                                    Cepat & tanpa antre panjang.
                                </p>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="d-flex overflow-auto align-items-center mb-3">
                            <h5 class="me-auto">Kategori</h5>
                        </div>
                        <div class="d-flex gap-2 mb-4">
                            <input type="radio" class="btn-check" name="category_id" id="cat-all" autocomplete="off"
                                wire:model.live="category_id" value="">
                            <label class="btn btn-outline-primary" for="cat-all">Semua</label>

                            @foreach ($categories as $category)
                                <input type="radio" class="btn-check" name="category_id" id="cat-{{ $category->id }}"
                                    autocomplete="off" wire:model.live="category_id" value="{{ $category->id }}">
                                <label class="btn btn-outline-primary d-flex flex-column align-items-center"
                                    for="cat-{{ $category->id }}">
                                    <small>{{ $category->name }}</small>
                                </label>
                            @endforeach
                        </div>

                        <!-- Popular Dishes -->
                        <div class="mb-3">
                            <h5 class="me-auto text-nowrap">Daftar Produk</h5>

                            <input class="form-control " wire:model.live="search" type="search"
                                placeholder="Cari produk yang kamu inginkan..." aria-label="Search">
                        </div>
                        <div class="row mb-4">

                            @forelse($this->products as $product)
                                <div class="col-md-6">
                                    <div class="card card-product shadow h-100">
                                        <img src="{{ $product->image ? Storage::url($product->image) : "https://fakeimg.pl/350x200/?text=NO_IMAGE" }}"
                                            class="card-img-top" alt="…">
                                        <div class="card-body d-flex flex-column">

                                            <h6 class="card-title">{{ $product->title }}</h6>
                                            <p class="text-danger mb-2">{{ formatRupiah($product->price) }}</p>

                                            <div class="d-flex align-items-center mb-3">
                                                <button class="btn btn-sm btn-dark me-1"
                                                    onclick="scrollVariants('variants-{{ $product->id }}', -1)">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>

                                                <div id="variants-{{ $product->id }}"
                                                    class="d-flex flex-row flex-nowrap overflow-hidden flex-grow-1">
                                                    @foreach ($product->variants as $variant)
                                                        <input type="radio" class="btn-check"
                                                            name="variant-{{ $product->id }}"
                                                            id="var-{{ $variant->id }}" autocomplete="off"
                                                            wire:click="selectVariant({{ $variant->id }})"
                                                            {{ $variant->stock == 0 ? "disabled" : "" }}>

                                                        <label class="btn btn-outline-primary btn-sm text-nowrap me-1"
                                                            for="var-{{ $variant->id }}">
                                                            {{ strtoupper($variant->type) }}
                                                        </label>
                                                    @endforeach
                                                </div>

                                                <button class="btn btn-sm btn-dark ms-1"
                                                    onclick="scrollVariants('variants-{{ $product->id }}', +1)">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>

                                            <button type="button" class="btn btn-primary btn-sm mt-auto w-100"
                                                wire:click="addToCart({{ $product->id }})"
                                                @if (!$this->variant_id) disabled @endif>
                                                <i class="fas fa-plus me-1"></i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="d-flex justify-content-center align-items-center" style="height:200px;">
                                        <p class="text-muted mb-0">Produk tidak ditemukan</p>
                                    </div>
                                </div>
                            @endforelse

                        </div>

                    </div>

                    @include("pages.cashier.orderSidebar")

                </div>
            </div>
        </div>
    @endvolt

    <script>
        function scrollVariants(containerId, direction) {
            const container = document.getElementById(containerId);
            if (!container) return;
            const scrollAmount = 100; // px per klik
            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>

    <style>
        .banner {
            background: url('https://via.placeholder.com/800x200') center/cover no-repeat;
            border-radius: .5rem;
            color: #fff;
            height: 200px;
        }

        .card-product {
            border: none;
            border-radius: .75rem;
        }

        .card-product img {
            border-top-left-radius: .75rem;
            border-top-right-radius: .75rem;
            height: 150px;
            object-fit: cover;
        }

        .sidebar {
            background: #fff;
            border-radius: .75rem;
            padding: 1rem;
            box-shadow: 0 .25rem .5rem rgba(0, 0, 0, .1);
        }

        .sidebar .balance {
            background: linear-gradient(135deg, #6f42c1, #d63384);
            color: #fff;
            border-radius: .75rem;
            padding: 1rem;
            text-align: center;
        }

        .sidebar .order-item {
            border-bottom: 1px solid #e9ecef;
            padding: .5rem 0;
        }

        .variants-row {
            /* sembunyikan scrollbar di Firefox */
            scrollbar-width: none;
            /* sembunyikan scrollbar di IE/Edge */
            -ms-overflow-style: none;
        }

        /* sembunyikan scrollbar di Chrome, Safari, Opera */
        .variants-row::-webkit-scrollbar {
            display: none;
        }
    </style>

</x-admin-layout>
