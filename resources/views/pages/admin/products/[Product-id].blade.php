<?php

use function Livewire\Volt\{state, rules, usesFileUploads};
use App\Models\Category;
use App\Models\Product;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

name("products.edit");

usesFileUploads();

state([
    "categories" => fn() => Category::get(),
    "category_id" => fn() => $this->product->category_id,
    "title" => fn() => $this->product->title,
    "price" => fn() => $this->product->price,
    "quantity" => fn() => $this->product->quantity,
    "weight" => fn() => $this->product->weight,
    "description" => fn() => $this->product->description,
    "image",
    "product",
]);

rules([
    "category_id" => "required|exists:categories,id",
    "title" => "required|min:5",
    "price" => "required|numeric",
    "quantity" => "required|numeric",
    "image" => "nullable",
    "weight" => "required|numeric",
    "description" => "required|min:10",
]);

$save = function () {
    $validate = $this->validate();
    if ($this->image) {
        $validate["image"] = $this->image->store("public/images");
        Storage::delete($this->product->image);
    } else {
        $validate["image"] = $this->product->image;
    }
    product::whereId($this->product->id)->update($validate);

    $this->redirectRoute("products.index");

    LivewireAlert::text("Proses berhasil!")
        ->success()
        ->timer(3000) // Dismisses after 3 seconds
        ->show();
};
?>
<x-admin-layout>
    <x-slot name="title">Produk</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("products.index") }}">Produk Toko</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route("products.edit", ["product" => $product->id]) }}">{{ $product->title }}</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card">
                <div class="card-body">
                    <form wire:submit="save" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md mb-3">
                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="img rounded object-fit-cover"
                                        alt="image" loading="lazy" height="490px" width="100%" />
                                @elseif ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" class="img rounded object-fit-cover"
                                        alt="image" loading="lazy" height="490px" width="100%" />
                                @endif
                            </div>
                            <div class="col-md">

                                <div class="mb-3">
                                    <label for="title" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control @error("title") is-invalid @enderror"
                                        wire:model="title" id="title" aria-describedby="titleId" placeholder="..." />
                                    @error("title")
                                        <small id="titleId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga Mulai Dari</label>
                                    <input type="number" class="form-control @error("price") is-invalid @enderror"
                                        wire:model="price" id="price" aria-describedby="priceId" placeholder="..." />
                                    @error("price")
                                        <small id="priceId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Gambar Produk</label>
                                    <input type="file" class="form-control @error("image") is-invalid @enderror"
                                        wire:model="image" id="image" aria-describedby="imageId" placeholder="..."
                                        accept="image/*" />
                                    @error("image")
                                        <small id="imageId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Jumlah Produk</label>
                                    <input type="number" class="form-control @error("quantity") is-invalid @enderror"
                                        wire:model="quantity" id="quantity" aria-describedby="quantityId"
                                        placeholder="..." />
                                    @error("quantity")
                                        <small id="quantityId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori Produk</label>
                                    <select class="form-select" wire:model="category_id" id="category_id">
                                        <option>Pilih salah satu</option>
                                        @foreach ($this->categories as $category)
                                            <option value="{{ $category->id }}">- {{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                    @error("category_id")
                                        <small id="category_id" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="weight" class="form-label">Berat Produk</label>
                                    <input type="number" class="form-control @error("weight") is-invalid @enderror"
                                        wire:model="weight" id="weight" aria-describedby="weightId" placeholder="..." />
                                    @error("weight")
                                        <small id="weightId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Penjelasan Produk</label>
                                <textarea class="form-control @error("description") is-invalid @enderror" wire:model="description" id="description"
                                    aria-describedby="descriptionId" placeholder="..." rows="8"></textarea>

                                @error("description")
                                    <small id="descriptionId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-end">

                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    @endvolt

</x-admin-layout>
