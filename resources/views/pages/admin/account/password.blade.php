<?php

// Mengimpor kelas Auth dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Auth;
// Mengimpor kelas Hash dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Hash;
// Mengimpor kelas Password dari namespace Illuminate\Validation\Rules
use Illuminate\Validation\Rules\Password;
// Mengimpor kelas ValidationException dari namespace Illuminate\Validation
use Illuminate\Validation\ValidationException;

// Menggunakan fungsi-fungsi dari Livewire\Volt
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

// Mendefinisikan state (keadaan) dengan beberapa variabel dan memberikan nilai awal kosong
state([
    'current_password' => '',
    'password' => '',
    'password_confirmation' => '',
]);

// Mendefinisikan aturan validasi untuk beberapa variabel, termasuk aturan 'current_password' yang disertakan oleh pengguna
rules([
    'current_password' => ['required', 'string', 'current_password'],
    'password' => ['required', 'string', Password::defaults(), 'confirmed'],
]);

// Membuat fungsi bernama $updatePassword
$updatePassword = function () {
    try {
        // Memvalidasi input dengan aturan yang telah ditentukan sebelumnya
        $validated = $this->validate();
    } catch (ValidationException $e) {
        // Jika validasi gagal, reset nilai variabel terkait dan lemparkan kembali exception
        $this->reset('current_password', 'password', 'password_confirmation');

        throw $e;
    }

    // Memperbarui password pengguna dengan password yang baru di-hash
    Auth::user()->update([
        'password' => Hash::make($validated['password']),
    ]);

    // Setelah berhasil, reset nilai variabel terkait
    $this->reset('current_password', 'password', 'password_confirmation');

    // Memanggil event 'password-updated'
    $this->dispatch('password-updated');
};

?>

@volt
    <div>

        <div class="alert alert-primary" role="alert">
            <strong>Kata Sandi Akun</strong>
            <p>Masukkan kata sandi saat ini, lalu masukkan kata sandi baru yang Anda inginkan. Ulangi kata sandi baru untuk
                memastikan tidak ada kesalahan pengetikan. Setelah itu, klik 'Perbarui Kata Sandi' untuk menyimpan
                perubahan. Pastikan informasi kata sandi Anda tetap aman dan rahasia.</p>
        </div>

        <form wire:submit="updatePassword">
            @csrf
            <div class="mb-3">
                <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                    wire:model="current_password" id="current_password" aria-describedby="current_passwordId"
                    placeholder="Enter current password" />
                @error('current_password')
                    <small id="current_passwordId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi Baru</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password"
                    id="password" aria-describedby="passwordId" placeholder="Enter current password" />
                @error('password')
                    <small id="passwordId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Ulangi Kata Sandi Baru</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                    wire:model="password_confirmation" id="password_confirmation" aria-describedby="password_confirmationId"
                    placeholder="Enter password confirmation" />
                @error('password_confirmation')
                    <small id="password_confirmationId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="row mb-3">
                <div class="col-md">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
                <div class="col-md align-self-center text-end">
                    <span wire:loading class="spinner-border spinner-border-sm"></span>
                    <x-action-message on="password-updated">
                    </x-action-message>
                </div>
            </div>
        </form>
    </div>
@endvolt
