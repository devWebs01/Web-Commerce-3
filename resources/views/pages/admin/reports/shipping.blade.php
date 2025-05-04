<?php

use App\Models\Order;
use function Livewire\Volt\{computed};
use function Laravel\Folio\name;

name("report.shipping");

$orders = computed(fn() => Order::query()->where("status", "SHIPPED")->orWhere("status", "COMPLETED")->get());

?>
<x-app-layout>
    @include("components.partials.print")
    <x-slot name="title">Laporan Data Pengiriman</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("report.shipping") }}">Laporan Data Pengiriman</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table display table-sm">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pembeli</th>
                                    <th>Status</th>
                                    <th>Total Belanja</th>
                                    <th>Nomor Resi</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Berat Barang</th>
                                    <th>Tambahan</th>
                                    <th>Kurir</th>
                                    <th>Ongkir</th>
                                    <th>Estimasi Pengiriman</th>
                                    <th>Tujuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->orders as $no => $order)
                                    <tr>
                                        <td>{{ ++$no }}.</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ "Rp. " . Number::format($order->total_amount, locale: "id") }}
                                        </td>
                                        <td>{{ $order->tracking_number }}</td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td>{{ $order->total_weight }} gram</td>
                                        <td>{{ $order->protect_cost == 1 ? "Bubble Wrap" : "-" }}</td>
                                        <td>{{ $order->courier }}</td>
                                        <td>{{ "Rp. " . Number::format($order->shipping_cost, locale: "id") }}
                                        </td>
                                        <td>{{ $order->estimated_delivery_time }} Hari</td>
                                        <td>
                                            {{ $order->user->address->province->name ?? "-" }},
                                            {{ $order->user->address->city->name ?? "-" }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-app-layout>
