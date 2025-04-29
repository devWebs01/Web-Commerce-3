<?php

use function Livewire\Volt\{state, usesFileUploads};
use App\Models\Order;
use App\Models\Bank;

usesFileUploads();

state([
    "order" => fn() => Order::find($id),
    "proof_of_payment",
    "banks" => fn() => Bank::get(),
]);

$submit = function () {
    $this->validate([
        "proof_of_payment" => "required|image|mimes:jpeg,png,jpg",
    ]);

    $order = $this->order;
    $order->update([
        "proof_of_payment" => $this->proof_of_payment->store("public/proof_of_payment"),
        "status" => "PENDING",
    ]);

    $this->redirect("/orders");
};

?>
<x-guest-layout>
    <x-slot name="title">Lanjut Pembayaran</x-slot>
    @volt
        <div>
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <h2 id="font-custom" class="display-6 fw-bold">
                            Selesaikan Pembayaran
                        </h2>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 align-content-center">
                        <p>
                            Kamu telah sampai di tahap akhir proses pembelian. Pastikan semua detail pesanan kamu sudah
                            benar,
                            lalu lanjutkan ke pembayaran. </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-5">
                        <h6 class="mb-3">Kirimkan ke salah satu rekening yang tertera di bawah ini:</h6>
                        @foreach ($banks as $index => $item)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row gap-3">
                                        <div class="col-2 text-end align-content-center">
                                            <h1 id="font-custom" class="display-1">{{ ++$index }}</h1>
                                        </div>
                                        <div class="col">
                                            <h2 id="font-custom" style="color: #565cff">
                                                {{ $item->account_number }}
                                            </h2>
                                            <h6 class="fw-bold border-bottom pb-2 mb-2">
                                                {{ $item->account_owner }}
                                            </h6>
                                            <h6 class="fw-bold">
                                                {{ $item->bank_name }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-7">
                        <h6>Total Pembayaran:</h6>
                        <div class="row">
                            <div class="col-lg-7">
                                <h1 id="font-custom">
                                    {{ "Rp. " . Number::format($order->total_amount, locale: "id") }}

                                </h1>
                            </div>
                            <div class="col">
                                @if ($proof_of_payment)
                                    <div class="card">
                                        <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image"
                                            href="{{ $proof_of_payment->temporaryUrl() }}">
                                            <img src="{{ $proof_of_payment->temporaryUrl() }}" class="img object-fit-cover"
                                                style="height: 250px; width: 100%" alt="proof_of_payment" />
                                        </a>
                                    </div>
                                @else
                                    <div class="card placeholder" style="height: 250px; width: 100%">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="my-3">
                            <label for="proof_of_payment" class="form-label">
                                Bukti Pembayaran
                                <div wire:loading class="spinner-border spinner-border-sm ms-2" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </label>
                            <form wire:submit="submit">
                                @csrf
                                <div class="input-group">
                                    <input type="file" class="form-control" wire:model='proof_of_payment'>
                                    <button class="btn btn-outline-secondary" type="submit">Submit</button>
                                </div>
                                @error("proof_of_payment")
                                    <p id="proof_of_payment" class="text-danger">{{ $message }}</p>
                                @enderror
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
    </x-costumer-layout>
