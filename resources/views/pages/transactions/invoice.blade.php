<div class="card d-print-block border-0">
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
