<?php

use function Livewire\Volt\{computed};
use App\Models\Product;
use function Laravel\Folio\name;

name('report.products');

$products = computed(fn() => Product::latest()->get());

?>

<x-admin-layout>
    @include('layouts.print')

    <x-slot name="title">Laporan Produk</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('report.products') }}">Laporan Produk</a></li>
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
                                    <th>Berat Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->products as $no => $product)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td>{{ Str::limit($product->title, 40, '...') }}</td>
                                        <td>{{ 'Rp. ' . Number::format($product->price, locale: 'id') }}</td>
                                        <td>Tersedia</td>
                                        <td>{{ $product->weight }} gram</td>
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
