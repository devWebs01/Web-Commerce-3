<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi dengan user (customer) dan kasir
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Info umum
            $table->string('invoice')->nullable();
            $table->string('slug')->nullable();
            $table->enum('order_type', ['ECOMMERCE', 'POS'])->default('ECOMMERCE'); // jenis order
            $table->enum('status', [
                'UNPAID',
                'PENDING',
                'PACKED',
                'PROGRESS',
                'SHIPPED',
                'PICKUP',
                'COMPLETED',
                'CANCELLED'
            ])->default('UNPAID');

            // Pembayaran
            $table->string('payment_method')->nullable(); // e.g. QRIS, CASH, TRANSFER
            $table->string('proof_of_payment')->nullable();
            $table->timestamp('paid_at')->nullable();

            // Total
            $table->unsignedBigInteger('total_amount')->nullable();
            $table->unsignedBigInteger('total_weight')->nullable();
            $table->unsignedBigInteger('shipping_cost')->nullable();
            $table->string('protect_cost')->nullable(); // opsional: biaya asuransi tambahan

            // Pengiriman (khusus e-commerce)
            $table->string('tracking_number')->nullable();
            $table->string('estimated_delivery_time')->nullable();
            $table->string('courier')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('rajaongkir_provinces')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('rajaongkir_cities')->onDelete('cascade');
            $table->longText('details')->nullable(); // detail alamat

            // Data pelanggan (khusus POS tanpa akun)
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();

            // Lain-lain
            $table->longText('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
