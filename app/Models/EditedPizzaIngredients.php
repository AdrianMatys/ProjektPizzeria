<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditedPizzaIngredients extends Model
{
    use HasFactory;
    protected $table = 'edited_pizza_ingredients';
    protected $fillable = ['edited_pizza_id', 'ingredient_id', 'action', 'price'];

    public function editedPizza()
    {
        return $this->belongsTo(EditedPizza::class);
    }
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
    public function name(): Attribute
    {
        return Attribute::get(
            fn(): string => $this->ingredient->name . "( " . $this->action . ' )',
        );
    }
}
