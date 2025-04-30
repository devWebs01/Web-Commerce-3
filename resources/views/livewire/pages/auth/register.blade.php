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

name('register');

layout('layouts.auth-layout');

state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => '',
    'role' => 'customer',
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);
    $validated['role'] = $this->role;

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
                    <h1 id="font-custom" class="display-3 fw-bold mb-2 mb-md-3">Tampil Beda dengan Koleksi Streetwear Terbaru
                    </h1>
                    <p class="lead mb-4">
                        Kami menjamin ketersediaan produk hingga 99,99%, memastikan kamu dapat menemukan pilihan fashion streetwear idaman tanpa hambatan.
                    </p>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div style="color: #f35525;">
                                    <svg class="bi bi-chat-right-fill" fill="currentColor" height="32"
                                        viewbox="0 0 16 16" width="32" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14 0a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ms-3">
                                <p>Dukungan <br> Pelanggan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex">
                            <div style="color: #f35525;">
                                <svg class="bi bi-shield-fill-check" fill="currentColor" height="32"
                                    viewbox="0 0 16 16" width="32" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"
                                        fill-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ms-3">
                                <p>Produk <br> Berkualitas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-5">
                    <div class="card shadow-lg text-white text-left h-100">
                        <div class="card-body rounded p-4 p-xl-5" style="background-color: #f35525;">
                            <form wire:submit="register">
                                <input type="hidden" wire:model="role" value="customer">
                                <div class="mb-3">
                                    <label for="name" class="form-label text-white">Nama Lengkap</label>
                                    <input type="text" wire:model="name" class="form-control text-white"
                                        id="name" aria-describedby="nameHelp">
                                    @error('name')
                                        <small id="nameHelp" class="form-text text-dark">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-white">Email</label>
                                    <input type="email" wire:model="email" class="form-control text-white"
                                        id="email" aria-describedby="emailHelp">
                                    @error('email')
                                        <small id="emailHelp" class="form-text text-dark">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label text-white">Kata Sandi</label>
                                    <input type="password" wire:model="password" class="form-control text-white"
                                        id="password">
                                    @error('password')
                                        <small id="password" class="form-text text-dark">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label text-white">Ulangi Kata
                                        sandi</label>
                                    <input type="password" wire:model="password_confirmation"
                                        class="form-control text-white" id="password_confirmation">
                                    @error('password_confirmation')
                                        <small id="password_confirmation"
                                            class="form-text text-dark">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-light w-100 py-8 fs-4 mb-4 rounded-2">
                                    Daftar
                                </button>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
                                    <a class="text-white fs-4 fw-bold ms-2" href="{{ route('login') }}">Masuk
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
