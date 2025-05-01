<?php

use function Livewire\Volt\{state, rules, computed};
use App\Models\Category;
use App\Models\Product;
use function Laravel\Folio\name;

name("catalog-products");

state(["search"])->url();
state(["categories" => fn() => Category::get()]);
state(["category_id" => ""]);

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

?>
<x-guest-layout>
    <x-slot name="title">Katalog Produk</x-slot>
    @volt
        <div>
            <div class="container mb-5">
                <div class="row">
                    <div class="col-lg-7">
                        <h2 id="font-custom" class="display-2 fw-bold">Katalog Produk</h2>
                    </div>
                    <div class="col-lg-5 mt-4 mt-lg-0">
                        <p>
                            Jelajahi beragam pilihan gaya dan tren terbaru dalam mode pakaian kami. Dari koleksi santai
                            yang nyaman hingga pakaian kasual yang stylish, kami memiliki segala yang Anda butuhkan
                            untuk tampil percaya diri dan menarik setiap hari.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Filter dan Produk -->
            <section class="pb-5">
                <div class="container">
                    <div class="row">
                        <!-- Sidebar Kategori -->
                        <div class="col-lg-3 mb-4">
                            <div class="card p-3 shadow-sm border-0">
                                <h5 class="mb-3 fw-bold">Kategori</h5>
                                <div class="d-flex flex-column gap-2">
                                    <div>
                                        <input wire:model.live="category_id" type="radio" class="form-check-input me-2"
                                            value="">
                                        <label class="form-check-label">Semua Kategori</label>
                                    </div>
                                    @foreach ($categories as $category)
                                        <div>
                                            <input wire:model.live="category_id" type="radio"
                                                class="form-check-input me-2" value="{{ $category->id }}">
                                            <label
                                                class="form-check-label">{{ Str::limit($category->name, 35, "...") }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Konten Produk -->
                        <div class="col-lg-9">
                            <!-- Search Bar -->
                            <div class="mb-4">
                                <div class="input-group">
                                    <input wire:model.live="search" type="search" class="form-control form-control-lg"
                                        placeholder="Cari produk...">
                                </div>
                            </div>

                            <!-- Grid Produk -->
                            <div class="properties section mt-0">

                                <div class="row">
                                    @forelse ($this->products as $product)
                                        <div class="col-lg-6 col-md-6 mb-3">
                                            <div class="item">
                                                <a href="{{ route("product-detail", ["product" => $product->id]) }}">
                                                    <img src="{{ Storage::url($product->image) }}"
                                                        alt="{{ $product->title }}" class="object-fit-cover"
                                                        style="width:100%; height:300px;">
                                                </a>
                                                <div class="d-flex gap-2 justify-content-between align-items-center">
                                                    <span class="category fw-bold">
                                                        {{ Str::limit($product->category->name, 13, "...") }}
                                                    </span>
                                                    <h6>
                                                        {{ "Rp. " . Number::format($product->price, locale: "id") }}
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

                                    @empty
                                        <div class="col-12 text-center py-5">
                                            <p class="text-muted">Produk tidak ditemukan.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endvolt

    </x-costumer-layout>
