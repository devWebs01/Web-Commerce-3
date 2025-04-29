<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice',
        'status',
        'total_amount',
        'total_weight',
        'payment_method',
        'note',

        'tracking_number',
        'shipping_cost',
        'estimated_delivery_time',
        'courier',
        'proof_of_payment',
        'protect_cost',
        'alternative_phone',
    ];

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
