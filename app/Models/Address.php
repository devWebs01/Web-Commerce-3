<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $with = ['province', 'city'];

    protected $fillable = [
        'user_id', 'province_id', 'city_id', 'details',
    ];

    /**
     * Get the user that owns the Address
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the province that owns the Address
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the city that owns the Address
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
