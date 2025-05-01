<?php

use function Livewire\Volt\{state, rules, computed, on, uses};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Item;
use App\Models\Courier;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

state(["courier"])->url();

state([
    "orderItems" => fn() => $this->order->items,
    "couriers" => fn() => $this->order->couriers,
    "note" => fn() => $this->order->note ?? null,
    "payment_method" => fn() => "Transfer Bank",
    "orderId" => fn() => $this->order->id,
    "protect_cost" => 0,
    "order",
    // 'payment_method' => fn() => $this->order->payment_method ?? null,
]);

$shipping_cost = computed(fn() => $this->selectCourier()->value ?? 0);

rules(["courier" => "required", "payment_method" => "required"]);

on([
    "update-selectCourier" => function () {
        $this->shipping_cost = $this->selectCourier()->value ?? 0;
    },
]);

on([
    "delete-couriers" => function () {
        Courier::where("order_id", $this->order->id)->delete();
    },
]);

$protect_cost_opsional = computed(function () {
    return $this->protect_cost ? 3000 : 0;
});

$selectCourier = computed(function () {
    if ($this->courier === "Ambil Sendiri") {
        return (object) [
            "value" => 0,
            "description" => "Ambil Sendiri",
            "etd" => "Ditunggu 2x24 Jam",
        ];
    }

    $confirmCourier = Courier::find($this->courier);

    if (!$confirmCourier) {
        return (object) [
            "value" => 0,
            "description" => null,
            "etd" => null,
        ];
    }

    $this->dispatch("update-selectCourier");
    return $confirmCourier;
});

$confirmOrder = function () {
    $this->validate();

    $bubble_wrap = $this->protect_cost == 0 ? "" : " + Bubble Wrap";
    $status_payment = $this->payment_method == "Transfer Bank" ? "UNPAID" : "PENDING";
    $order = $this->order;

    if ($this->courier === "Ambil Sendiri") {
        // Update detail pesanan untuk pengambilan sendiri
        $order->update([
            "total_amount" => $order->total_amount + $this->shipping_cost + $this->protect_cost_opsional,
            "shipping_cost" => $this->shipping_cost,
            "payment_method" => $this->payment_method,
            "status" => $status_payment,
            "note" => $this->note,
            "estimated_delivery_time" => "Ditunggu 2x24 Jam",
            "courier" => "Ambil Sendiri",
            "protect_cost" => $this->protect_cost,
        ]);
    } else {
        // Update detail pesanan untuk pengiriman kurir
        $order->update([
            "total_amount" => $order->total_amount + $this->shipping_cost + $this->protect_cost_opsional,
            "shipping_cost" => $this->shipping_cost,
            "payment_method" => $this->payment_method,
            "status" => $status_payment,
            "note" => $this->note,
            "estimated_delivery_time" => $this->selectCourier()->etd,
            "courier" => $this->selectCourier()->description,
            "protect_cost" => $this->protect_cost,
        ]);
    }

    $this->dispatch("delete-couriers", "courier");

    // Redirect ke halaman pembayaran atau daftar pesanan
    if ($this->payment_method == "Transfer Bank") {
        $this->alert("success", "Anda telah memilih opsi pengiriman. Lanjut melakukan pembayaran.", [
            "position" => "top",
            "timer" => 3000,
            "toast" => true,
        ]);
        $this->redirectRoute("customer.payment", ["order" => $order->id]);
    } else {
        $this->redirect("/orders");
    }
};

$cancelOrder = function ($orderId) {
    $order = Order::findOrFail($orderId);

    // Mengambil semua item yang terkait dengan pesanan yang dibatalkan
    $orderItems = Item::where("order_id", $order->id)->get();

    // Mengembalikan quantity pada tabel produk
    foreach ($orderItems as $orderItem) {
        $variant = Variant::findOrFail($orderItem->variant_id);
        $variant->increment("stock", $orderItem->qty);
    }

    // Memperbarui status pesanan menjadi 'CANCELLED'
    $order->update(["status" => "CANCELLED"]);

    // Menghapus data kurir terkait
    $this->dispatch("delete-couriers");

    // Redirect ke halaman pesanan setelah pembatalan
    $this->redirect("/orders");
};

$complatedOrder = fn() => $this->order->update(["status" => "COMPLETED"]);

