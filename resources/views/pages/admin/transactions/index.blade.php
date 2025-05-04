<?php

use function Livewire\Volt\{state, computed};
use App\Models\Order;
use function Laravel\Folio\name;

name("transactions.index");

state([
    "countOrders" => fn() => [
        "PACKED" => Order::where("status", "PACKED")->count(),
        "UNPAID" => Order::where("status", "UNPAID")->count(),
        "PROGRESS" => Order::where("status", "PROGRESS")->count(),
        "COMPLETED" => Order::where("status", "COMPLETED")->count(),
        "SHIPPED" => Order::where("status", "SHIPPED")->count(),
        "PENDING" => Order::where("status", "PENDING")->count(),
        "CANCELLED" => Order::where("status", "CANCELLED")->count(),
    ],
]);

$orders = computed(function () {
    return Order::query()->latest()->get();
});

?>

<x-admin-layout>
    <x-slot name="title">Transaksi</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("transactions.index") }}">Transaksi</a></li>
    </x-slot>

    @include("components.partials.datatables")

    @volt
        <div>
            <div class="card">
                <div class="card-body mb-3">
                    <div class="w-full md:w-1/2 mx-auto mb-6">
                        <canvas id="orderStatusChart" height="150"></canvas>
                    </div>

                </div>
            </div>

            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-center text-nowrap" style="width: 100%;">
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
                                @foreach ($this->orders as $no => $order)
                                    <tr>
                                        <th>{{ ++$no }}</th>
                                        <th>{{ $order->invoice }}</th>
                                        <th>
                                            <span class="badge bg-primary uppercase">
                                                {{ __("order_status." . $order->status) }}
                                            </span>
                                        </th>
                                        <th>
                                            {{ formatRupiah($order->total_amount) }}
                                        </th>
                                        <th>
                                            <a href="/admin/transactions/{{ $order->id }}"
                                                class="btn btn-primary btn-sm">
                                                Detail Order
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const ctx = document.getElementById("orderStatusChart").getContext("2d");

                    const chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @json(array_map(fn($status) => __("order_status." . $status), array_keys($countOrders))),
                            datasets: [{
                                label: 'Jumlah Order per Status',
                                data: @json(array_values($countOrders)),
                                backgroundColor: [
                                    '#f87171', '#fbbf24', '#60a5fa', '#34d399', '#818cf8', '#e879f9',
                                    '#a3a3a3'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    precision: 0
                                }
                            }
                        }
                    });
                });
            </script>

        </div>
    @endvolt
</x-admin-layout>
