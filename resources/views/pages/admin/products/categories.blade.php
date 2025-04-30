<?php

use function Livewire\Volt\{state, rules, computed, usesPagination, uses};
use App\Models\Category;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);
name('categories-product');
state(['name', 'categoryId']);
rules(['name' => 'required|min:6|string']);

usesPagination(theme: 'bootstrap');

$categories = computed(fn() => Category::latest()->paginate(10));

$save = function (Category $category) {
    $validate = $this->validate();

    if ($this->categoryId == null) {
        $category->create($validate);
    } else {
        $categoryUpdate = Category::find($this->categoryId);
        $categoryUpdate->update($validate);
    }
    $this->reset('name');
};

$edit = function (Category $category) {
    $category = Category::find($category->id);
    $this->categoryId = $category->id;
    $this->name = $category->name;
};

$destroy = function (Category $category) {
    try {
        $category->delete();
        $this->reset('name');
        $this->alert('success', 'Data kategori berhasil di hapus!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    } catch (\Throwable $th) {
        $this->alert('error', 'Data kategori gagal di hapus!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
};
?>


<x-admin-layout>
    <div>
        <x-slot name="title">Kategori Produk</x-slot>
        <x-slot name="header">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories-product') }}">Kategori Produk</a></li>
        </x-slot>

        @volt
            <div>
                <div class="card">
                    <div class="card-header">
                        <form wire:submit="save">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Kategori
                                    Produk</label>
                                <input type="text" class="form-control" wire:model="name" id="name"
                                    aria-describedby="helpId" placeholder="Masukkan kategori baru / edit" />

                                @error('name')
                                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                                <div class="row justift-content-between">
                                    <div class="col-md mt-3">
                                        <button type="reset" class="btn btn-danger">
                                            Reset
                                        </button>

                                    </div>
                                    <div class="col align-self-center text-center">
                                        <span wire:loading class="spinner-border spinner-border-sm"></span>
                                        <x-action-message on="save">
                                        </x-action-message>
                                    </div>
                                    <div class="col-md mt-3 text-end">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive border rounded px-3">
                            <table class="table text-center text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->categories as $no => $category)
                                        <tr>
                                            <td>{{ ++$no }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                <a wire:click='edit({{ $category->id }})'
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <button wire:loading.attr='disabled'
                                                    wire:click='destroy({{ $category->id }})' class="btn btn-sm btn-danger">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            {{ $this->categories->links() }}
                        </div>

                    </div>
                </div>
            </div>
        @endvolt

    </div>
</x-admin-layout>
