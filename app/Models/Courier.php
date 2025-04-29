<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Courier extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'value', 'etd', 'order_id',
    ];

    /**
     * Get the order that owns the Courier
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
