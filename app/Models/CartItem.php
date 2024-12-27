<?php

namespace App\Models;
use App\Models\Pizza;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = ['cart_id', 'item_id', 'item_type', 'quantity'];

    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function item(){
        return $this->morphTo();
    }
}
