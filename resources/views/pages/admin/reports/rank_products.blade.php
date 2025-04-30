<?php

use function Livewire\Volt\{computed};
use App\Models\Product;
use function Laravel\Folio\name;

name('report.rankProducts');

$products = computed(fn() => Product::latest()->get());

?>

<x-app-layout>
    @include('layouts.print')

    <x-slot name="title">Laporan Data Produk Terlaris</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('report.rankProducts') }}">Laporan Data Produk
                Terlaris</a></li>
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
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah / Stok</th>
                                    <th>Terjual</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->products as $no => $product)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ 'Rp. ' . Number::format($product->price, locale: 'id') }}</td>
                                        <td> Tersedia</td>
                                        <td>{{ $product->items->count() }} Terjual</td>
                                        <td>{{ 'Rp. ' . Number::format($product->items->count() * $product->price, locale: 'id') }}
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
