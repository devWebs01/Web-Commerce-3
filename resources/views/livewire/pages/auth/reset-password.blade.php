<?php

// Mengimpor kelas PasswordReset dari namespace Illuminate\Auth\Events
use Illuminate\Auth\Events\PasswordReset;
// Mengimpor kelas Hash dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Hash;
// Mengimpor kelas Password dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Password;
// Mengimpor kelas Session dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Session;
// Mengimpor kelas Str dari namespace Illuminate\Support
use Illuminate\Support\Str;
// Mengimpor aturan Password dari namespace Illuminate\Validation\Rules
use Illuminate\Validation\Rules;

// Menggunakan fungsi-fungsi dari Livewire\Volt
use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

// Mengatur layout untuk halaman guest menggunakan 'layouts.guest'
layout('layouts.guest');

// Mendefinisikan state (keadaan) dengan variabel 'token' yang dikunci dan variabel lainnya dengan nilai awal
state('token')->locked();

state([
    'email' => fn () => request()->string('email')->value(),
    'password' => '',
    'password_confirmation' => ''
]);

// Mendefinisikan aturan validasi untuk beberapa variabel
rules([
    'token' => ['required'],
    'email' => ['required', 'string', 'email'],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

// Membuat fungsi bernama $resetPassword
$resetPassword = function () {
    // Memvalidasi input dengan aturan yang telah ditentukan sebelumnya
    $this->validate();

    // Melakukan reset password dengan menggunakan Password Broker
    $status = Password::reset(
        $this->only('email', 'password', 'password_confirmation', 'token'),
        function ($user) {
            // Jika reset berhasil, update password pada model user dan simpan ke database
            $user->forceFill([
                'password' => Hash::make($this->password),
                'remember_token' => Str::random(60),
            ])->save();

            // Memanggil event PasswordReset
            event(new PasswordReset($user));
        }
    );

    // Jika password berhasil direset, arahkan pengguna ke halaman login
    if ($status != Password::PASSWORD_RESET) {
        // Jika terjadi kesalahan, tambahkan pesan kesalahan ke variabel 'email'
        $this->addError('email', __($status));

        return;
    }

    // Jika berhasil, tampilkan pesan sukses dalam sesi
    Session::flash('status', __($status));

    // Arahkan pengguna ke halaman login setelah reset password
    $this->redirectRoute('login', navigate: true);
};

?>


<div>
    <form wire:submit="resetPassword">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</div>
