<?php

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use function Livewire\Volt\{state};

state([
    "customers" => fn() => User::whereRole("customer")->count(),
    "ordersCount" => fn() => Order::whereIn("status", ["COMPLETED", "SHIPPED", "PACKED"])->count(),
    "totalAmount" => Order::whereIn("status", ["COMPLETED", "SHIPPED", "PACKED"])->sum("total_amount"),
    "ordersPendingCount" => fn() => Order::whereIn("status", ["PENDING", "SHIPPED"])->get(),
    "ordersCustPickup" => fn() => Order::whereIn("status", ["PENDING", "SHIPPED"])->get(),
]);

?>
<x-admin-layout>
    <x-slot name="title">Beranda</x-slot>
    @include("components.partials.datatables")

    @volt
        <div>
            <div class="container-fluid">
                <div class="card text-bg-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="d-flex flex-column h-100">
                                    <span
                                        class="d-flex align-items-center justify-content-center round-48 bg-white rounded flex-shrink-0 mb-3">
                                        <iconify-icon icon="solar:course-up-outline" class="fs-7 text-dark"></iconify-icon>
                                    </span>
                                    <h2 class="text-white mb-0 text-nowrap text-capitalize">
                                        Selamat datang kembali <br> {{ auth()->user()->name }}
                                    </h2>
                                    <div class="mt-4 mt-sm-auto">
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="opacity-75">Pendapatan</span>
                                                <h1 class="mb-0 text-white mt-1 text-nowrap">
                                                    {{ formatRupiah($totalAmount) }}
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-md-end">
                                <img src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/images/backgrounds/welcome-bg.png"
                                    alt="welcome" class="img-fluid mb-n7 mt-2" width="180">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-success-subtle overflow-hidden shadow-none">
                            <div class="card-body p-4">
                                <span class="text-dark">Pelanggan</span>
                                <div class="hstack gap-6 align-items-end mt-1">
                                    <h5 class="card-title fw-semibold mb-0 fs-7 mt-1">{{ $customers }} Terdaftar
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-warning-subtle overflow-hidden shadow-none">
                            <div class="card-body p-4">
                                <span class="text-dark">Pesanan</span>
                                <div class="hstack gap-6 align-items-end mt-1">
                                    <h5 class="card-title fw-semibold mb-0 fs-7 mt-1">{{ $ordersCount }} Berhasil
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex align-items-center justify-content-between mb-4">
                            <div class="hstack align-items-center gap-3">
                                <span
                                    class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded flex-shrink-0">
                                    <iconify-icon icon="solar:layers-linear" class="fs-7 text-primary"></iconify-icon>
                                </span>
                                <div>
                                    <h5 class="card-title">
                                        Pesanan Baru
                                    </h5>
                                    <p class="card-subtitle mb-0">Ikhtisar pesanan</p>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table display table-sm">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ordersPendingCount as $no => $order)
                                        <tr>
                                            <td>{{ ++$no }}.</td>
                                            <td>{{ __("order_status." . $order->status) }}</td>
                                            <td>
                                                {{ formatRupiah($order->total_amount) }}
                                            </td>
                                            <td>
                                                {{ $order->payment_method }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-admin-layout>
