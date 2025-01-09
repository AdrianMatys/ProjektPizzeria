<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 */

class CustomPizza extends Model
{
    use HasFactory;
    protected $fillable = ['pizza_id'];

    public function name(): Attribute
    {
        return Attribute::get(
            fn(): string => "Custom Pizza",
        );
    }
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'custom_pizza_ingredients');
    }

    public function calculatePrice(){
        $price = 0;
        foreach ($this->ingredients as $ingredient){
            if($ingredient->pivot->action == 'added'){
                $price += $ingredient->price;
            } else{
                $price -= $ingredient->price;
            }
        }
    }
}
