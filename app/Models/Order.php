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
        'slug',
        'invoice',
        'status',
        'total_amount',
        'total_weight',
        'tracking_number',
        'shipping_cost',
        'payment_method',
        'note',
        'estimated_delivery_time',
        'courier',
        'proof_of_payment',
        'protect_cost',
        'province_id',
        'city_id',
        'details',
    ];

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

    public static function generateSlug($invoice)
    {
        return str::slug($invoice, '-');
    }

    /**
     * Get all of the Items for the Order
     */
    public function Items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get the user that owns the Order
     */
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
}
