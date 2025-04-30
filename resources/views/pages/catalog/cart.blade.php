<?php

use function Livewire\Volt\{state, rules, on, uses};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Item;
use App\Models\Address;
use App\Models\Shop;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

name('catalog-cart');

state([
    'carts' => fn() => Cart::where('user_id', auth()->id())->get(),
    'destination' => fn() => Address::where('user_id', auth()->id())->first(),
    'origin' => fn() => Shop::first(),
    'order',
]);

on([
    'cart-updated' => function () {
        $this->cart = $this->carts;
        $this->subTotal = $this->carts->sum(function ($item) {
            return $item->product->price * $item->qty;
        });
    },
]);

$calculateTotal = function () {
    $total = 0;
    foreach ($this->carts as $cart) {
        $total += $cart->product->price * $cart->qty;
    }
    return $total;
};

$increaseQty = function ($cartId) {
    $cart = Cart::find($cartId);
    if ($cart->qty < $cart->variant->stock) {
        $cart->update(['qty' => $cart->qty + 1]);
        $this->dispatch('cart-updated');
    }
};

$decreaseQty = function ($cartId) {
    $cart = Cart::find($cartId);
    if ($cart->qty > 1) {
        $cart->update(['qty' => $cart->qty - 1]);
        $this->dispatch('cart-updated');
    }
};

$deleteProduct = function ($cartId) {
    $cart = Cart::find($cartId);
    $cart->delete();
    $this->dispatch('cart-updated');
};

$confirmCheckout = function () {
    // Buat record pesanan
    $cartItems = Cart::where('user_id', auth()->id())->get();

    $order = Order::create([
        'user_id' => auth()->id(),
        'status' => 'PROGRESS',
        'invoice' => 'INV-' . time(),
        'total_amount' => 0,
        'shipping_cost' => 0,
        'province_id' => $this->destination->province_id,
        'city_id' => $this->destination->city_id,
        'details' => $this->destination->details,
    ]);

    // Inisialisasi total harga pesanan
    $totalPrice = 0;
    $totalWeight = 0;

    // Salin item dari keranjang ke tabel order_items
    foreach ($cartItems as $cartItem) {
        $orderItem = new Item([
            'product_id' => $cartItem->product_id,
            'variant_id' => $cartItem->variant_id,
            'qty' => $cartItem->qty,
        ]);

        // Tambahkan item ke pesanan
        $order->items()->save($orderItem);

        // Hitung total harga pesanan
        $totalPrice += $cartItem->product->price * $cartItem->qty;

        // Hitung total berat pesanan
        $totalWeight += $cartItem->product->weight * $cartItem->qty;

        // Kurangkan kuantitas produk dari stok
        $cartItem->variant->decrement('stock', $cartItem->qty);
    }

    // Update total harga pesanan
    $order->update([
        'total_amount' => $totalPrice, // Total harga pesanan ditambah ongkir
        'total_weight' => $totalWeight, // Total berat pesanan
    ]);

    try {
        $jneShippingData = [
            'origin' => $this->origin->city_id,
            'destination' => $this->destination->city_id,
            'weight' => 123,
            'courier' => RajaongkirCourier::JNE,
        ];
        $tikiShippingData = [
            'origin' => $this->origin->city_id,
            'destination' => $this->destination->city_id,
            'weight' => 123,
            'courier' => RajaongkirCourier::TIKI,
        ];

        $jneOngkirCost = \Rajaongkir::getOngkirCost($jneShippingData['origin'], $jneShippingData['destination'], $jneShippingData['weight'], $jneShippingData['courier']);

        $tikiOngkirCost = \Rajaongkir::getOngkirCost($tikiShippingData['origin'], $tikiShippingData['destination'], $tikiShippingData['weight'], $tikiShippingData['courier']);

        $jneShippingCost = $jneOngkirCost[0]['costs'];
        $tikiShippingCost = $tikiOngkirCost[0]['costs'];

        foreach ($jneShippingCost as $shippingCost) {
            \App\Models\Courier::create([
                'order_id' => $order->id,
                'description' => $shippingCost['description'] . ' (JNE)',
                'value' => $shippingCost['cost'][0]['value'],
                'etd' => $shippingCost['cost'][0]['etd'],
            ]);
        }

        foreach ($tikiShippingCost as $shippingCost) {
            \App\Models\Courier::create([
                'order_id' => $order->id,
                'description' => $shippingCost['description'] . ' (TIKI)',
                'value' => $shippingCost['cost'][0]['value'],
                'etd' => $shippingCost['cost'][0]['etd'],
            ]);
        }

        Cart::where('user_id', auth()->id())->delete();

        $this->dispatch('cart-updated');

        $this->alert('success', 'Pesanan telah berhasil diproses. Menuju detail pesanan.', [
            'position' => 'top',
            'timer' => '2000',
            'toast' => true,
            'text' => '',
        ]);

        $this->redirect('/orders/' . $order->id);
    } catch (\Throwable $th) {
        Order::find($order->id)->delete();

        $this->alert('error', 'Maaf, terjadi kesalahan saat checkout. Silakan coba lagi!', [
            'position' => 'top',
            'timer' => '2000',
            'toast' => true,
            'timerProgressBar' => true,
            'text' => '',
        ]);
    }
};

