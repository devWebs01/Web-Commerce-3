<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $with = 'address';
    protected $fillable = [
        'name',
        'email',
        'password',
        'telp',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relations Models
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(order::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    // Get Attr Model
    public function getDetailsAttribute()
    {
        return $this->name . ' ' . $this->email . ' ' . $this->telp;
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address;

        if ($address && $address->province && $address->city) {
            return $address->province->name . ', ' . $address->city->name . ', ' . ($address->details ?? '');
        }
        return null;
    }
}
