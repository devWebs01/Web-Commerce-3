<?php

use function Laravel\Folio\name;
use function Livewire\Volt\{state};

name("print.invoice");

state([
    // Get Data
    "orderItems" => fn() => $this->order->items,
    "order",
]);

?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Invoice - {{ $order->invoice }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .btn,
            .no-print {
                display: none !important;
            }
        }

        body {
            font-size: 14px;
            background-color: #f8f9fa;
        }

        .invoice-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .total-row {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <main class="container py-4">
      @volt
        <div>
            <div class="d-flex justify-content-between align-items-center mb-4 invoice-header">
                <h3 class="fw-bold mb-0">INVOICE</h3>
                <button onclick="window.print()" class="btn btn-primary no-print">Cetak Invoice</button>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>No. Invoice:</strong> {{ $order->invoice }}</p>
                            <p><strong>No. Resi:</strong> {{ $order->tracking_number ?? "-" }}</p>
                            <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format("d M Y") }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p><strong>Kurir:</strong> {{ $order->courier }}</p>
                            <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method }}</p>
                            <p><strong>Tambahan:</strong> {{ $order->protect_cost ? "Bubble Wrap" : "-" }}</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Produk</th>
                                    <th class="text-center">Varian</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ ++$no }}</td>
                                        <td>{{ Str::limit($item->product->title, 30, "...") }}</td>
                                        <td class="text-center">{{ $item->variant->type }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-center">{{ formatRupiah($item->product->price) }}</td>
                                        <td class="text-end">
                                            {{ formatRupiah($item->qty * $item->product->price) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-end total-row">
                                    <th colspan="5">Sub Total</th>
                                    <td>{{ formatRupiah($order->items->sum(fn($item) => $item->qty * $item->product->price)) }}</td>
                                </tr>
                                <tr class="text-end">
                                    <th colspan="5">Berat Total</th>
                                    <td>{{ $order->total_weight }} gram</td>
                                </tr>
                                <tr class="text-end">
                                    <th colspan="5">Ongkir</th>
                                    <td>{{ formatRupiah($order->shipping_cost) }}</td>
                                </tr>
                                <tr class="text-end">
                                    <th colspan="5">Biaya Tambahan</th>
                                    <td>{{ $order->protect_cost ? "Rp 3.000" : "Rp 0" }}</td>
                                </tr>
                                <tr class="text-end total-row">
                                    <th colspan="5">Total Pembayaran</th>
                                    <td>{{ formatRupiah($order->total_amount) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if ($order->payment_method === "Transfer Bank" && $order->proof_of_payment)
                        <div class="text-center mt-4">
                            <img src="{{ Storage::url($order->proof_of_payment) }}"
                                 class="img-thumbnail object-fit-cover" style="max-width: 300px;"
                                 alt="Bukti Pembayaran">
                            <p class="text-muted mt-2">Bukti Pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
      @endvolt
    </main>

    <script>
        window.onload = () => window.print();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
