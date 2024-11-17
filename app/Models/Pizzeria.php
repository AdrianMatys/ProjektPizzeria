<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizzeria extends Model
{
    protected $table = 'pizzeria_info';
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'city',
        'delivery_available',
        'max_delivery_radius',
        'phone_number'
    ];
}
