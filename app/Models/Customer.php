<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'email',
        'phone',
        'document',
        'address',
        'city',
        'state',
        'postal_code',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
