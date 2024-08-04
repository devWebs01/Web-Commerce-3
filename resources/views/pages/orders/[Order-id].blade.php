<?php

use function Livewire\Volt\{state, rules, computed, on};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Item;
use App\Models\Courier;
use App\Models\Product;

state([
    'orderItems' => fn() => Item::where('order_id', $this->order->id)->get(),

    'couriers' => fn() => Courier::where('order_id', $this->order->id)->get(),

    'shipping_cost' => fn() => $this->selectCourier()->value ?? $this->order->shipping_cost,

    'payment_method' => fn() => $this->order->payment_method ?? null,

    'note' => fn() => $this->order->note ?? null,

    'protect_cost' => 0,

    'order',

    'orderId' => fn() => $this->order->id,
]);

state(['courier'])->url();

$protect_cost_opsional = computed(function () {
    return $this->protect_cost ? 3000 : 0;
});

$selectCourier = computed(function () {
    $confirmCourier = Courier::find($this->courier);

    if (!$confirmCourier) {
        return 0;
    } else {
        $this->dispatch('update-selectCourier');
        return $confirmCourier;
    }
});

on([
    'update-selectCourier' => function () {
        $this->shipping_cost = $this->selectCourier()->value ?? 0;
    },
]);

rules(['courier' => 'required', 'payment_method' => 'required']);

$confirmOrder = function () {
    $this->validate();
    $bubble_wrap = $this->protect_cost == 0 ? '' : ' + Bubble Wrap';
    $status_payment = $this->payment_method == 'Transfer Bank' ? 'UNPAID' : 'PENDING';
    $order = $this->order;
    $order->update([
        'total_amount' => $order->total_amount + $this->shipping_cost + $this->protect_cost_opsional,
        'shipping_cost' => $this->shipping_cost,
        'payment_method' => $this->payment_method,
        'status' => $status_payment,
        'note' => $this->note,
        'estimated_delivery_time' => $this->selectCourier()->etd,
        'courier' => $this->selectCourier()->description,
        'protect_cost' => $this->protect_cost,
    ]);

    $this->dispatch('delete-couriers', 'courier');

    if ($this->payment_method == 'Transfer Bank') {
        $this->redirect('/payments/' . $order->id);
    } else {
        $this->redirect('/orders');
    }
};

$cancelOrder = function ($orderId) {
    $order = Order::findOrFail($orderId);

    // Mengambil semua item yang terkait dengan pesanan yang dibatalkan
    $orderItems = Item::where('order_id', $order->id)->get();

    // Mengembalikan quantity pada tabel produk
    foreach ($orderItems as $orderItem) {
        $product = Product::findOrFail($orderItem->product_id);
        $newQuantity = $product->quantity + $orderItem->qty;

        // Memperbarui quantity pada tabel produk
        $product->update(['quantity' => $newQuantity]);
    }

    // Memperbarui status pesanan menjadi 'CANCELLED'
    $order->update(['status' => 'CANCELLED']);

    // Menghapus data kurir terkait
    $this->dispatch('delete-couriers');

    // Redirect ke halaman pesanan setelah pembatalan
    $this->redirect('/orders');
};

$complatedOrder = fn() => $this->order->update(['status' => 'COMPLETED']);

on([
    'delete-couriers' => function () {
        Courier::where('order_id', $this->order->id)->delete();
    },
]);

