<?php

use function Livewire\Volt\{state, rules, on, uses};
use App\Models\{Cart, User, Order, Item};
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

state([
    "carts" => fn() => Cart::where("user_id", $this->user_id ?? null)->get(),
    "user" => fn() => User::whereEmail("offline@testing.com")->first(),
    "user_id" => fn() => $this->user_id,
    "customer_name",
    "customer_phone",
    "note",
]);

rules([
    "customer_name" => "required|string",
    "customer_phone" => "required|numeric",
    "note" => "nullable|string",
]);

$calculateTotal = function () {
    $total = 0;
    foreach ($this->carts as $cart) {
        $total += $cart->product->price * $cart->qty;
    }
    return $total;
};

// Increase quantity or do nothing if stock reached
$increaseQty = function ($cartId) {
    $cart = Cart::find($cartId);
    if (!$cart) {
        return;
    }

    $stock = $cart->variant->stock;
    if ($cart->qty < $stock) {
        $cart->update(["qty" => $cart->qty + 1]);
        $this->dispatch("cart-updated");
    }
};

// Decrease quantity; if reaches zero, delete the cart item
$decreaseQty = function ($cartId) {
    $cart = Cart::find($cartId);
    if (!$cart) {
        return;
    }

    if ($cart->qty > 1) {
        $cart->update(["qty" => $cart->qty - 1]);
    } else {
        $cart->delete();
    }
    $this->dispatch("cart-updated");
};

on([
    "cart-updated" => function () {
        $this->carts = Cart::where("user_id", $this->user_id ?? null)->get();
    },
]);

$confirmCheckout = function () {
    $this->validate();

    $cartItems = Cart::where("user_id", $this->user_id)->get();

    if ($cartItems->isEmpty()) {
        $this->alert("warning", "Keranjang masih kosong!");
        return;
    }

    // Hitung total harga dan berat
    $totalPrice = 0;
    $totalWeight = 0;

    foreach ($cartItems as $cartItem) {
        $totalPrice += $cartItem->product->price * $cartItem->qty;
        $totalWeight += $cartItem->product->weight * $cartItem->qty;
    }

    // Buat pesanan baru
    $order = Order::create([
        "user_id" => $this->user_id,
        "invoice" => "INV-" . time(),
        "slug" => Str::slug("INV-" . time()),
        "status" => "COMPLETED",
        "order_type" => "POS",
        "payment_method" => $this->payment_method ?? "CASH",
        "proof_of_payment" => $this->proof_of_payment ?? null,
        "paid_at" => now(),
        "total_amount" => $totalPrice,
        "total_weight" => $totalWeight,
        "shipping_cost" => 0,
        "protect_cost" => 0,
        "courier" => null,
        "province_id" => null,
        "city_id" => null,
        "details" => "Transaksi Offline",
        "customer_name" => $this->customer_name ?? "Umum",
        "customer_phone" => $this->customer_phone ?? null,
        "note" => $this->note ?? null,
    ]);

    foreach ($cartItems as $cartItem) {
        $order->items()->create([
            "product_id" => $cartItem->product_id,
            "variant_id" => $cartItem->variant_id,
            "qty" => $cartItem->qty,
        ]);

        $cartItem->variant->decrement("stock", $cartItem->qty);
    }

    try {
        $this->dispatch("cart-updated");

        $this->alert("success", "Pesanan berhasil diproses.", [
            "position" => "top",
            "timer" => "2000",
            "toast" => true,
        ]);

        $this->redirectRoute("transactions.show", ["order" => $order]);

        Cart::where("user_id", $this->user_id)->delete();
    } catch (\Throwable $th) {
        $order->delete();

        $this->alert("error", "Checkout gagal. Silakan coba lagi!", [
            "position" => "top",
            "timer" => "2000",
            "toast" => true,
            "timerProgressBar" => true,
        ]);
    }
};

$resetCart = function () {
    Cart::where("user_id", $this->user_id)->delete();
    $this->dispatch("cart-updated");
};

?>

<!-- Current Order Sidebar -->
<div class="col-lg-4">
    @volt
        <div>
            <div class="p-3 bg-white rounded-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Pesanan saat ini</h5>
                </div>

                <!-- Order Items -->
                <ul class="list-unstyled mb-4">
                    @foreach ($carts as $item)
                        <li class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark">{{ Str::limit($item->product->title, 20) }}</div>
                                <small class="text-muted">{{ $item->variant->type }}</small> <br>
                                <small class="text-muted">{{ formatRupiah($item->product->price) }}</small>
                            </div>
                            <div class="d-flex align-items-center ms-3">
                                <button class="btn btn-dark btn-sm" wire:click="decreaseQty('{{ $item->id }}')"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-minus fa-sm"></i>
                                </button>
                                <span class="px-2">{{ $item->qty }}</span>
                                <button class="btn btn-dark btn-sm" wire:click="increaseQty('{{ $item->id }}')"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-plus fa-sm"></i>
                                </button>
                            </div>
                        </li>
                    @endforeach
                    @if ($this->carts->isEmpty())
                        <li class="text-center text-muted py-4">Keranjang kosong</li>
                    @endif
                </ul>

                <!-- Summary Box -->
                <div class="p-3 bg-light rounded mb-3">
                    <div class="form-floating mb-3">
                        <input wire:model="customer_name" type="text"
                            class="form-control 
                            @error("customer_name")
                            is-invalid
                        @enderror"
                            id="nameInput" placeholder="...">
                        <label for="nameInput">Nama Pelanggan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input wire:model="customer_phone" type="number"
                            class="form-control 
                            @error("customer_phone")
                            is-invalid
                        @enderror"
                            id="telpInput" placeholder="...">
                        <label for="telpInput">No. Telp</label>
                    </div>
                    <div class="form-floating">
                        <textarea wire:model="note"
                            class="form-control 
                            @error("note")
                            is-invalid
                        @enderror"
                            placeholder="..." id="noteTextarea" style="height: 100px"></textarea>
                        <label for="noteTextarea">Catatan</label>
                    </div>

                    <hr class="my-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold text-dark">Total</span>
                        <span class="fw-bold text-dark">{{ formatRupiah($this->calculateTotal()) }}</span>
                    </div>
                </div>

                <form wire:submit="confirmCheckout" class="mb-3">
                    <button wire:click="confirmCheckout" wire:confirm="Yakin pesanan sudah sesuai?"
                        wire:loading.attr="disabled" wire:target="confirmCheckout" type="button"
                        class="btn btn-warning w-100">
                        <span wire:loading.delay wire:target="confirmCheckout"
                            class="loading loading-spinner loading-xs me-1"></span>
                        Ya, Konfirmasi Pesanan
                    </button>

                </form>

                <button type="button" wire:click="resetCart" class="btn btn-danger w-100 mb-3">Reset</button>
            </div>
        </div>
    @endvolt
</div>
