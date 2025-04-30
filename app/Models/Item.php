<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'variant_id', 'qty'
    ];

    /**
     * Get the order that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant that owns the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }
}
