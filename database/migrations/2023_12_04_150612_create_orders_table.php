<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *  'user_id', 'status', 'invoice', 'total', 'resi', 'ongkir', 'payment'
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('invoice')->nullable();
            $table->enum('status', ['PACKED', 'UNPAID', 'PROGRESS', 'COMPLETED', 'SHIPPED', 'PENDING', 'CANCELLED']);
            $table->unsignedBigInteger('total_amount')->nullable();
            $table->unsignedBigInteger('total_weight')->nullable();
            $table->longText('note')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('protect_cost')->nullable();

            // Pengiriman
            $table->string('tracking_number')->nullable();
            $table->unsignedBigInteger('shipping_cost')->nullable();
            $table->string('estimated_delivery_time')->nullable();
            $table->string('courier')->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->string('alternative_phone')->nullable();
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
