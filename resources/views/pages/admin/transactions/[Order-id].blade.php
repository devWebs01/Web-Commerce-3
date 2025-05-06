<?php

use function Livewire\Volt\{state, rules, uses};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Item;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

name("transactions.show");

state(["order", "orderItems" => fn() => Item::where("order_id", $this->order->id)->get(), "tracking_number"]);

rules([
    "tracking_number" => "required|min:10",
]);

$confirm = function () {
    $this->order->update(["status" => "PACKED"]);
    $this->dispatch("orders-alert");
};

$saveTrackingNumber = function () {
    $validate = $this->validate();
    $validate["status"] = "SHIPPED";

    $this->order->update($validate);
    $this->alert("success", "Pesanan telah di inputkan resi!", [
        "position" => "top",
        "timer" => 3000,
        "toast" => true,
    ]);

    $this->dispatch("orders-alert");
};

$cancelOrder = function ($orderId) {
    $order = $this->order;

    $orderItems = Item::where("order_id", $order->id)->get();
    foreach ($orderItems as $orderItem) {
        $variant = Variant::findOrFail($orderItem->variant_id);
        $variant->update(["stock" => $variant->stock + $orderItem->qty]);
    }

    $order->update(["status" => "CANCELLED"]);
    $this->dispatch("orders-alert");
    $this->alert("success", "Pesanan telah di batalkan!", [
        "position" => "top",
        "timer" => 3000,
        "toast" => true,
    ]);
};

$complatedOrder = fn() => $this->order->update(["status" => "COMPLETED"]);

$orderReady = fn() => $this->order->update(["status" => "PICKUP"]);

?>

