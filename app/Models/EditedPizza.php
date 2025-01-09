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
    public function ingredients(){
        return $this->hasMany(EditedPizzaIngredients::class);
    }

}
