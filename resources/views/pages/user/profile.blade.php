<div class="alert alert-dark alert-dismissible fade show" role="alert">
    <strong>
        Kamu dapat melihat dan memperbarui detail profil kamu, seperti nama,
        alamat email, dan nomor telepon. Pastikan informasi ini selalu up-to-date agar
        kami dapat memberikan pelayanan yang lebih baik.
    </strong>
</div>

<form wire:submit="updateProfileInformation">
    <div class="mb-3 row">
        <label for="inputname" class="col-sm-2 col-form-label">Nama Lengkap</label>
        <div class="col-sm-10">
            <input wire:model="name" type="text" class="form-control" id="inputname">
            @error('name')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label for="inputemail" class="col-sm-2 col-form-label">Email Akun</label>
        <div class="col-sm-10">
            <input wire:model="email" type="email" class="form-control" id="inputemail">

            @error('email')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    <div class="mb-3 row">
        <label for="inputtelp" class="col-sm-2 col-form-label">Telepon
            Pengguna</label>
        <div class="col-sm-10">
            <input wire:model="telp" type="number" class="form-control" id="inputtelp">

            @error('telp')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    <div class="mb-3 d-flex justify-content-end align-items-center">
        <button type="submit" class="btn btn-dark">
            <div wire:loading class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span wire:loading.class='d-none'>
                {{ !$telp ? 'SUBMIT' : 'EDIT' }}
            </span>
        </button>
    </div>
</form>
