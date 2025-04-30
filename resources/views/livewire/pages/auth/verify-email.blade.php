<?php

// Mengimpor kelas Logout dari namespace App\Livewire\Actions
use App\Livewire\Actions\Logout;
// Mengimpor kelas RouteServiceProvider dari namespace App\Providers
use App\Providers\RouteServiceProvider;
// Mengimpor kelas Auth dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Auth;
// Mengimpor kelas Session dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Session;

// Menggunakan fungsi-fungsi dari Livewire\Volt
use function Livewire\Volt\layout;

// Mengatur layout untuk halaman guest menggunakan 'layouts.guest'
layout('layouts.guest');

// Membuat fungsi bernama $sendVerification
$sendVerification = function () {
    // Memeriksa apakah email pengguna sudah terverifikasi
    if (Auth::user()->hasVerifiedEmail()) {
        // Jika sudah terverifikasi, arahkan pengguna ke halaman yang diinginkan atau halaman utama jika tidak ada yang diinginkan
        $this->redirect(
            session('url.intended', RouteServiceProvider::HOME),
            navigate: true
        );

        return;
    }

    // Jika belum terverifikasi, kirim ulang email verifikasi
    Auth::user()->sendEmailVerificationNotification();

    // Tampilkan pesan sukses dalam sesi
    Session::flash('status', 'verification-link-sent');
};

// Membuat fungsi bernama $logout
$logout = function (Logout $logout) {
    // Memanggil metode logout dari objek Logout
    $logout();

    // Arahkan pengguna ke halaman utama setelah logout
    $this->redirect('/', navigate: true);
};

?>


<div>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <x-primary-button wire:click="sendVerification">
            {{ __('Resend Verification Email') }}
        </x-primary-button>

        <button wire:click="logout" type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            {{ __('Log Out') }}
        </button>
    </div>
</div>
