<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPizzaIngredient extends Model
{
    use HasFactory;
    protected $table = 'custom_pizza_ingredients';
    protected $fillable = ['custom_pizza_id', 'ingredient_id'];

    public function customPizza(){
        return $this->belongsTo(CustomPizza::class);
    }
    public function ingredient(){
        return $this->belongsTo(CustomPizza::class);

    }
}
