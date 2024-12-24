<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditedPizza extends Model
{
    use HasFactory;
    protected $fillable = ['base_pizza_id'];

    public function basePizza()
    {
        return $this->belongsTo(Pizza::class);
    }
    public function ingredients(){
        return $this->hasMany(EditedPizzaIngredients::class);
    }

}
