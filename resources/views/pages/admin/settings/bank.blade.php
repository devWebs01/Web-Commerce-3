<?php

use function Livewire\Volt\{state, computed, usesPagination, on, rules, uses};
use App\Models\Bank;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

usesPagination();

state(['swap' => false, 'account_owner', 'account_number', 'bank_name', 'bankId']);

$banks = computed(fn() => Bank::latest()->paginate(5));

rules([
    'account_owner' => 'required|string|min:5',
    'bank_name' => 'required|string|min:3',
    'account_number' => 'required|min:10',
]);

$save = function (Bank $bank) {
    $validate = $this->validate();
    if ($this->bankId == null) {
        $bank->create($validate);
    } else {
        $bankUpdate = Bank::find($this->bankId);
        $bankUpdate->update($validate);
    }
    $this->reset('account_owner', 'bank_name', 'account_number');

    $this->alert('success', 'Data rekening berhasil di perbaharui!', [
        'position' => 'top',
        'timer' => 3000,
        'toast' => true,
    ]);
};

$edit = function (Bank $bank) {
    $banks = Bank::find($bank->id);
    $this->bankId = $bank->id;
    $this->account_owner = $bank->account_owner;
    $this->account_owner = $bank->account_owner;
    $this->bank_name = $bank->bank_name;
    $this->account_number = $bank->account_number;
};

$destroy = function (Bank $bank) {
    $bank->delete();
    $this->reset('account_owner', 'bank_name', 'account_number');
};

?>
@volt
    <div>
        <div class="alert alert-primary" role="alert">
            <strong>Rekening Pembayaran</strong>
            <p>tempat Anda dapat menyimpan informasi penting tentang rekening bank toko Anda. Pastikan untuk
                memasukkan informasi dengan benar untuk memastikan kelancaran proses pembayaran dan transaksi keuangan.</p>
        </div>
        <form wire:submit="save">
            @csrf

            <div class="mb-3">
                <label for="account_owner" class="form-label">Nama Pemilik</label>
                <input type="text" class="form-control @error('account_owner') is-invalid @enderror"
                    wire:model="account_owner" id="account_owner" aria-describedby="account_ownerId"
                    placeholder="Enter account owner" />
                @error('account_owner')
                    <small id="account_ownerId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="bank_name" class="form-label">Nama Bank</label>
                <input type="text" class="form-control @error('bank_name') is-invalid @enderror" wire:model="bank_name"
                    id="bank_name" aria-describedby="bank_nameId" placeholder="Enter bank name" />
                @error('bank_name')
                    <small id="bank_nameId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="account_number" class="form-label">Nomor Rekening</label>
                <input type="text" class="form-control @error('account_number') is-invalid @enderror"
                    wire:model="account_number" id="account_number" aria-describedby="account_numberId"
                    placeholder="Enter bank number" />
                @error('account_number')
                    <small id="account_numberId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <button type="reset" class="btn btn-danger">
                    Reset
                </button>
                <div>
                    <span wire:loading class="spinner-border spinner-border-sm"></span>
                </div>
                <button type="submit" class=" ms-3 btn btn-primary">
                    Submit
                </button>
            </div>
        </form>

        <div class="table-responsive border rounded my-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Atas Nama</th>
                        <th>Jenis Bank</th>
                        <th>Nomor Bank</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->banks as $no => $bank)
                        <tr>
                            <th>{{ ++$no }}</th>
                            <th>{{ $bank->account_owner }}</th>
                            <th>{{ $bank->bank_name }}</th>
                            <th>{{ $bank->account_number }}</th>
                            <th>
                                <div class="btn-group">
                                    <button wire:loading.attr='disabled' wire:click='edit({{ $bank->id }})'
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </button>
                                    <button wire:loading.attr='disabled' wire:click='destroy({{ $bank->id }})'
                                        class="btn btn-danger btn-sm join-item">
                                        Hapus
                                    </button>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
                {{ $this->banks->links() }}
            </table>
        </div>

    </div>
@endvolt
