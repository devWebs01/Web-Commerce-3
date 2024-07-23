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
                    <div class="col-lg-6 mt-4 mt-lg-0 align-content-center fun-facts mb-3">
                        <div class="counter float-start float-lg-end">
                            <span id="font-custom" class="fs-4 fw-bold">{{ $order->status }}</span>
                        </div>
                    </div>

                    @if ($order->status === 'PROGRESS' || $order->status === 'UNPAID')
                        <div class="alert alert-white d-flex align-items-center rounded" role="alert">
                            <span class="fs-1 me-4">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>
                            <strong class="fs-5">
                                {{ $order->user->details }}
                                <br>

                                <span style="color: #f35525">
                                    {{ $order->user->fulladdress }}
                                </span>
                            </strong>
                        </div>
                        @if ($order->status == 'CANCELLED')
                            <div class="alert alert-danger rounded-5" role="alert">
                                <strong>Pemberitahuan!</strong>
                                <span>
                                    Pesanan dibatalkan.
                                    @if ($order->payment_method != 'COD (Cash On Delivery)')
                                        Silahkan tunggu konfirmasi tentang pengambalian dana!
                                    @endif
                                </span>
                            </div>
                        @endif
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
                                                -
                                                {{ $item->variant->type }}
                                            </h5>
                                            <p>
                                                X {{ $item->qty }} item ({{ $item->qty * $item->product->weight }} gram)
                                            </p>
                                            <h6 class="fw-bold" style="color: #f35525">
                                                Rp.
                                                {{ Number::format($item->qty * $item->product->price, locale: 'id') }}
                                            </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-lg-5">
                                <div class="mb-3">
                                    <label for="courier" class="form-label">Pilih Pengiriman</label>
                                    <select wire:model.live='courier' class="form-select" name="courier" id="courier"
                                        {{ $order->status !== 'PROGRESS' ? 'disabled' : '' }}>

                                        <option>{{ $order->courier ? $order->courier : 'Pilih satu' }}</option>

                                        <option value="Ambil Sendiri">Ambil Sendiri - Ditunggu 2x24 Jam - Rp. 0</option>

                                        @foreach ($couriers as $courier)
                                            <option value="{{ $courier->id }}"
                                                {{ $order->courier === $courier->description ? 'elected' : '' }}>
                                                {{ $courier->formattedDescription }}
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
                                        id="payment_method" disabled>
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
                                        <p class="fw-bold" style="color: #f35525">
                                            Rp. 3.000
                                        </p>
                                    </label>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        Total Produk
                                    </div>
                                    <div class="col text-end fw-bold" style="color: #f35525">
                                        {{ 'Rp. ' . Number::format($this->order->total_amount) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        Biaya Pengiriman
                                    </div>
                                    <div class="col text-end fw-bold" style="color: #f35525">
                                        {{ 'Rp. ' . Number::format($shipping_cost, locale: 'id') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        Total Harga
                                    </div>
                                    <div class="col text-end fw-bold" style="color: #f35525">
                                        {{ 'Rp. ' . Number::format($order->total_amount + $shipping_cost + $this->protect_cost_opsional(), locale: 'id') }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">

                                    <div class="col-md">
                                        @if ($order->status === 'PROGRESS' || $order->status === 'UNPAID')
                                            <button class="btn btn-danger" wire:click="cancelOrder('{{ $order->id }}')"
                                                role="button">
                                                Batalkan
                                            </button>
                                        @endif
                                    </div>

                                    <div class="col-md text-end">
                                        @if ($order->status === 'PROGRESS')
                                            <button wire:click="confirmOrder('{{ $order->id }}')" class="btn btn-dark">
                                                Lanjut
                                            </button>
                                        @elseif ($order->status === 'UNPAID')
                                            <a href="{{ route('customer.payment', ['order' => $order->id]) }}"
                                                class="btn btn-dark">
                                                Bayar
                                            </a>
                                        @elseif ($order->status === 'SHIPPED')
                                            <button wire:click="complatedOrder" class="btn btn-dark" role="button">
                                                Pesanan diterima
                                            </button>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </div>
                    @else
                        @include('pages.orders.invoice')
                        @if ($order->status === 'SHIPPED')
                            <button wire:click="complatedOrder" class="btn btn-dark" role="button">
                                Pesanan diterima
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endvolt
</x-guest-layout>
