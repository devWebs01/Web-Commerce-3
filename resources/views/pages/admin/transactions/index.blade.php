<?php

use function Livewire\Volt\{state, usesPagination, computed};
use App\Models\Order;
use function Laravel\Folio\name;

name('transactions.index');

state(['search'])->url();
usesPagination();

$orders = computed(function () {
    if ($this->search == null) {
        return Order::query()->latest()->paginate(10);
    } else {
        return Order::query()
            ->where('invoice', 'LIKE', "%{$this->search}%")
            ->orWhere('status', 'LIKE', "%{$this->search}%")
            ->orWhere('total_amount', 'LIKE', "%{$this->search}%")
            ->latest()
            ->paginate(10);
    }
});

?>


<x-admin-layout>
    <x-slot name="title">Transaksi</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transaksi</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card">
                <div class="card-header">
                    <input wire:model.live="search" type="search" class="form-control" name="search" id="search"
                        aria-describedby="helpId" placeholder="Mencari transaksi..." />
                </div>
                <div class="card-body">
                    <div class="table-responsive border rounded">
                        <table class="table text-center text-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Invoice</th>
                                    <th>Status</th>
                                    <th>Total Pesanan</th>
                                    <th>Jumlah </th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->orders as $no => $order)
                                    <tr>
                                        <th>{{ ++$no }}</th>
                                        <th>{{ $order->invoice }}</th>
                                        <th>
                                            <span class="badge bg-primary uppercase">
                                                {{ $order->status }}
                                            </span>
                                        </th>
                                        <th>
                                            {{ 'Rp. ' . Number::format($order->total_amount, locale: 'id') }}
                                        </th>
                                        <th>{{ $order->items->count() }} Barang</th>

                                        <th>
                                            <a href="/admin/transactions/{{ $order->id }}"
                                                class="btn btn-primary btn-sm">
                                                Detail Order
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{ $this->orders->links() }}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-admin-layout>