?>
<x-guest-layout>
    <x-slot name="title">Pesanan {{ $order->invoice }}</x-slot>

    @volt
        <div class="custom-container py-5">
            <div class="row mb-4">
                <h2 class="fw-bold h4">Checkout</h2>
                <div class="col-lg-8">

                    {{-- Booking Notice --}}
                    @if ($order->status === "PROGRESS" || $order->status === "UNPAID")
                        <div class="alert alert-warning d-flex align-items-center">
                            <i class="fa-solid fa-clock me-3 fs-4 text-warning"></i>
                            <div>
                                <strong>Pesanan Anda sedang diproses</strong><br>
                                Jika status berubah, kami akan menginformasikannya.
                            </div>
                        </div>
                    @endif

                    {{-- Informasi Pemesan --}}
                    <div class="card mb-4 shadow border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-2">Informasi Pemesan</h6>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <h6 class="text-secondary mb-2">Nama Lengkap</h6>
                                    <h6>{{ $order->user->name }}</h6>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-secondary mb-2">Email</h6>
                                    <h6>{{ $order->user->email }}</h6>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-secondary mb-2">Telephone</h6>
                                    <h6>{{ $order->user->telp }}</h6>
                                </div>
                            </div>
                            <h6 class="text-secondary mb-2">Alamat</h6>
                            <h6>{{ $order->user->fulladdress }}</h6>
                        </div>
                    </div>

                    {{-- Item Pesanan --}}
                    @foreach ($orderItems as $item)
                        <div class="card mb-3 shadow border-0">
                            <div class="row g-0">
                                <div class="col-4">
                                    <img src="{{ Storage::url($item->product->image) }}" class="img-fluid rounded-start"
                                        alt="{{ $item->product->title }}">
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $item->product->title }} - {{ $item->variant->type }}</h6>
                                        <p class="card-text">x{{ $item->qty }}
                                            ({{ $item->qty * $item->product->weight }}g)
                                        </p>
                                        <h6 class="fw-bold text-primary">Rp
                                            {{ Number::format($item->qty * $item->product->price, locale: "id") }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Panel Kanan: Pembayaran dan Ringkasan --}}
                <div class="col-lg-4">
                    {{-- Pembayaran --}}
                    <div class="card mb-4 shadow border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Detail Pembayaran</h6>

                            <label class="form-label">Metode Pembayaran</label>
                            <select wire:model.live="payment_method" class="form-select mb-3"
                                {{ $order->status !== "PROGRESS" ? "disabled" : "" }}>
                                <option>Pilih satu</option>
                                <option value="COD (Cash On Delivery)">COD (Cash On Delivery)</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                            </select>

                            <label class="form-label">Pesan Tambahan</label>
                            <textarea wire:model="note" class="form-control mb-3" rows="2"
                                {{ $order->status !== "PROGRESS" ? "disabled" : "" }}></textarea>

                            <div class="form-check mb-3 d-none">
                                <input wire:model.live="protect_cost" type="checkbox" class="form-check-input"
                                    id="protect_cost" {{ $order->protect_cost == 0 ? "" : "checked" }}
                                    {{ $order->protect_cost == null ? "disabled" : "" }}>
                                <label class="form-check-label" for="protect_cost">
                                    Proteksi Pesanan - <span class="fw-bold text-primary">Rp 3.000</span>
                                </label>
                            </div>

                            <label class="form-label">Metode Pengiriman</label>
                            <select wire:model.live="courier" class="form-select mb-3"
                                {{ $order->status !== "PROGRESS" ? "disabled" : "" }}>
                                <option>{{ $order->courier ?? "Pilih satu" }}</option>
                                <option value="Ambil Sendiri">Ambil Sendiri - Rp. 0</option>
                                @foreach ($couriers as $courier)
                                    <option value="{{ $courier->id }}">{{ $courier->formattedDescription }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Ringkasan --}}
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Ringkasan</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Produk</span>
                                <span class="fw-bold text-primary">Rp {{ Number::format($order->total_amount) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkir</span>
                                <span class="fw-bold text-primary">Rp {{ Number::format($this->shipping_cost) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Total</span>
                                <span class="fw-bold text-primary">Rp
                                    {{ Number::format($order->total_amount + $this->shipping_cost + $this->protect_cost_opsional()) }}</span>
                            </div>

                            {{-- Tombol Aksi --}}
                            @if ($order->status === "PROGRESS")
                                <button wire:click="confirmOrder('{{ $order->id }}')"
                                    class="btn btn-primary w-100">Lanjutkan</button>
                            @elseif ($order->status === "UNPAID")
                                <a href="{{ route("customer.payment", ["order" => $order->id]) }}"
                                    class="btn btn-primary w-100">Bayar Sekarang</a>
                            @endif

                            @if ($order->status === "PROGRESS" || $order->status === "UNPAID")
                                <button class="btn btn-outline-danger w-100 mt-2"
                                    wire:click="cancelOrder('{{ $order->id }}')">Batalkan Pesanan</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt

</x-guest-layout>