<x-admin-layout>
    <x-slot name="title">Transaksi {{ $order->invoice }}</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("transactions.index") }}">Transaksi</a></li>
        <li class="breadcrumb-item active">{{ $order->invoice }}</li>
    </x-slot>

    <style>
        table tfoot {
            border: none !important;
        }
    </style>

    @include("components.partials.fancybox")

    @volt
        <div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary position-relative">
                                {{ __("order_status." . $order->status) }}
                                <span
                                    class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                </span>
                            </button>

                        </div>
                        <div class="col d-flex justify-content-end align-items-center gap-2 flex-wrap">
                            @if ($order->status == "PENDING")
                                <button wire:click='confirm' class="btn btn-primary d-flex align-items-center gap-1">
                                    <i class="ti ti-circle-check fs-5"></i>
                                    <span>Terima</span>
                                </button>
                            @endif

                            @if ($order->status === "PICKUP")
                                <button wire:click="complatedOrder" class="btn btn-success d-flex align-items-center gap-1">
                                    <i class="ti ti-checks fs-5"></i>
                                    <span>Selesai</span>
                                </button>
                            @endif

                            @if (
                                $order->status === "PENDING" ||
                                    $order->status === "PICKUP" ||
                                    ($order->status === "PACKED" && auth()->user()->role === "superadmin"))
                                <button wire:click="cancelOrder('{{ $order->id }}')"
                                    class="btn btn-danger d-flex align-items-center gap-1">
                                    <i class="ti ti-x fs-5"></i>
                                    <span>Batalkan</span>
                                </button>
                            @endif

                            <a href="{{ route("print.invoice", ["order" => $order->id]) }}"
                                class="btn btn-dark d-flex align-items-center gap-1" target="_blank"
                                rel="noopener noreferrer">
                                <i class="ti ti-printer fs-5"></i>
                                <span>Cetak</span>
                            </a>

                        </div>

                    </div>
                </div>
            </div>

            <form wire:submit="saveTrackingNumber">

                @if ($order->status === "PACKED")
                    @if ($order->courier === "Ambil Sendiri")
                        {{-- Admin Alert: Siap Diambil --}}
                        <div class="alert alert-info d-flex align-items-start rounded-3 mb-4 p-3 border-info">
                            <div class="me-3 text-info">
                                <i class="fa-solid fa-user-shield fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading fw-bold">Pesanan Siap Diambil</h6>
                                <p class="mb-2">Klik tombol di bawah jika barang siap diambil.</p>
                                <button wire:click="orderReady" class="btn btn-outline-success">
                                    <i class="fa-solid fa-check me-1"></i> Tandai Siap Ambil
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- Admin Alert: Input Resi --}}
                        <div class="alert alert-primary rounded-3 mb-2 p-3 border-primary">
                            <div class="d-flex align-items-center mb-4">

                                <div class="me-2 text-primary">
                                    <i class="fa-solid fa-user-shield fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Input Resi Pengiriman</h6>
                                    Masukkan nomor resi agar customer dapat melacak paket.
                                </div>
                            </div>

                            <div class="input-group mb-2 border-dark">
                                <span class="input-group-text"><i class="fa-solid fa-barcode"></i></span>
                                <input wire:model="tracking_number" type="text"
                                    class="form-control bg-white @error("tracking_number") is-invalid @enderror"
                                    placeholder="Masukkan nomor resi...">
                                <button class="btn btn-outline-primary" type="submit" wire:loading.attr="disabled">
                                    <i class="fa-solid fa-paper-plane me-1"></i> Submit
                                </button>
                            </div>
                            @error("tracking_number")
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                @endif

            </form>

            @if ($order->status == "CANCELLED")
                <div class="alert alert-danger">
                    <strong>Pengingat!</strong> Mohon hubungi customer untuk konfirmasi pembatalan dan lakukan pengembalian
                    dana
                    jika metode pembayaran bukan COD.
                </div>
            @endif

            <div class="row">
                {{-- Informasi Pelanggan --}}
                <div class="col-md-12">
                    <div class="card border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Informasi Pemesan</h6>
                            <div class="row mb-2">
                                <div class="mb-3 col-md-4">
                                    <p class="mb-1 text-dark">Nama:</p>
                                    <p class="mb-0">
                                        {{ $order->customer_name ? $order->customer_name : $order->user->name }}</p>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <p class="mb-1 text-dark">Email:</p>
                                    <p class="mb-0">
                                        {{ $order->customer_name ? "-" : $order->user->email }}</p>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <p class="mb-1 text-dark">Telepon:</p>
                                    <p class="mb-0">
                                        {{ $order->customer_phone ? $order->customer_phone : $order->user->telp }}</p>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <p class="mb-1 text-dark">Alamat:</p>
                                    <p class="mb-0">{{ $order->user->fulladdress ?? "-" }}</p>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <p class="mb-1 text-dark">Catatan:</p>
                                    <p class="mb-0">{{ $order->note }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card d-print-block border-0">
                <div class="card-body">
                    <div class="invoice" id="printableArea">
                        <div class="row">
                            {{-- Header Invoice --}}
                            <div class="col-md-12 mb-4">
                                <h4 class="fw-bold">Invoice</h4>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="mb-1"><span class="text-dark">Nomor Faktur:</span>
                                            {{ $order->invoice }}</p>
                                        <p class="mb-1"><span class="text-dark">Nomor Resi:</span>
                                            {{ $order->tracking_number ?? "-" }}
                                        </p>
                                        <p class="mb-1"><span class="text-dark">Tanggal Pesanan:</span>
                                            {{ $order->created_at->format("d M Y") }}</p>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-1"><span class="text-dark">Kurir:</span> {{ $order->courier }}</p>
                                        <p class="mb-1"><span class="text-dark">Pembayaran:</span>
                                            {{ $order->payment_method }}</p>
                                        <p class="mb-1"><span class="text-dark">Tambahan:</span>
                                            {{ $order->protect_cost ? "Bubble Wrap" : "-" }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Tabel Produk --}}
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm">
                                        <thead class="border">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Produk</th>
                                                <th class="text-center">Varian</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Harga</th>
                                                <th class="text-end">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderItems as $no => $item)
                                                <tr class="border">
                                                    <td class="text-center">{{ ++$no }}</td>
                                                    <td>{{ Str::limit($item->product->title, 30, "...") }}</td>
                                                    <td class="text-center">{{ $item->variant->type }}</td>
                                                    <td class="text-center">{{ $item->qty }}</td>
                                                    <td class="text-center">
                                                        {{ formatRupiah($item->product->price) }}</td>
                                                    <td class="text-end">
                                                        {{ formatRupiah($item->qty * $item->product->price) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            {{-- Ringkasan --}}
                                            <tr class="text-end">
                                                <td colspan="5">Sub Total</td>
                                                <td>{{ formatRupiah($order->items->sum(fn($item) => $item->qty * $item->product->price)) }}
                                                </td>
                                            </tr>
                                            <tr class="text-end">
                                                <td colspan="5">Berat Total</td>
                                                <td>{{ $order->total_weight }} gram</td>
                                            </tr>
                                            <tr class="text-end">
                                                <td colspan="5">Biaya Pengiriman</td>
                                                <td>{{ formatRupiah($order->shipping_cost) }}</td>
                                            </tr>
                                            <tr class="text-end">
                                                <td colspan="5">Biaya Tambahan</td>
                                                <td>{{ $order->protect_cost ? "Rp.3.000" : "Rp.0" }}</td>
                                            </tr>
                                            <tr class="text-end fw-bold">
                                                <td colspan="5">Total Pembayaran</td>
                                                <td>{{ formatRupiah($order->total_amount) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            {{-- Bukti Pembayaran --}}
                            @if ($order->payment_method == "Transfer Bank" && $order->proof_of_payment)
                                <div class="col-md-12 text-end mt-4">
                                    <figure class="figure">
                                        <a href="{{ Storage::url($order->proof_of_payment) }}" data-fancybox
                                            target="_blank">
                                            <img src="{{ Storage::url($order->proof_of_payment) }}"
                                                class="figure-img img-fluid rounded object-fit-cover" width="100%"
                                                alt="Bukti Pembayaran">
                                        </a>
                                        <figcaption class="figure-caption text-center">Bukti Pembayaran</figcaption>
                                    </figure>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-admin-layout>
