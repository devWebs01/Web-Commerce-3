<?php

use function Livewire\Volt\{state, rules, uses};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Item;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

name('transactions.show');

state([
    'order' => fn() => Order::find($id),
    'orderItems' => fn() => Item::where('order_id', $this->order->id)->get(),
    'tracking_number',
]);

rules([
    'tracking_number' => 'required|min:10',
]);

$confirm = function () {
    if ($this->order->courier == 'Ambil Sendiri') {
        $this->order->update(['status' => 'PICKUP']);
    } else {
        $this->order->update(['status' => 'PACKED']);
    }

    $this->dispatch('orders-alert');
};

$saveTrackingNumber = function () {
    $validate = $this->validate();
    $validate['status'] = 'SHIPPED';

    $this->order->update($validate);
    $this->alert('success', 'Pesanan telah di inputkan resi!', [
        'position' => 'top',
        'timer' => 3000,
        'toast' => true,
    ]);

    $this->dispatch('orders-alert');
};

$cancelOrder = function ($orderId) {
    $order = $this->order;

    $orderItems = Item::where('order_id', $order->id)->get();
    foreach ($orderItems as $orderItem) {
        $variant = Variant::findOrFail($orderItem->variant_id);
        $newQuantity = $variant->stock + $orderItem->qty;

        // Memperbarui quantity pada tabel produk
        $variant->update(['stock' => $newQuantity]);
    }
    $order->update(['status' => 'CANCELLED']);

    $this->dispatch('orders-alert');
    $this->alert('success', 'Pesanan telah di batalkan!', [
        'position' => 'top',
        'timer' => 3000,
        'toast' => true,
    ]);
};

$complatedOrder = fn() => $this->order->update(['status' => 'COMPLETED']);

