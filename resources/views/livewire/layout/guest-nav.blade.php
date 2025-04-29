<?php

use App\Livewire\Actions\Logout;
use App\Models\Cart;
use App\Models\Address;
use function Livewire\Volt\{state, computed, on};

$logout = function (Logout $logout) {
    $logout();

    $this->redirect("/");
};

state([
    "cart" => fn() => Cart::where("user_id", auth()->user()->id ?? null)->get(),
    "subTotal" => fn() => Cart::where("user_id", auth()->user()->id ?? null)
        ->get()
        ->sum(function ($item) {
            return $item->product->price * $item->qty;
        }),
    "getAddressUser" => fn() => Address::where("user_id", auth()->id())->first() ?? null,
]);
on([
    "cart-updated" => function () {
        $this->cart = Cart::where("user_id", auth()->user()->id ?? null)->get();
        $this->subTotal = Cart::where("user_id", auth()->user()->id ?? null)
            ->get()
            ->sum(function ($item) {
                return $item->product->price * $item->qty;
            });
    },

    "address-update" => function () {
        $this->getAddressUser = Address::where("user_id", auth()->id())->first();
    },
]);

?>

<div>
    @auth
        <div class="d-lg-flex gap-3">
            <a href="{{ route("catalog-cart") }}" class="text-white btn border position-relative">
                <i class="fa-solid fa-cart-shopping"></i>
                @if ($cart->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $cart->count() }}
                    </span>
                @endif
            </a>
            <a href="/orders" class="text-white btn border">
                <i class="fa-solid fa-truck"></i>
            </a>
            <a href="/user/{{ auth()->id() }}" class="text-white btn border position-relative">
                <i class="fa-solid fa-user"></i>
                @if (!$getAddressUser)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">!</span>
                @endif
            </a>
            <a wire:click="logout" href="#" class="text-white btn border">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
    @else
        <div class="d-flex flex-column flex-md-row gap-3">
            <a class="text-white fw-semibold mb-0" href="{{ route("login") }}">Masuk</a>
            <a class="text-white fw-semibold" href="{{ route("register") }}">Daftar</a>
        </div>

    @endauth

</div>
