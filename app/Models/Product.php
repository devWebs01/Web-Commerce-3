<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'capital',
        'price',
        'image',
        'weight',
        'description',
    ];

    /**
     * Get the category that owns the Product
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all of the carts for the User
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get all of the orders for the Order
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all of the Items for the Order
     */
    public function Items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get all of the variants for the Product
     */
    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }
}
