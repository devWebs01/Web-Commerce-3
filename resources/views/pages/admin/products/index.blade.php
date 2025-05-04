<?php

use function Livewire\Volt\{computed, uses, state, usesFileUploads};
use App\Models\Product;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

usesFileUploads();
uses([LivewireAlert::class]);

name("products.index");

$products = computed(function () {
    return Product::query()->latest()->get();
});

state(["file"]);

$destroy = function (product $product) {
    try {
        Storage::delete($product->image);
        $product->delete();
        $this->alert("success", "Data produk berhasil di hapus!", [
            "position" => "top",
            "timer" => 3000,
            "toast" => true,
        ]);
    } catch (\Throwable $th) {
        $this->alert("error", "Data produk gagal di hapus!", [
            "position" => "top",
            "timer" => 3000,
            "toast" => true,
        ]);
    }

    $this->redirectRoute("products.index");
};

// Import
$import = function (Request $request) {
    $this->validate([
        "file" => "required|file|mimes:xlsx,xls,csv",
    ]);

    Excel::import(new ProductsImport(), $this->file);

    $this->redirectRoute("products.index");
};

// Export
$export = function () {
    return Excel::download(new ProductsExport(), "products.xlsx");

    $this->redirectRoute("products.index");
};
?>

<x-admin-layout>
    <x-slot name="title">Produk Toko</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("products.index") }}">Produk Toko</a></li>
    </x-slot>

    @include("components.partials.datatables")

    @volt
        <div>
            <div class="card">
                <div class="card-header row">
                    <div class="col-md-6">
                        <a href="{{ route("products.create") }}"
                            class="btn btn-primary {{ auth()->user()->role == "superadmin" ?: "d-none" }}">Tambah
                            Produk Toko</a>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end gap-2">
                        <button wire:click="export" class="btn btn-success">Export Produk</button>

                        <!-- Modal trigger button -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalId">
                            Import Produk
                        </button>
                    </div>
                </div>
                <div class="card-body p-3" wire:ignore>
                    <div class="table-responsive px-3">
                        <table class="table text-center text-nowrap" style="width: 100%;">
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
                                        <th>{{ Str::limit($product->title, 50, "...") }}</th>
                                        <th>{{ formatRupiah($product->price) }}</th>
                                        <th>
                                            <a href="{{ route("products.edit", ["product" => $product->id]) }}"
                                                class="btn btn-sm btn-warning">
                                                Edit
                                            </a>

                                            <button wire:loading.attr='disabled' wire:click='destroy({{ $product->id }})'
                                                class="btn btn-sm btn-danger {{ auth()->user()->role == "superadmin" ?: "d-none" }}">
                                                Hapus
                                            </button>
                                        </th>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div wire:ignore class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static"
                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6>Pilih File Excel untuk Diimpor:</h6>
                        </div>
                        <form wire:submit="import" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <input wire:model="file" type="file" name="file" class="form-control"
                                        accept=".xlsx,.xls,.csv" required>
                                </div>
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary">Import Produk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-admin-layout>
