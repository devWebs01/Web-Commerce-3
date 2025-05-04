<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Province extends Model
{
    use HasFactory;

    protected $table = 'rajaongkir_provinces';

    /**
     * Get all of the addresses for the User
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    /**
     * Get all of the shops for the Province
     */
    public function shop(): hasOne
    {
        return $this->hasOne(Shop::class);
    }
}
