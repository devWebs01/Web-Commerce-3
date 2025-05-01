<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;
use function Laravel\Folio\name;

name("login");

layout("layouts.auth-layout");

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    if (auth()->user()->role == "admin") {
        $this->redirect(session("url.intended", RouteServiceProvider::HOME), navigate: true);
    } elseif (auth()->user()->role == "superadmin") {
        $this->redirect(session("url.intended", RouteServiceProvider::HOME), navigate: true);
    } else {
        $this->redirect("/");
    }
};

?>

<x-slot name="title">
    Login Page
</x-slot>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="pe-lg-3">
                    <h1 id="font-custom" class="display-3 fw-bold mb-2 mb-md-3">
                        Belanja Mudah dan Aman Dalam Genggaman Anda
                    </h1>
                    <p class="lead mb-4">
                        Masuk untuk mendapatkan akses ke berbagai produk terbaik, penawaran eksklusif, dan pengalaman
                        belanja yang nyaman serta terpercaya.
                    </p>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="d-flex">
                            <div class="flex-shrink-0" style="color: #635bff;">
                                <h1>
                                    <i class="fa-solid fa-comments"></i>
                                </h1>
                            </div>
                            <div class="ms-3">
                                <p>Dukungan <br> Pelanggan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex">
                            <div style="color: #635bff;">
                                <h1>
                                    <i class="fa-solid fa-boxes-stacked"></i>
                                </h1>
                            </div>
                            <div class="ms-3">
                                <p>Produk <br> Terpercaya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-5">
                    <div class="card shadow-lg text-white text-left h-100">
                        <div class="card-body rounded p-4 p-xl-5" style="background-color: #635bff;">
                            <h2 id="font-custom" class="pb-3 text-center text-white fw-bold">Masuk Ke Akun Anda</h2>
                            <form wire:submit="login">
                                <div class="mb-3">
                                    <label for="email" class="form-label text-white">Email</label>
                                    <input type="email" wire:model="form.email" class="form-control text-white"
                                        id="email" aria-describedby="emailHelp">
                                    @error("email")
                                        <small id="emailHelp"
                                            class="form-text text-danger fw-bold my-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label text-white">Kata Sandi</label>
                                    <input type="password" wire:model="form.password" class="form-control text-white"
                                        id="password">
                                    @error("password")
                                        <small id="password"
                                            class="form-text text-danger fw-bold my-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input dark" type="checkbox" wire:model="form.remember"
                                            value="" id="flexCheckChecked">
                                        <label class="form-check-label text-white" for="flexCheckChecked">
                                            Ingat saya
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-light w-100 py-8 fs-4 mb-4 rounded-2">
                                    Masuk
                                </button>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="fs-4 mb-0 fw-bold">Belum punya akun?</p>
                                    <a class="text-white fs-4 fw-bold ms-2" href="{{ route("register") }}">Buat akun</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
