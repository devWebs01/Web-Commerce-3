<?php

use App\Models\Order;
use function Livewire\Volt\{computed};
use function Laravel\Folio\name;

name('report.transactions');

$orders = computed(fn() => Order::query()->get());

?>
<x-admin-layout>
    @include('layouts.print')
    <x-slot name="title">Transaksi Toko</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('report.transactions') }}">Transaksi Toko</a></li>
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
                                    <th>Invoice</th>
                                    <th>Pembeli</th>
                                    <th>Status</th>
                                    <th>Total Belanja</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Tambahan</th>
                                    <th>Jumlah </th>
                                    <th>Tanggal </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->orders as $no => $order)
                                    <tr>
                                        <td>{{ ++$no }}.</td>
                                        <td>{{ $order->invoice }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ 'Rp. ' . Number::format($order->total_amount, locale: 'id') }}
                                        </td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td>{{ $order->protect_cost == 1 ? 'Bubble Wrap' : '-' }}</td>
                                        <td>{{ $order->items->count() }} Barang</td>
                                        <td>{{ $order->created_at }}</td>
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
