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

    @include("components.partials.fancybox")

    @volt
        <div class="container">

            @if (!in_array($order->status, ["PROGRESS", "UNPAID"]))
                {{-- Jika pesanan sudah dikirim, tampilkan alert & tombol konfirmasi --}}
                @if ($order->status === "SHIPPED")
                    <div class="alert alert-warning shadow-sm rounded-3 mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-8 d-flex align-items-center">
                                <i class="fa-solid fa-truck me-3 fs-2 text-dark mt-1"></i>
                                <div>
                                    <strong>Status Pesanan:</strong> {{ __("order_status." . $order->status) }}<br>
                                    <p class="mb-0 mt-1">
                                        Mohon klik tombol terima untuk mengkonfirmasi bahwa Anda telah menerima paket.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <button wire:click="complatedOrder" class="btn btn-warning">
                                    Pesanan diterima
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Jika user sudah konfirmasi terima, tampilkan banner sukses --}}
                @if ($order->status === "COMPLETED")
                    <div class="alert alert-success d-flex align-items-center shadow-sm rounded-3 mb-4">
                        <i class="fa-solid fa-thumbs-up me-3 fs-4"></i>
                        <div>
                            Terima kasih! Pesanan Anda sudah <strong>dikonfirmasi diterima</strong>.
                        </div>
                    </div>
                @endif

                @include("pages.transactions.invoice")
            @else
                {{-- Notifikasi Status --}}
                <div class="alert alert-warning d-flex align-items-center shadow-sm rounded-3 mb-4">
                    <i class="fa-solid fa-clock me-3 fs-4 text-warning"></i>
                    <div>
                        <h6 class="fw-bold mb-1 fs-4">Checkout</h6>

                        Status pesanan saat ini adalah <strong>{{ __("order_status." . $order->status) }}</strong>.<br>
                        Silakan selesaikan langkah berikut agar pesanan dapat diproses lebih lanjut.
                    </div>
                </div>

                <div class="row gy-4">
                    {{-- Kolom Kiri --}}
                    <div class="col-lg-8">

                        {{-- Informasi Pemesan --}}
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Informasi Pemesan</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <p class="fw-bold mb-0">Nama Lengkap:</p>
                                        <p>{{ $order->user->name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="fw-bold mb-0">Email:</p>
                                        <p>{{ $order->user->email }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="fw-bold mb-0">Telepon:</p>
                                        <p>{{ $order->user->telp }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-bold mb-0">Alamat Lengkap:</p>
                                        <p>{{ $order->user->fulladdress }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Daftar Item --}}
                        @foreach ($orderItems as $item)
                            <div class="card shadow-sm border-0 mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ $item->product->image ? Storage::url($item->product->image) : "https://fakeimg.pl/350x200/?text=NO_IMAGE" }}"
                                            class="img-fluid rounded-start" alt="{{ $item->product->title }}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title mb-2 text-primary">
                                                {{ $item->product->title }}
                                                <small class="text-muted">({{ $item->variant->type }})</small>
                                            </h5>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Jumlah:</strong> {{ $item->qty }} pcs</p>
                                                    <p class="mb-1"><strong>Berat/item:</strong>
                                                        {{ $item->product->weight }}g</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Total berat:</strong>
                                                        {{ $item->qty * $item->product->weight }}g</p>
                                                    <p class="mb-1"><strong>Harga/item:</strong> Rp
                                                        {{ formatRupiah($item->product->price) }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="mb-0"><strong>Total:</strong> Rp
                                                        {{ formatRupiah($item->qty * $item->product->price) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="col-lg-4">
                        {{-- Form Pembayaran --}}
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Detail Pembayaran</h6>

                                {{-- Metode Pembayaran --}}
                                <div class="mb-3">
                                    <label class="form-label">Metode Pembayaran</label>
                                    <select wire:model.live="payment_method" class="form-select"
                                        {{ $order->status !== "PROGRESS" ? "disabled" : "" }}>
                                        <option>Pilih salah satu</option>
                                        <option value="COD (Cash On Delivery)">COD</option>
                                        <option value="Transfer Bank">Transfer Bank</option>
                                    </select>
                                </div>

                                {{-- Pesan Tambahan --}}
                                <div class="mb-3">
                                    <label class="form-label">Pesan Tambahan</label>
                                    <textarea wire:model="note" class="form-control" rows="2" {{ $order->status !== "PROGRESS" ? "disabled" : "" }}></textarea>
                                </div>

                                {{-- Kurir --}}
                                <div class="mb-3">
                                    <label class="form-label">Metode Pengiriman</label>
                                    <select wire:model.live="courier" class="form-select"
                                        {{ $order->status !== "PROGRESS" ? "disabled" : "" }}>
                                        <option>{{ $order->courier ?? "Pilih salah satu" }}</option>
                                        <option value="Ambil Sendiri">Ambil Sendiri - Rp 0</option>
                                        @foreach ($couriers as $courier)
                                            <option value="{{ $courier->id }}">{{ $courier->formattedDescription }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("courier")
                                        <small class="fw-bold text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Ringkasan --}}
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Ringkasan Pembayaran</h6>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Produk</span>
                                    <span class="fw-bold">{{ formatRupiah($order->total_amount) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Ongkir</span>
                                    <span class="fw-bold">{{ formatRupiah($this->shipping_cost) }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-2 mt-2 mb-3">
                                    <span>Total Pembayaran</span>
                                    <span class="fw-bold text-primary">
                                        {{ formatRupiah($order->total_amount + $this->shipping_cost + $this->protect_cost_opsional()) }}
                                    </span>
                                </div>

                                {{-- Tombol Aksi --}}
                                @if ($order->status === "PROGRESS")
                                    <button wire:click="confirmOrder('{{ $order->id }}')" class="btn btn-dark w-100">
                                        Lanjutkan Pembayaran
                                    </button>
                                @elseif ($order->status === "UNPAID")
                                    <a href="{{ route("customer.payment", ["order" => $order->id]) }}"
                                        class="btn btn-dark w-100">
                                        Bayar Sekarang
                                    </a>
                                @endif

                                @if (in_array($order->status, ["PROGRESS", "UNPAID"]))
                                    <button wire:click="cancelOrder('{{ $order->id }}')"
                                        class="btn btn-outline-danger w-100 mt-2">
                                        Batalkan Pesanan
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endvolt

</x-guest-layout>
