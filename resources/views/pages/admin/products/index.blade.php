<?php

use function Livewire\Volt\{computed, usesPagination, state};
use App\Models\Product;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

name("products.index");

state(["search"])->url();
usesPagination(theme: "bootstrap");

$products = computed(function () {
    if ($this->search == null) {
        return Product::query()->latest()->paginate(10);
    } else {
        return Product::query()
            ->where("title", "LIKE", "%{$this->search}%")
            ->orWhere("price", "LIKE", "%{$this->search}%")
            ->orWhere("quantity", "LIKE", "%{$this->search}%")
            ->latest()
            ->paginate(10);
    }
});

$destroy = function (product $product) {
    Storage::delete($product->image);
    $product->delete();

    LivewireAlert::text("Proses berhasil!")
        ->success()
        ->timer(3000) // Dismisses after 3 seconds
        ->show();
};
?>

<x-admin-layout>
    <x-slot name="title">Produk Toko</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("products.index") }}">Produk Toko</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <a href="{{ route("products.create") }}" class="btn btn-primary">Tambah
                                Produk Toko</a>
                        </div>
                        <div class="col">
                            <input wire:model.live="search" type="search" class="form-control" name="search"
                                id="search" aria-describedby="helpId" placeholder="Masukkan nama produk toko" />
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border rounded">
                        <table class="table text-center text-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->products as $no => $product)
                                    <tr>
                                        <th>{{ ++$no }}</th>
                                        <th>{{ $product->title }}</th>
                                        <th>{{ "Rp." . Number::format($product->price, locale: "id") }}</th>
                                        <th>{{ $product->quantity }}</th>
                                        <th>
                                            <div>
                                                <a href="{{ route("products.edit", ["product" => $product->id]) }}"
                                                    class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>

                                                <button wire:confirm="Yakin Ingin Menghapus?" wire:loading.attr='disabled'
                                                    wire:click='destroy({{ $product->id }})' class="btn btn-sm btn-danger">
                                                    Hapus
                                                </button>
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="mx-3">
                            {{ $this->products->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endvolt
</x-admin-layout>
