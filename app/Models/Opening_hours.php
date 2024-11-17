<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opening_hours extends Model
{
    use HasFactory;
    protected $fillable = [
        'day',
        'open_time',
        'close_time',
        'phone_number'
    ];
}
