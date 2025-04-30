<?php

use function Livewire\Volt\{state, usesPagination, with};
use App\Models\Order;

usesPagination(theme: "bootstrap");

state(["count" => 0]);

$increment = fn() => $this->count++;

with(
    fn() => [
        "process_orders" => fn() => Order::where("user_id", auth()->id())
            ->where("status", "UNPAID")
            ->orWhere("status", "PROGRESS")
            ->orWhere("status", "PICKUP")
            ->orWhere("status", "PENDING")
            ->latest()
            ->paginate(5),

        "shipped_orders" => fn() => Order::where("user_id", auth()->id())
            ->where("status", "SHIPPED")
            ->orWhere("status", "PACKED")
            ->latest()
            ->paginate(5),

        "completed_orders" => fn() => Order::where("user_id", auth()->id())
            ->where("status", "COMPLETED")
            ->latest()
            ->paginate(5),

        "cancelled_orders" => fn() => Order::where("user_id", auth()->id())
            ->where("status", "CANCELLED")
            ->latest()
            ->paginate(5),
    ],
);

?>
<x-guest-layout>
    <x-slot name="title">Daftar Pesanan</x-slot>
    @volt
        <div>
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <h2 id="font-custom" class="display-4 fw-bold">
                            Daftar Pesanan
                        </h2>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 align-content-center">
                        <p>
                            Di sini kamu dapat melihat daftar pesanan, status pengiriman, dan rincian transaksi kamu. Ini
                            akan memudahkan kamu melacak pembelian kamu sebelumnya.
                        </p>
                    </div>
                </div>

                <div class="card rounded-top-5 px-3 mb-3">
                    <ul class="nav nav-pills m-3 align-self-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active position-relative" id="pills-process_orders-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-process_orders" type="button" role="tab"
                                aria-controls="pills-process_orders" aria-selected="true">Masih Proses

                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ count($process_orders) }}
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative" id="pills-shipped_orders-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-shipped_orders" type="button" role="tab"
                                aria-controls="pills-shipped_orders" aria-selected="false">
                                Dalam Pengiriman
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ count($shipped_orders) }}
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative" id="pills-completed_orders-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-completed_orders" type="button" role="tab"
                                aria-controls="pills-completed_orders" aria-selected="false">
                                Pesanan Selesai
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ count($completed_orders) }}
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative" id="pills-cancelled_orders-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-cancelled_orders" type="button" role="tab"
                                aria-controls="pills-cancelled_orders" aria-selected="false">
                                Pembatalan
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ count($cancelled_orders) }}
                                </span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-process_orders" role="tabpanel"
                        aria-labelledby="pills-process_orders-tab" tabindex="0">
                        <div class="card rounded-bottom-5">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Invoice</th>
                                                <th>Status</th>
                                                <th>Total Pesanan</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($process_orders as $no => $item)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $item->invoice }}</td>
                                                    <td>
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #635bff">
                                                            {{ $item->status }}
                                                        </span>
                                                    </td>
                                                    <td>{{ "Rp. " . Number::format($item->total_amount, locale: "id") }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-dark">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $process_orders->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-shipped_orders" role="tabpanel"
                        aria-labelledby="pills-shipped_orders-tab" tabindex="0">
                        <div class="card rounded-5">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Invoice</th>
                                                <th>Resi</th>
                                                <th>Status</th>
                                                <th>Total Pesanan</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shipped_orders as $no => $item)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $item->invoice }}</td>
                                                    <td>{{ $item->tracking_number }}</td>
                                                    <td>
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #635bff">
                                                            {{ $item->status }}
                                                        </span>
                                                    </td>
                                                    <td>{{ "Rp. " . Number::format($item->total_amount, locale: "id") }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-dark">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        {{ $process_orders->links() }}
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-completed_orders" role="tabpanel"
                        aria-labelledby="pills-completed_orders-tab" tabindex="0">
                        <div class="card rounded-5">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Invoice</th>
                                                <th>Status</th>
                                                <th>Total Pesanan</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($completed_orders as $no => $item)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $item->invoice }}</td>
                                                    <td>
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #635bff">
                                                            {{ $item->status }}
                                                        </span>
                                                    </td>
                                                    <td>{{ "Rp. " . Number::format($item->total_amount, locale: "id") }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-dark">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        {{ $process_orders->links() }}
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-cancelled_orders" role="tabpanel"
                        aria-labelledby="pills-cancelled_orders-tab" tabindex="0">
                        <div class="card rounded-5">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Invoice</th>
                                                <th>Status</th>
                                                <th>Total Pesanan</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cancelled_orders as $no => $item)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $item->invoice }}</td>
                                                    <td>
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #635bff">
                                                            {{ $item->status }}
                                                        </span>
                                                    </td>
                                                    <td>{{ "Rp. " . Number::format($item->total_amount, locale: "id") }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-dark">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        {{ $process_orders->links() }}
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-guest-layout>
