<?php

use App\Models\User;
use function Livewire\Volt\{computed, state, usesPagination};
use function Laravel\Folio\name;

name('customers');

state(['search'])->url();
usesPagination(theme: 'bootstrap');

$users = computed(function () {
    if ($this->search == null) {
        return User::query()->where('role', 'customer')->latest()->paginate(10);
    } else {
        return User::query()
            ->where('role', 'customer')
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

?>

<x-admin-layout>
    <div>
        <x-slot name="title">Pelanggan</x-slot>
        <x-slot name="header">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customers') }}">Pelanggan</a></li>
        </x-slot>

        @volt
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="mb-3">
                            <label for="email" class="form-label">Cari Pelanggan</label>
                            <input wire:model.live="search" type="search" class="form-control" name="search"
                                id="search" aria-describedby="helpId"
                                placeholder="Masukkan nama pengguna / email / telp" />
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
                                        <th>Provinsi</th>
                                        <th>Kota</th>
                                        <th>Alamat Lengkap</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->users as $no => $user)
                                        <tr>
                                            <td>{{ ++$no }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->telp }}</td>
                                            <td>{{ $user->address->province->name ?? '-' }}</td>
                                            <td>
                                                {{ $user->address->city->name ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $user->address->details ?? '-' }}
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
