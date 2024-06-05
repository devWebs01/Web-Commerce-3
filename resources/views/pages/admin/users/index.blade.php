<?php

use App\Models\User;
use function Livewire\Volt\{computed, state, usesPagination};
use function Laravel\Folio\name;

name('users.index');

state(['search'])->url();
usesPagination(theme: 'bootstrap');

$users = computed(function () {
    if ($this->search == null) {
        return User::query()->where('role', 'admin')->latest()->paginate(10);
    } else {
        return User::query()
            ->where('role', 'admin')
            ->where(function ($query) {
                $query
                    ->where('name', 'LIKE', "%{$this->search}%")
                    ->orWhere('email', 'LIKE', "%{$this->search}%")
                    ->orWhere('telp', 'LIKE', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);
    }
});

$destroy = function (User $user) {
    $user->delete();
};

?>
<x-admin-layout>
    <div>
        <x-slot name="title">Admin</x-slot>
        <x-slot name="header">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Admin</a></li>
        </x-slot>

        @volt
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah
                                    Admin</a>
                            </div>
                            <div class="col">
                                <input wire:model.live="search" type="search" class="form-control" name=""
                                    id="" aria-describedby="helpId" placeholder="Masukkan nama pengguna" />
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive border rounded">
                            <table class="table text-center text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telp</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->users as $no => $user)
                                        <tr>
                                            <td>{{ ++$no }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->telp }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <button
                                                        wire:confirm.prompt="Yakin Ingin Menghapus?\n\nTulis 'hapus' untuk konfirmasi!|hapus"
                                                        wire:loading.attr='disabled'
                                                        wire:click='destroy({{ $user->id }})'
                                                        class="btn btn-sm btn-danger">
                                                        {{ __('Hapus') }}
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="mx-3">
                                {{ $this->users->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endvolt

    </div>
</x-admin-layout>