?>

<x-guest-layout>
    <x-slot name="title">Keranjang Belanja</x-slot>

    @volt
        <div>
            @include('pages.catalog.modal')

            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <h2 id="font-custom" class="display-4 fw-bold">
                            Keranjang Belanja
                        </h2>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 align-content-center">
                        <p>
                            Terima kasih telah memilih produk-produk kami. Sekarang saatnya untuk menyelesaikan pembelianmu.
                        </p>
                    </div>
                </div>

                <div class="card rounded-5">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table rounded table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Produk</th>
                                        <th>Varian</th>
                                        <th>Jumlah</th>
                                        <th>Total Harga</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $no => $cart)
                                        <tr class="align-items-center">
                                            <td>{{ ++$no }}.</td>
                                            <td>{{ Str::limit($cart->product->title, 20, '...') }}</td>
                                            <td>
                                                {{ $cart->variant->type }}
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm justify-content-center">
                                                    <button class="btn btn-body btn-sm border" wire:loading.attr='disabled'
                                                        wire:click="decreaseQty('{{ $cart->id }}')">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                    <span class="input-group-text bg-body border">
                                                        {{ $cart->qty }}
                                                    </span>
                                                    <button class="btn btn-body btn-sm border" wire:loading.attr='disabled'
                                                        wire:click="increaseQty('{{ $cart->id }}')">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>

                                                </div>
                                            </td>
                                            <td class="w-1/6">
                                                {{ 'Rp.' . Number::format($cart->qty * $cart->product->price, locale: 'id') }}
                                            </td>
                                            <td>
                                                <button wire:click="deleteProduct('{{ $cart->id }}')" type="button"
                                                    class="btn btn-body btn-sm">
                                                    <i class="fa-solid fa-x"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>Total:</td>
                                        <td>
                                            {{ 'Rp.' . Number::format($this->calculateTotal(), locale: 'id') }}
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>
                                            <a class="btn btn-outline-dark btn-sm" href="{{ route('catalog-products') }}"
                                                role="button">
                                                Lanjut Belanja
                                            </a>
                                        </td>
                                        <td>
                                            @if ($carts->count() > 0)
                                                @if (!$this->destination)
                                                    <a class="btn btn-outline-dark btn-sm"
                                                        href="{{ route('customer.account', ['user' => auth()->id()]) }}"
                                                        role="button">
                                                        Atur Alamat
                                                    </a>
                                                @else
                                                    <button type="button" class="btn btn-outline-dark btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        Checkout
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <div wire:loading class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>


    @endvolt
</x-guest-layout>
