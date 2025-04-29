<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',

        // Tambahan:
        'custom_title', // nama produk custom oleh customer
        'note', // bisa JSON untuk info tambahan umum
        'design_file', // file upload dari customer
        'final_design', // file hasil akhir (oleh admin)
        'base_price', // harga dasar
        'final_price', // total item ini

    ];

    /**
     * Get the order that owns the Item
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the Item
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
