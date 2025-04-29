<?php

use App\Models\User;
use App\Models\Address;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use function Livewire\Volt\{state, on};

state([
    "name" => fn() => auth()->user()->name,
    "email" => fn() => auth()->user()->email,
    "telp" => fn() => auth()->user()->telp,
    "getAddressUser" => fn() => Address::where("user_id", auth()->id())->first() ?? null,
]);

on([
    "address-update" => function () {
        $this->getAddressUser = Address::where("user_id", auth()->id())->first();
    },
]);

$updateProfileInformation = function () {
    $user = Auth::user();

    $validated = $this->validate([
        "name" => ["required", "string", "max:255"],
        "email" => ["required", "string", "lowercase", "email", "max:255", Rule::unique(User::class)->ignore($user->id)],
        "telp" => ["required", "digits_between:11,12", "numeric", Rule::unique(User::class)->ignore($user->id)],
    ]);

    $user->fill($validated);

    if ($user->isDirty("email")) {
        $user->email_verified_at = null;
    }

    $user->save();

    $this->dispatch("profile-updated", name: $user->name);
};

$sendVerification = function () {
    $user = Auth::user();

    if ($user->hasVerifiedEmail()) {
        $path = session("url.intended", RouteServiceProvider::HOME);

        $this->redirect($path);

        return;
    }

    $user->sendEmailVerificationNotification();

    Session::flash("status", "verification-link-sent");
};

?>

<x-guest-layout>
    <x-slot name="title">Profile Akun</x-slot>
    @volt
        <div>

            <section class="pt-5">
                <div class="container mb-5">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 id="font-custom" class="display-2 fw-bold">
                                Profil Akun
                            </h2>
                        </div>
                        <div class="col-lg-6 mt-lg-0 align-content-center">
                            <p>
                                Selamat datang di halaman profil akunmu. Di sini, kamu dapat mengelola informasi pribadi
                                dan lokasi pengiriman paketmu dengan mudah.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="container">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3 gap-3" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <button class="nav-link bg-dark text-white position-relative active" id="v-pills-account-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-account" type="button" role="tab"
                            aria-controls="v-pills-account" aria-selected="true">
                            Profil

                            @if ($telp == null)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    !
                                </span>
                            @endif

                        </button>

                        <button class="nav-link bg-dark text-white position-relative" id="v-pills-location-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-location" type="button" role="tab"
                            aria-controls="v-pills-location" aria-selected="false">
                            Alamat

                            @if (!$getAddressUser)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    !
                                </span>
                            @endif

                        </button>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-account" role="tabpanel"
                                    aria-labelledby="v-pills-account-tab" tabindex="0">

                                    <div class="alert alert-dark alert-dismissible fade show" role="alert">

                                        <strong>Kamu dapat melihat dan memperbarui detail profil kamu, seperti nama,
                                            alamat email, dan nomor telepon. Pastikan informasi ini selalu up-to-date agar
                                            kami
                                            dapat memberikan pelayanan yang lebih baik.</strong>
                                    </div>

                                    <form wire:submit="updateProfileInformation">

                                        <div class="mb-3 row">
                                            <label for="inputname" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                            <div class="col-sm-10">
                                                <input wire:model="name" type="text" class="form-control" id="inputname">
                                                @error("name")
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputemail" class="col-sm-2 col-form-label">Email Akun</label>
                                            <div class="col-sm-10">
                                                <input wire:model="email" type="email" class="form-control"
                                                    id="inputemail">

                                                @error("email")
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="inputtelp" class="col-sm-2 col-form-label">Telepon Pengguna</label>
                                            <div class="col-sm-10">
                                                <input wire:model="telp" type="number" class="form-control" id="inputtelp">

                                                @error("telp")
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-end align-items-center">

                                            {{-- Loading Spinner --}}
                                            <div wire:loading class="spinner-border spinner-border-sm mx-5" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>

                                            {{-- Success Notif --}}
                                            <x-action-message class="me-3" on="profile-updated">
                                                Berhasil
                                            </x-action-message>

                                            <button type="submit" class="btn btn-dark">
                                                Simpan
                                            </button>

                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="v-pills-location" role="tabpanel"
                                    aria-labelledby="v-pills-location-tab" tabindex="0">

                                    @include("pages.user.address")
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-guest-layout>
