<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property string $name
 */
class EditedPizza extends Model
{
    use HasFactory;
    protected $fillable = ['base_pizza_id'];

    public function name(): Attribute
    {
        return Attribute::get(
            fn(): string => "Edited Pizza (" . $this->basePizza->name . ')',
        );
    }

    public function basePizza()
    {
        return $this->belongsTo(Pizza::class);
    }
    public function editedIingredients()
    {
        return $this->hasMany(EditedPizzaIngredients::class);
    }
    public function ingredients(): Attribute
    {
        return Attribute::get(
            fn(): string => "Edited Pizza (" . $this->basePizza->name . ')',
        );
    }
    public function getingredientsAttribute()
    {
        $ingredients = $this->editedIingredients;
        $finalIngredients = $this->basePizza->ingredients;
        $ingredientIds = $finalIngredients->pluck('id');

        foreach ($ingredients as $ingredient) {
            if ($ingredient->action == 'added') {
                $finalIngredients[] = $ingredient->ingredient;
            } elseif ($ingredient->action == 'removed') {
                $key = $ingredientIds->search($ingredient->ingredient_id);
                if ($key !== false) {
                    $finalIngredients = $finalIngredients->forget($key);
                }
            }
        }

        return $finalIngredients;
    }




//  $addedIngredients= Ingredient::query()->whereIn('id', $newIngredients)->whereNot('id', $existingIngredients)->sum('price');

    public function chuj()
    {

    }




























}
