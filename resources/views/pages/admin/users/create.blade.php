<?php

use App\Models\User;
use function Livewire\Volt\{state, rules};
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

name("users.create");
state(["name", "email", "password", "telp"]);

rules([
    "name" => "required|min:5",
    "email" => "required|min:5|unique:users,email",
    "password" => "required|min:5",
    "telp" => "required|unique:users,telp,id|digits_between:11,13",
]);

$save = function () {
    $validateData = $this->validate();
    $validateData["role"] = "admin";
    User::create($validateData);

    LivewireAlert::text("Proses berhasil!")
        ->success()
        ->timer(3000) // Dismisses after 3 seconds
        ->show();

    $this->redirectRoute("users.index");
};

?>
<x-admin-layout>
    <x-slot name="title">Tambah Admin Baru</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("users.index") }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route("users.create") }}">Tambah Admin</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="alert alert-primary" role="alert">
                        <strong>Tambah Admin</strong>
                        <p>Pada halaman tambah pengguna, Anda dapat memasukkan informasi pengguna baru, seperti nama, alamat
                            email,
                            kata sandi, dan peran pengguna (admin)
                        </p>
                    </div>
                </div>

                <div class="card-body">
                    <form wire:submit="save">
                        @csrf
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error("name") is-invalid @enderror"
                                        wire:model="name" id="name" aria-describedby="nameId" placeholder="..."
                                        autofocus autocomplete="name" />
                                    @error("name")
                                        <small id="nameId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error("email") is-invalid @enderror"
                                        wire:model="email" id="email" aria-describedby="emailId" placeholder="..." />
                                    @error("email")
                                        <small id="emailId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="telp" class="form-label">No. Telepon</label>
                                    <input type="number" class="form-control @error("telp") is-invalid @enderror"
                                        wire:model="telp" id="telp" aria-describedby="telpId" placeholder="..." />
                                    @error("telp")
                                        <small id="telpId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata Sandi</label>
                                    <input type="password" class="form-control @error("password") is-invalid @enderror"
                                        wire:model="password" id="password" aria-describedby="passwordId"
                                        placeholder="..." />
                                    @error("password")
                                        <small id="passwordId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>
                            <div class="col-md align-self-center text-end">
                                <span wire:loading class="spinner-border spinner-border-sm"></span>
                                <x-action-message on="save">
                                </x-action-message>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endvolt
</x-admin-layout>
