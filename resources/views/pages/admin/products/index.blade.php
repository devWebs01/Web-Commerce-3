<?php

use function Livewire\Volt\{computed, usesPagination, state, uses};
use App\Models\Product;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

name('products.index');
usesPagination(theme: 'bootstrap');

uses([LivewireAlert::class]);
state(['search'])->url();

$products = computed(function () {
    if ($this->search == null) {
        return Product::query()->latest()->paginate(10);
    } else {
        return Product::query()
            ->where('title', 'LIKE', "%{$this->search}%")
            ->orWhere('price', 'LIKE', "%{$this->search}%")
            ->orWhere('quantity', 'LIKE', "%{$this->search}%")
            ->latest()
            ->paginate(10);
    }
});

$destroy = function (product $product) {
    try {
        Storage::delete($product->image);
        $product->delete();
        $this->alert('success', 'Data produk berhasil di hapus!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    } catch (\Throwable $th) {
        $this->alert('error', 'Data produk gagal di hapus!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
};
?>


<x-admin-layout>
    <x-slot name="title">Produk Toko</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk Toko</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('products.create') }}"
                                class="btn btn-primary {{ auth()->user()->role == 'superadmin' ?: 'd-none' }}"">Tambah
                                Produk Toko</a>
                        </div>
                        <div class="col">
                            <input wire:model.live="search" type="search" class="form-control" name="search"
                                id="search" aria-describedby="helpId" placeholder="Masukkan nama produk toko" />
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive border rounded px-3">
                        <table class="table text-center text-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->products as $no => $product)
                                    <tr>
                                        <th>{{ ++$no }}</th>
                                        <th>{{ $product->title }}</th>
                                        <th>{{ 'Rp.' . Number::format($product->price, locale: 'id') }}</th>
                                        <th>
                                            <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                                                class="btn btn-sm btn-warning">
                                                Edit
                                            </a>

                                            <button wire:loading.attr='disabled' wire:click='destroy({{ $product->id }})'
                                                class="btn btn-sm btn-danger {{ auth()->user()->role == 'superadmin' ?: 'd-none' }}">
                                                Hapus
                                            </button>
                                        </th>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        {{ $this->products->links() }}
                    </div>

                </div>
            </div>
        </div>
    @endvolt
</x-admin-layout>
