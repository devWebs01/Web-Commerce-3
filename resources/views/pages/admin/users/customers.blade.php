<?php

use App\Models\User;
use function Livewire\Volt\{computed};
use function Laravel\Folio\name;

name("customers");

$users = computed(function () {
    return User::query()->where("role", "customer")->latest()->paginate(10);
});

?>

<x-admin-layout>
    <div>
        <x-slot name="title">Pelanggan</x-slot>
        <x-slot name="header">
            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route("customers") }}">Pelanggan</a></li>
        </x-slot>

        @include("components.partials.datatables")

        @volt
            <div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-center text-nowrap" style="width: 100%;">
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
                                            <td>{{ $user->address->province->name ?? "-" }}</td>
                                            <td>
                                                {{ $user->address->city->name ?? "-" }}
                                            </td>
                                            <td>
                                                {{ $user->address->details ?? "-" }}
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

    </div>
</x-admin-layout>