?>
<x-admin-layout>
    <x-slot name="title">Transaksi {{ $order->invoice }}</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transaksi</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('transactions.show', ['order' => $order->id]) }}">{{ $order->invoice }}</a></li>
    </x-slot>
    @volt
        <div>
            <div class="card d-print-none">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <form wire:submit="saveTrackingNumber">
                                @if ($order->status == 'PACKED')
                                    <div class="input-group mb-3">
                                        <input wire:model="tracking_number" type="text"
                                            class="form-control  @error('tracking_number')
                                        is-invalid
                                        @enderror"
                                            placeholder="Masukkan resi...">

                                        <button class="btn btn-primary  rounded-end-1" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                    @error('tracking_number')
                                        <small id="tracking_numberId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                @else
                                    <button type="button" class="btn btn-primary position-relative">
                                        {{ $order->status }}
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                        </span>
                                    </button>
                                @endif
                            </form>
                        </div>
                        <div class="col d-flex justify-content-end gap-2">
                            <span wire:loading class="spinner-border spinner-border-sm align-self-center"></span>
                            <div class="row">
                                @if ($order->status == 'PENDING')
                                    <div class="col-auto">
                                        <button wire:click='confirm' class="btn btn-primary" type="submit">
                                            <i class="ti ti-circle-check fs-3"></i>
                                            Proses Pesanan
                                        </button>
                                    </div>
                                @endif
                                @if (
                                    $order->status === 'PENDING' ||
                                        $order->status === 'PICKUP' ||
                                        ($order->status === 'PACKED' && auth()->user()->role === 'superadmin'))
                                    <div class="col-auto">
                                        <button class="btn btn-danger" wire:click="cancelOrder('{{ $order->id }}')"
                                            role="button">
                                            <i class="ti ti-x fs-3"></i>
                                            Batalkan Pesanan
                                        </button>
                                    </div>
                                @endif

                                <div class="col-auto">
                                    <button class="btn btn-dark print-page" onclick="window.print()" type="button">
                                        <i class="ti ti-printer fs-3"></i>
                                        Cetak
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($order->status == 'CANCELLED')
                <div class="alert alert-danger" role="alert">
                    <strong>Pengingat!</strong>
                    <span>
                        Mohon hubungi mengkonfirmasi pembatalkan pesanan melalui no. telpon yang tertera...

                        @if ($order->payment_method != 'COD (Cash On Delivery)' && $order->status === 'PICKUP')
                            Dan lakukan pengembalian dana kepada customer
                        @endif
                        
                    </span>
                </div>
            @endif

            <div class="card d-print-block">
                <div class="card-body">
                    <div class="invoice-123" id="printableArea" style="display: block;">
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <div>
                                    <address>
                                        <h6>Pesanan Dari,</h6>
                                        <p>
                                            {{ $order->user->name }} - {{ $order->status }} <br>
                                            {{ $order->user->email }} <br>
                                            {{ $order->user->telp }}
                                        </p>
                                        <h6>
                                            {{ $order->user->address->province->name }},
                                            {{ $order->user->address->city->name }} <br>
                                        </h6>
                                        <p>
                                            {{ $order->user->address->details }}
                                        </p>
                                    </address>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md">
                                        <h6>Nomor Faktur:
                                            {{ $order->invoice }}
                                        </h6>
                                        <h6>Nomor Resi Pesanan:
                                            {{ $order->tracking_number ?? '-' }}
                                        </h6>
                                        <h6>Pengiriman:
                                            {{ $order->courier }}
                                        </h6>
                                        <h6>Tambahan:
                                            {{ $order->protect_cost == true ? 'Bubble Wrap' : '-' }}
                                        </h6>

                                        <h6>Metode Pembayaran:
                                            {{ $order->payment_method }}
                                        </h6>
                                    </div>
                                    @if ($order->payment_method == 'Transfer Bank')
                                        <div class="col-md text-end">
                                            <figure class="figure">
                                                <a href="{{ Storage::url($order->proof_of_payment) }}" data-fancybox
                                                    target="_blank">
                                                    <img src="{{ Storage::url($order->proof_of_payment) }}"
                                                        class="figure-img img-fluid rounded object-fit-cover
                                                {{ !$order->proof_of_payment ? 'placeholder' : '' }}"
                                                        width="100" alt="...">
                                                </a>
                                                <figcaption class="figure-caption text-center">
                                                    Bukti Pembayaran
                                                </figcaption>
                                            </figure>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive mt-3">
                                    <table class="table table-borderless table-sm">
                                        <thead>
                                            <!-- start row -->
                                            <tr class="border">
                                                <th class="text-center">#</th>
                                                <th>Produk</th>
                                                <th class="text-center">Variant</th>
                                                <th class="text-center">Kuantitas</th>
                                                <th class="text-center">Harga Satuan</th>
                                                <th class="text-end">Total</th>
                                            </tr>
                                            <!-- center row -->
                                        </thead>
                                        <tbody>
                                            @foreach ($orderItems as $no => $item)
                                                <!-- start row -->
                                                <tr class="border">
                                                    <td class="text-center">{{ ++$no }}</td>
                                                    <td>{{ Str::limit($item->product->title, 30, '...') }}</td>
                                                    <td class="text-center">{{ $item->variant->type }}</td>
                                                    <td class="text-center">{{ $item->qty }} Item</td>
                                                    <td class="text-center">
                                                        {{ 'Rp.' . Number::format($item->product->price, locale: 'id') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ 'Rp.' . Number::format($item->product->price * $item->qty, locale: 'id') }}
                                                    </td>
                                                </tr>
                                                <!-- end row -->
                                            @endforeach

                                            <tr class="text-end">
                                                <td colspan="5"> Sub - Total:</td>
                                                <td>
                                                    {{ 'Rp.' .
                                                        Number::format(
                                                            $order->items->sum(function ($item) {
                                                                return $item->qty * $item->product->price;
                                                            }),
                                                            locale: 'id',
                                                        ) }}
                                                </td>
                                            </tr>
                                            <tr class="text-end">
                                                <td colspan="5"> Berat Barang:</td>
                                                <td>
                                                    {{ $order->total_weight }} gram
                                                </td>
                                            </tr>
                                            <tr class="text-end">
                                                <td colspan="5"> Biaya Pengiriman:</td>
                                                <td>
                                                    {{ 'Rp.' . Number::format($order->shipping_cost, locale: 'id') }}
                                                </td>
                                            </tr>
                                            <tr class="text-end">
                                                <td colspan="5"> Biaya Tambahan:</td>
                                                <td>
                                                    {{ $order->protect_cost == true ? 'Rp.' . Number::format(3000, locale: 'id') : 'Rp. 0' }}
                                                </td>
                                            </tr>
                                            <tr class="text-end">
                                                <td colspan="5" class="fw-bolder text-dark fs-6"> Total:</td>
                                                <td class="fw-bolder text-dark fs-6">
                                                    {{ 'Rp.' . Number::format($order->total_amount, locale: 'id') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
    </x-app-layout>
