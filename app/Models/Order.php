<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'invoice',
        'slug',
        'status',
        'order_type', // tambahan

        'payment_method',
        'proof_of_payment',
        'paid_at', // tambahan

        'total_amount',
        'total_weight',
        'shipping_cost',
        'protect_cost',

        'tracking_number',
        'estimated_delivery_time',
        'courier',
        'province_id',
        'city_id',
        'details',

        'customer_name', // tambahan
        'customer_phone', // tambahan
        'note',
    ];

    protected $dates = ['paid_at'];

    // Auto generate slug saat create/update
    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->slug = static::generateSlug($order->invoice);
        });

        static::updating(function ($order) {
            $order->slug = static::generateSlug($order->invoice);
        });
    }

    public static function generateSlug($invoice): string
    {
        return Str::slug($invoice, '-');
    }

    // Relasi ke user (pelanggan)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the couriers for the Order
     */
    public function couriers(): HasMany
    {
        return $this->hasMany(Courier::class);
    }

    // Relasi ke item pesanan
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    // Relasi ke provinsi
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    // Relasi ke kota
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
