<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Laravel\Folio\name;

name("register");

layout("components.layouts.auth-layout");

state([
    "name" => "",
    "email" => "",
    "password" => "",
    "password_confirmation" => "",
    "role" => "customer",
]);

rules([
    "name" => ["required", "string", "max:255"],
    "email" => ["required", "string", "lowercase", "email", "max:255", "unique:" . User::class],
    "password" => ["required", "string", "confirmed", Rules\Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();

    $validated["password"] = Hash::make($validated["password"]);
    $validated["role"] = $this->role;

    event(new Registered(($user = User::create($validated))));

    Auth::login($user);

    $this->redirect(RouteServiceProvider::HOME);
};

?>

<x-slot name="title">
    Register Page
</x-slot>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="pe-lg-3">
                    <h1 id="font-custom" class="display-3 fw-bold mb-2 mb-md-3">Bergabung Sekarang dan Nikmati Kemudahan
                        Layanan Kami</h1>
                    <p class="lead mb-4">
                        Daftar untuk mendapatkan akses penuh ke berbagai fitur dan layanan yang kami sediakan secara
                        gratis dan mudah.
                    </p>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="d-flex">
                            <div class="flex-shrink-0" style="color: #635bff;">
                                <h1>
                                    <i class="fa-solid fa-headset"></i>
                                </h1>
                            </div>
                            <div class="ms-3">
                                <p>Layanan <br> Pelanggan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex">
                            <div style="color: #635bff;">
                                <h1>
                                    <i class="fa-solid fa-shield"></i>
                                </h1>
                            </div>
                            <div class="ms-3">
                                <p>Akses <br> Aman & Nyaman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-5">
                    <div class="card shadow-lg text-white text-left h-100">
                        <div class="card-body rounded p-4 p-xl-5" style="background-color: #635bff;">
                            <form wire:submit="register">
                                <input type="hidden" wire:model="role" value="customer">
                                <div class="mb-3">
                                    <label for="name" class="form-label text-white">Nama Lengkap</label>
                                    <input type="text" wire:model="name" class="form-control text-white"
                                        id="name">
                                    @error("name")
                                        <small class="form-text text-danger fw-bold my-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-white">Email</label>
                                    <input type="email" wire:model="email" class="form-control text-white"
                                        id="email">
                                    @error("email")
                                        <small class="form-text text-danger fw-bold my-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label text-white">Kata Sandi</label>
                                    <input type="password" wire:model="password" class="form-control text-white"
                                        id="password">
                                    @error("password")
                                        <small class="form-text text-dark">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label text-white">Ulangi Kata
                                        Sandi</label>
                                    <input type="password" wire:model="password_confirmation"
                                        class="form-control text-white" id="password_confirmation">
                                    @error("password_confirmation")
                                        <small class="form-text text-dark">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-light w-100 py-8 fs-4 mb-4 rounded-2">
                                    Daftar
                                </button>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
                                    <a class="text-white fs-4 fw-bold ms-2" href="{{ route("login") }}">Masuk
                                        Sekarang</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
