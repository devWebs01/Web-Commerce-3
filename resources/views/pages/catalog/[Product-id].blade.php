<?php

use function Livewire\Volt\{state, rules, computed, uses};
use App\Models\Product;
use App\Models\Variant;
use App\Models\Cart;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

name("product-detail");

state([
    "user_id" => fn() => Auth()->user()->id ?? "",
    "product_id" => fn() => $this->product->id,
    "variant_id" => "",
    "randomProduct" => fn() => Product::inRandomOrder()->limit(6)->get(),
    "qty" => 1,
    "variant_type" => "",
    "variant_stock" => "",
    "variant" => "",
    "product",
]);

rules([
    "user_id" => "required|exists:users,id",
    "product_id" => "required|exists:products,id",
    "variant_id" => "required|exists:variants,id",
    "qty" => "required|numeric",
]);

$selectVariant = function (Variant $variant) {
    $this->variant = $variant->stock;
    $this->variant_id = $variant->id;
    $this->variant_type = $variant->type;
    $this->variant_stock = $variant->stock;
};

$addToCart = function (Product $product) {
    if (Auth::check() && auth()->user()->role == "customer") {
        $existingCart = Cart::where("user_id", $this->user_id)->where("variant_id", $this->variant_id)->first();

        $stock = $this->variant_stock;

        // Memeriksa apakah stok mencukupi
        if ($stock < $this->qty) {
            $this->alert("error", "Stok tidak mencukupi untuk menambahkan item ke keranjang.", [
                "position" => "top",
                "timer" => "2000",
                "toast" => true,
                "timerProgressBar" => true,
                "text" => "",
            ]);
            return;
        }

        if ($existingCart) {
            $newQty = $existingCart->qty + $this->qty;

            // Memeriksa apakah stok mencukupi untuk jumlah baru
            if ($stock < $newQty) {
                $this->alert("error", "Stok tidak mencukupi untuk menambahkan item ke keranjang.", [
                    "position" => "top",
                    "timer" => "2000",
                    "toast" => true,
                    "timerProgressBar" => true,
                    "text" => "",
                ]);
                return;
            }

            $existingCart->update(["qty" => $newQty]);
        } else {
            Cart::create($this->validate());
        }

        $this->dispatch("cart-updated");

        $this->alert("success", "Item berhasil ditambahkan ke dalam keranjang belanja.", [
            "position" => "top",
            "timer" => "2000",
            "toast" => true,
            "timerProgressBar" => true,
            "text" => "",
        ]);
    } else {
        $this->redirect("/login");
    }
};

?>
<x-guest-layout>
    <x-slot name="title">Product {{ $product->title }}</x-slot>

    @include("components.partials.fancybox")
    @volt
        <div>
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <h2 id="font-custom" class="display-2 fw-bold">
                            Detail Produk
                        </h2>
                    </div>
                    <div class="col-lg-6 mt-lg-0 align-content-center">
                        <p>
                            Temukan kualitas terbaik dari produk <span class="fw-bold">{{ $product->title }}</span> yang
                            kami tawarkan.
                        </p>
                    </div>
                </div>

            </div>

            <section class="pb-5">
                <div class="container">
                    <div class="row gx-2">
                        <aside class="col-lg-5">
                            <div class="border  mb-3 d-flex justify-content-center">
                                <a data-fancybox class="" target="_blank" data-type="image"
                                    href="{{ Storage::url($product->image) }}">
                                    <img class="p-4 object-fit-cover " style="width: 100%;"
                                        src="{{ Storage::url($product->image) }}" />
                                </a>
                            </div>
                        </aside>
                        <main class="col-lg-7">
                            <div class="ps-lg-3">
                                <small class="fw-bold" style="color: #635bff;">{{ $product->category->name }}</small>
                                <h2 id="font-custom" class="title text-dark fw-bold">
                                    {{ $product->title }}
                                </h2>

                                <div class="my-3">
                                    <span class="h5 fw-bold" style="color: #635bff;">
                                        {{ formatRupiah($product->price) }}
                                    </span>
                                </div>

                                <p class="mb-3">
                                    {{ $product->description }}
                                </p>

                                <div>
                                    <h5 class="mb-2">Berat:</h5>
                                    <p class="mb-2">{{ $product->weight }} Gram</p>

                                    <h5 class="mb-2">Stok:</h5>
                                    <p class="mb-2">
                                        {{ $variant . " - " . $variant_type }}</p>

                                    <h5 class="mb-2">Varian</h5>
                                    <div class="row justify-content-between">

                                        @foreach ($product->variants as $variant)
                                            <div class="col-auto w-50 mb-2">
                                                <button wire:key='{{ $variant->id }}'
                                                    wire:click='selectVariant({{ $variant->id }})' type="button"
                                                    class="rounded-3 btn btn-outline-dark w-100">
                                                    {{ $variant->type }}
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                <div class="d-grid my-4">
                                    @auth
                                        <form wire:submit='addToCart'>
                                            @if ($variant)
                                                <button wire:key="{{ $product->id }}" type="submit"
                                                    class="rounded-3 btn btn-dark w-100 ">

                                                    <span
                                                        wire:loading.remove>{{ $variant_stock == 0 ? "Tidak Tersedia" : "Masukkan Keranjang" }}
                                                    </span>

                                                    <div wire:loading class="spinner-border spinner-border-sm" role="status">

                                                    </div>
                                                </button>
                                            @endif
                                        </form>
                                        @error("variant_id")
                                            <small class="my-3 text-center text-danger">
                                                Plih ukuran/variant yang diinginkan
                                            </small>
                                        @enderror
                                    @else
                                        <a class="rounded-3 btn btn-dark" href="{{ route("login") }}" role="button">Beli
                                            Sekarang</a>
                                    @endauth
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </section>
            <!-- content -->
        </div>
    @endvolt
</x-guest-layout>
