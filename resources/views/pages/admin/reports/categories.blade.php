<?php

use function Livewire\Volt\{computed};
use App\Models\Category;
use function Laravel\Folio\name;

name("report.categories-product");

$categories = computed(fn() => Category::latest()->get());

?>

<x-admin-layout>
    @include("components.partials.print")

    <x-slot name="title">Laporan Kategori Produk</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("report.categories-product") }}">Laporan Kategori Produk</a></li>
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
                                    <th>Name</th>
                                    <th>Jumlah Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->categories as $no => $category)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->products->count() }} Produk Toko</td>
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
