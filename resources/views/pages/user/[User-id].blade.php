<?php

use App\Models\User;
use App\Models\Address;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use function Livewire\Volt\{state, on, uses};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use function Laravel\Folio\name;

name('customer.account');

uses([LivewireAlert::class]);

state([
    'name' => fn() => auth()->user()->name,
    'email' => fn() => auth()->user()->email,
    'telp' => fn() => auth()->user()->telp,
    'getAddressUser' => fn() => Address::where('user_id', auth()->id())->first() ?? null,
]);

on([
    'address-update' => function () {
        $this->getAddressUser = Address::where('user_id', auth()->id())->first();
    },
]);

$updateProfileInformation = function () {
    $user = Auth::user();

    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        'telp' => ['required', 'digits_between:11,12', 'numeric', Rule::unique(User::class)->ignore($user->id)],
    ]);

    $user->fill($validated);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    $this->alert('success', 'Profil telah diperbaharui.', [
        'position' => 'top',
        'timer' => '2000',
        'toast' => true,
        'timerProgressBar' => true,
        'text' => '',
    ]);
};

$sendVerification = function () {
    $user = Auth::user();

    if ($user->hasVerifiedEmail()) {
        $path = session('url.intended', RouteServiceProvider::HOME);

        $this->redirect($path);

        return;
    }

    $user->sendEmailVerificationNotification();

    Session::flash('status', 'verification-link-sent');
};

?>

<x-guest-layout>
    <x-slot name="title">Profile Akun</x-slot>
    @volt
        <div>

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

                <div class="card border-0">
                    <div class="card-body">

                        <section>
                            <ul class="nav nav-pills justify-content-center p-2 border rounded-top-5" id="pills-tab"
                                role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link position-relative active" id="pills-profile-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">
                                        Profil
                                        @if (!$telp)
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                !
                                            </span>
                                        @endif
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link position-relative" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">
                                        Alamat
                                        @if (!$getAddressUser)
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                !
                                            </span>
                                        @endif
                                    </button>
                                </li>
                            </ul>
                        </section>

                        <section class="p-2 border my-3 rounded-bottom-5">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab" tabindex="0">
                                    @include('pages.user.profile')
                                </div>
                                <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                                    tabindex="0">
                                    @include('pages.user.address')
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-guest-layout>
