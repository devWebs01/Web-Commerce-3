<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

use function Livewire\Volt\state;

state([
    'name' => fn() => auth()->user()->name,
    'email' => fn() => auth()->user()->email,
]);

$updateProfileInformation = function () {
    $user = Auth::user();

    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
    ]);

    $user->fill($validated);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }
    $user->save();

    $this->dispatch('profile-updated', name: $user->name);
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



@volt
    <div>
        <div class="alert alert-primary" role="alert">
            <strong>Akun Profile</strong>
            <p>Berisi informasi penting tentang akun Anda sebagai pengguna. Di sini tersimpan data seperti nama, alamat
                email. Pastikan Anda selalu memperbarui informasi ini dengan benar agar kami dapat
                memberikan layanan yang optimal, termasuk dalam proses pengiriman pesanan Anda.</p>
        </div>

        <form wire:submit="updateProfileInformation">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name"
                    autocomplete="name" id="name" aria-describedby="nameId" placeholder="Enter account name" />

                @error('name')
                    <small id="nameId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email"
                    id="email" aria-describedby="emailId" placeholder="Enter account email" />

                @error('email')
                    <small id="emailId" class="form-text text-danger">{{ $message }}</small>
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
                    <x-action-message on="profile-updated">
                    </x-action-message>
                </div>
            </div>
        </form>
    </div>
@endvolt
