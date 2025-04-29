<?php

use function Livewire\Volt\{state, rules};
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use function Laravel\Folio\name;

name("product-detail");

state(["product", "user_id" => fn() => Auth()->user()->id ?? "", "product_id" => fn() => $this->product->id, "randomProduct" => fn() => Product::inRandomOrder()->limit(6)->get(), "qty" => 1]);

rules([
    "user_id" => "required|exists:users,id",
    "product_id" => "required|exists:products,id",
    "qty" => "required|numeric",
]);

$addToCart = function (Product $product) {
    if (Auth::check() && auth()->user()->role == "customer") {
        $existingCart = Cart::where("user_id", $this->user_id)->where("product_id", $this->product_id)->first();

        if ($existingCart) {
            $existingCart->update(["qty" => $existingCart->qty + $this->qty]);
        } else {
            Cart::create($this->validate());
        }

        $this->dispatch("cart-updated");
    } else {
        $this->redirect("/login");
    }
};

?>
<x-guest-layout>
    <x-slot name="title">Product {{ $product->title }}</x-slot>

    @volt
        <div>
            <section class="pt-5">
                <div class="container mb-5">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 id="font-custom" class="display-2 fw-bold">
                                Detail Produk
                            </h2>
                        </div>
                        <div class="col-lg-6 mt-lg-0 align-content-center">
                            <p>
                                Wajah terawat dengan <span class="fw-bold">{{ $product->title }}</span>
                                dari toko kami.
                            </p>
                        </div>
                    </div>

                </div>
            </section>

            <section class="pb-5">
                <div class="container">
                    <div class="row gx-2">
                        <aside class="col-lg-6">
                            <div class="border rounded-4 mb-3 d-flex justify-content-center">
                                <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image"
                                    href="{{ Storage::url($product->image) }}">
                                    <img class="p-4 object-fit-cover rounded-5" style="width: 100%; height: 600px;"
                                        src="{{ Storage::url($product->image) }}" />
                                </a>
                            </div>
                        </aside>
                        <main class="col-lg-6">
                            <div class="ps-lg-3">
                                <small class="fw-bold" style="color: #565cff;">{{ $product->category->name }}</small>
                                <h2 id="font-custom" class="title text-dark fw-bold">
                                    {{ $product->title }}
                                </h2>

                                <div class="my-3">
                                    <span class="h5 fw-bold">
                                        {{ "Rp. " . Number::format($product->price, locale: "id") }}
                                    </span>
                                </div>

                                <p class="mb-3">
                                    {{ $product->description }}
                                </p>

                                <div class="row">

                                    <dt class="col-3 mb-2">Stok:</dt>
                                    <dd class="col-9 mb-2">{{ $product->quantity }} Tersedia</dd>

                                    <dt class="col-3 mb-2">Berat:</dt>
                                    <dd class="col-9 mb-2">{{ $product->weight }} gram</dd>
                                </div>

                                <div class="d-grid my-4">
                                    @auth

                                        <form wire:submit='addToCart'>
                                            <button {{ $product->quantity == 0 ? "disabled" : "" }}
                                                wire:key="{{ $product->id }}" type="submit" class="btn btn-dark w-100">

                                                <span
                                                    wire:loading.remove>{{ $product->quantity == 0 ? "Tidak Tersedia" : "Masukkan Keranjang" }}
                                                </span>

                                                <div wire:loading class="spinner-border spinner-border-sm" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </button>
                                        </form>

                                        <x-action-message class="my-3 text-center" on="cart-updated">
                                            Berhasil
                                        </x-action-message>
                                    @else
                                        <a class="btn btn-dark" href="{{ route("login") }}" role="button">Beli Sekarang</a>
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
