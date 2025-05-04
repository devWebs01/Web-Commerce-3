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

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getFormattedDescriptionAttribute()
    {
        // Periksa apakah description, etd, dan value ada, jika tidak, kembalikan null atau ''
        $description = $this->description ?? '';
        $etd = $this->etd ?? null;
        $value = $this->value ?? null;

        // Jika etd atau value null, kembalikan ''
        if (! $etd || ! $value) {
            return '';
        }

        // Format value menjadi Rupiah
        $formattedValue = 'Rp. '.number_format($value, 0, ',', '.');

        // Gabungkan dan kembalikan string format akhir
        return $description.' '.$etd.' Hari - '.$formattedValue;
    }
}