?>
<x-guest-layout>
    <x-slot name="title">Pesanan {{ $order->invoice }}</x-slot>
    @volt
        <div>
            <p class="d-none">@json($this->selectCourier())</p>

            <div class="container">
                <div class="row my-4">
                    <div class="col-lg-6">
                        <h2 id="font-custom" class="display-4 fw-bold">
                            {{ $order->invoice }}
                        </h2>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 align-content-center fun-facts">
                        <div class="counter float-start float-lg-end">
                            <span id="font-custom" class="fs-4 fw-bold">{{ $order->status }}</span>
                        </div>
                    </div>

                    <div class="alert alert-white border mt-3 d-flex align-items-center rounded-5" role="alert">
                        <span class="fs-1 me-4">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <strong class="fs-5">
                            {{ $order->user->name . ', ' . $order->user->email . ', ' . $order->user->telp }}
                            <br>

                            <span style="color: #9c9259">
                                {{ $order->user->address->province->name . ', ' . $order->user->address->city->name . ', ' . $order->user->address->details }}
                            </span>
                        </strong>
                    </div>
                </div>
            </div>
            @if ($order->status === 'PROGRESS' || $order->status === 'UNPAID')
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            @foreach ($orderItems as $item)
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <img src="{{ Storage::url($item->product->image) }}"
                                            class="img rounded object-fit-cover border rounded" height="100px"
                                            width="200px" alt="{{ $item->product->title }}" />
                                    </div>
                                    <div class="col">
                                        <h5 id="font-custom">
                                            {{ $item->product->title }}
                                        </h5>
                                        <p>X {{ $item->qty }} item</p>
                                        <h6 class="fw-bold" style="color: #9c9259">
                                            Rp.
                                            {{ Number::format($item->qty * $item->product->price, locale: 'id') }}
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <label for="courier" class="form-label">Pilih Jasa Kirim</label>
                                <select wire:model.live='courier' class="form-select" name="courier" id="courier"
                                    {{ $order->status !== 'PROGRESS' ? 'disabled' : '' }}>
                                    <option>
                                        {{ $order->courier !== null ? $order->courier : 'Pilih satu' }}
                                    </option>
                                    @foreach ($couriers as $courier)
                                        <option value="{{ $courier->id }}"
                                            {{ $order->courier == $courier->description ? 'selected' : '' }}>
                                            {{ $courier->description }} -
                                            {{ $courier->etd . ' Hari' }} -
                                            {{ 'Rp. ' . Number::format($courier->value, locale: 'id') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('courier')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                <select wire:model.live='payment_method' class="form-select" name="payment_method"
                                    id="payment_method" {{ $order->status !== 'PROGRESS' ? 'disabled' : '' }}>
                                    <option>Pilih satu</option>
                                    <option value="COD (Cash On Delivery)">COD (Cash On Delivery)</option>
                                    <option value="Transfer Bank">Transfer Bank</option>
                                </select>
                                @error('courier')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label">Pesan Tambahan</label>
                                <textarea wire:model='note' class="form-control" name="note" id="note" rows="3"
                                    {{ $order->status !== 'PROGRESS' ? 'disabled' : '' }}>
                            </textarea>
                                @error('note')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input wire:model.live='protect_cost' class="form-check-input" type="checkbox"
                                    value="" id="protect_cost" {{ $order->protect_cost == 0 ?: 'checked' }}
                                    {{ $order->protect_cost == null ?: 'disabled' }}>
                                <label class="form-check-label" for="protect_cost">
                                    <strong>Proteksi Pesanan</strong>
                                    <p>Lindungi pesananmu dari kemungkinan yang tidak diinginkan </p>
                                    <p class="fw-bold" style="color: #9c9259">
                                        Rp. 3.000
                                    </p>
                                </label>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    Total Produk
                                </div>
                                <div class="col text-end fw-bold" style="color: #9c9259">
                                    {{ 'Rp. ' . Number::format($this->order->total_amount) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    Biaya Pengiriman
                                </div>
                                <div class="col text-end fw-bold" style="color: #9c9259">
                                    {{ 'Rp. ' . Number::format($shipping_cost, locale: 'id') }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    Total Harga
                                </div>
                                <div class="col text-end fw-bold" style="color: #9c9259">
                                    {{ 'Rp. ' . Number::format($order->total_amount + $shipping_cost + $this->protect_cost_opsional(), locale: 'id') }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">

                                @if ($order->status === 'PROGRESS')
                                    <div class="col">
                                        <button class="btn btn-danger" wire:click="cancelOrder('{{ $order->id }}')"
                                            role="button">
                                            Batalkan Pesanan
                                        </button>
                                    </div>
                                    <div class="col text-end">
                                        <button wire:click="confirmOrder('{{ $order->id }}')" class="btn btn-dark">
                                            Proses
                                        </button>
                                    </div>
                                @elseif ($order->status == 'UNPAID')
                                    <div class="col">
                                        <button class="btn btn-danger" wire:click="cancelOrder('{{ $order->id }}')"
                                            role="button">
                                            Batalkan Pesanan
                                        </button>
                                    </div>
                                    <div class="col text-end">
                                        <a href="/payments/{{ $order->id }}"
                                            wire:click="confirmOrder('{{ $order->id }}')" class="btn btn-dark">
                                            Lanjut Bayar
                                        </a>
                                    </div>
                                @elseif($order->status === 'SHIPPED')
                                    <button wire:click='complatedOrder' class="btn btn-dark" role="button">Pesanan
                                        diterima</button>
                                @endif

                            </div>

                        </div>

                    </div>
                </div>
            @else
                <div class="container">
                    @include('pages.orders.invoice')
                    @if ($order->status === 'SHIPPED')
                        <button wire:click="complatedOrder" class="btn btn-dark" role="button">
                            Pesanan diterima
                        </button>
                    @endif
                </div>
            @endif
        </div>
    @endvolt
</x-guest-layout>
