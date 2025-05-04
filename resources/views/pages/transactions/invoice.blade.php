<div class="card d-print-block border-0">
    <div class="card-body">
        <div class="invoice" id="printableArea">
            <div class="row pt-3">
                {{-- Header Invoice --}}
                <div class="col-md-12 mb-4">
                    <h4 class="fw-bold">Invoice</h4>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1"><strong>Nomor Faktur:</strong> {{ $order->invoice }}</p>
                            <p class="mb-1"><strong>Nomor Resi:</strong> {{ $order->tracking_number ?? "-" }}</p>
                            <p class="mb-1"><strong>Tanggal Pesanan:</strong>
                                {{ $order->created_at->format("d M Y") }}</p>
                        </div>
                        <div class="text-end">
                            <p class="mb-1"><strong>Kurir:</strong> {{ $order->courier }}</p>
                            <p class="mb-1"><strong>Pembayaran:</strong> {{ $order->payment_method }}</p>
                            <p class="mb-1"><strong>Tambahan:</strong>
                                {{ $order->protect_cost ? "Bubble Wrap" : "-" }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tabel Produk --}}
                <div class="col-md-12">
                    <div class="table-responsive rounded">
                        <table class="table table-striped">
                            <thead class="border">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Produk</th>
                                    <th class="text-center">Varian</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $no => $item)
                                    <tr class="border">
                                        <td class="text-center">{{ ++$no }}</td>
                                        <td>{{ Str::limit($item->product->title, 30, "...") }}</td>
                                        <td class="text-center">{{ $item->variant->type }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-center">
                                            {{ formatRupiah($item->product->price) }}</td>
                                        <td class="text-end">
                                            {{ formatRupiah($item->qty * $item->product->price) }}
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- Ringkasan --}}
                                <tr class="text-end">
                                    <td colspan="5">Sub Total</td>
                                    <td>{{ formatRupiah($order->items->sum(fn($item) => $item->qty * $item->product->price)) }}
                                    </td>
                                </tr>
                                <tr class="text-end">
                                    <td colspan="5">Berat Total</td>
                                    <td>{{ $order->total_weight }} gram</td>
                                </tr>
                                <tr class="text-end">
                                    <td colspan="5">Biaya Pengiriman</td>
                                    <td>{{ formatRupiah($order->shipping_cost) }}</td>
                                </tr>
                                <tr class="text-end">
                                    <td colspan="5">Biaya Tambahan</td>
                                    <td>{{ $order->protect_cost ? "Rp.3.000" : "Rp.0" }}</td>
                                </tr>
                                <tr class="text-end fw-bold fs-6">
                                    <td colspan="5">Total Pembayaran</td>
                                    <td>{{ formatRupiah($order->total_amount) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Informasi Pelanggan --}}
                <div class="col-md-12 mt-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Informasi Pemesan</h6>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <p class="fw-bold mb-0">Nama Lengkap:</p>
                                    <p class="mb-0">{{ $order->user->name }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="fw-bold mb-0">Email:</p>
                                    <p class="mb-0">{{ $order->user->email }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="fw-bold mb-0">Telepon:</p>
                                    <p class="mb-0">{{ $order->user->telp }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="fw-bold mb-0">Alamat Lengkap:</p>
                                <p class="mb-0">{{ $order->user->fulladdress }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bukti Pembayaran --}}
                @if ($order->payment_method == "Transfer Bank" && $order->proof_of_payment)
                    <div class="col-md-12 text-end mt-4">
                        <figure class="figure">
                            <a href="{{ Storage::url($order->proof_of_payment) }}" data-fancybox target="_blank">
                                <img src="{{ Storage::url($order->proof_of_payment) }}"
                                    class="figure-img img-fluid rounded object-fit-cover" width="100"
                                    alt="Bukti Pembayaran">
                            </a>
                            <figcaption class="figure-caption text-center">Bukti Pembayaran</figcaption>
                        </figure>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
