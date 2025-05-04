<?php

use App\Models\Order;
use function Livewire\Volt\{computed};
use function Laravel\Folio\name;

name("report.transactions");

$orders = computed(fn() => Order::query()->get());

?>
<x-admin-layout>
    @include("components.partials.print")
    <x-slot name="title">Transaksi Toko</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("report.transactions") }}">Transaksi Toko</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table display table-sm text-nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Invoice</th>
                                    <th>Pembeli</th>
                                    <th>Status</th>
                                    <th>Total Belanja</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Tambahan</th>
                                    <th>Jumlah </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->orders as $no => $order)
                                    <tr>
                                        <td>{{ ++$no }}.</td>
                                        <td>{{ $order->invoice }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ __("order_status." . $order->status) }}</td>
                                        <td>{{ formatRupiah($order->total_amount) }}
                                        </td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td>{{ $order->protect_cost == 1 ? "Bubble Wrap" : "-" }}</td>
                                        <td>{{ $order->items->count() }} Barang</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-admin-layout>
