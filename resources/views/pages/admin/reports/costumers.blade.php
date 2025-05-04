<?php

use App\Models\User;
use function Livewire\Volt\{computed};
use function Laravel\Folio\name;

name("report.customers");

$users = computed(fn() => User::where("role", "customer")->latest()->get());

?>
<x-admin-layout>
    @include("components.partials.print")
    <x-slot name="title">Laporan Daftar Pelanggan</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("report.customers") }}">Laporan Daftar Pelanggan</a></li>
    </x-slot>
    @volt
        <div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table display table-sm">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telp</th>
                                    <th>Alamat</th>
                                    <th>Total Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->users as $no => $user)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td>{{ $user->name }}.</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->telp }}</td>
                                        <td>
                                            {{ $user->address->province->name ?? "-" }},
                                            {{ $user->address->city->name ?? "-" }}
                                        </td>
                                        <td>{{ $user->orders->count() }} Transaksi</td>
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
