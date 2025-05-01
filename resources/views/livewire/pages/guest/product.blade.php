<?php

use function Livewire\Volt\{state, rules};
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;

state([
    "user_id" => fn() => Auth()->user()->id ?? "",
    "product_id" => fn() => $this->product,
    "product" => fn() => Product::find($id),
    "randomProduct" => fn() => Product::inRandomOrder()->limit(6)->get(),
    "qty" => 1,
]);

rules([
    "user_id" => "required|exists:users,id",
    "product_id" => "required|exists:products,id",
    "qty" => "required|numeric",
]);

$addToCart = function () {
    $existingCart = Cart::where("user_id", $this->user_id)->where("product_id", $this->product_id)->first();
    dd($addToCart);

    if ($existingCart) {
        // If the product is already in the cart, update the quantity
        $existingCart->update(["qty" => $existingCart->qty + $this->qty]);
    } else {
        // If the product is not in the cart, add it as a new item
        Cart::create($this->validate());
    }

    $this->dispatch("cart-updated");
};

?>
<div>
    <x-slot name="title">Product {{ $product->title }}</x-slot>

    <!-- Category Top Banner -->
    <section class="pt-5">
        <div class="custom-container mb-5">
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
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <div class="border  mb-3 d-flex justify-content-center">
                        <a data-fslightbox="mygalley" class="" target="_blank" data-type="image"
                            href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big.webp">
                            <img style="max-width: 100%; max-height: 100vh; margin: auto;" class=" fit"
                                src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big.webp" />
                        </a>
                    </div>
                    {{-- <div class="d-flex justify-content-center mb-3">
                            <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank"
                                data-type="image"
                                href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big1.webp"
                                class="item-thumb">
                                <img width="60" height="60" class="rounded-2"
                                    src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big1.webp" />
                            </a>
                            <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank"
                                data-type="image"
                                href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big2.webp"
                                class="item-thumb">
                                <img width="60" height="60" class="rounded-2"
                                    src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big2.webp" />
                            </a>
                            <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank"
                                data-type="image"
                                href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big3.webp"
                                class="item-thumb">
                                <img width="60" height="60" class="rounded-2"
                                    src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big3.webp" />
                            </a>
                            <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank"
                                data-type="image"
                                href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big4.webp"
                                class="item-thumb">
                                <img width="60" height="60" class="rounded-2"
                                    src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big4.webp" />
                            </a>
                            <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank"
                                data-type="image"
                                href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big.webp"
                                class="item-thumb">
                                <img width="60" height="60" class="rounded-2"
                                    src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big.webp" />
                            </a>
                        </div> --}}
                    <!-- thumbs-wrap.// -->
                    <!-- gallery-wrap .end// -->
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        <small class="fw-bold" style="color: #635bff;">{{ $product->category->name }}</small>
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
                            <dt class="col-3 mb-2">Berat:</dt>
                            <dd class="col-9 mb-2">{{ $product->weight }}</dd>
                        </div>

                        <div class="d-grid my-4">
                            @auth
                                <form wire:submit='addToCart'>
                                    {{-- @csrf --}}
                                    <button class="btn btn-dark w-100">
                                        Tambah Keranjang
                                    </button>
                                </form>
                            @else
                                <a name="" id="" class="btn btn-dark" href="{{ route("login") }}"
                                    role="button">Beli Sekarang</a>
                            @endauth

                            <!-- col.// -->
                            {{-- <div class="col-md col-6 mb-3">
                                    <div class="input-group mb-3" style="width: 170px;">
                                        <button class="btn btn-white border border-secondary px-3" type="button"
                                            id="button-addon1" data-mdb-ripple-color="dark">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="text" class="form-control text-center border border-secondary"
                                            placeholder="14" aria-label="Example text with button addon"
                                            aria-describedby="button-addon1" />
                                        <button class="btn btn-white border border-secondary px-3" type="button"
                                            id="button-addon2" data-mdb-ripple-color="dark">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div> --}}
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <div class="custom-container properties section">
            <div class="row">
                <h2 id="font-custom" class="fw-bold mb-4">Mungkin Kamu juga suka</h2>
            </div>
            @livewire("welcome.featured-products")
        </div>
    </section>
    <!-- content -->
</div>
