<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Routing\RequestContextAwareInterface;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
class PizzaIngredient extends Model
{
    use HasFactory;
    protected $table = 'pizzza_ingredients';
    protected $fillable = ['pizza_id', 'ingredient_id'];

    public function pizza(): BelongsTo
    {
        return $this->belongsTo(Pizza::class);
    }
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }
}
