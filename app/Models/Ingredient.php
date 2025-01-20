<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Ingredient extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'quantity', 'unit', 'price'];
    public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Translation::class);
    }
    public function pizzas(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Pizza::class, 'pizza_ingredients', 'ingredient_id', 'pizza_id')
            ->withPivot('quantity');
    }

    public function translatedName(): Attribute
    {
        $locale = App::getLocale();
        $name = $this->name;
        $translation = $this->translations()->where('language_code', $locale)
            ->first();
        if($translation){
            $name = $translation->name;
        }
        return Attribute::get(
            fn(): string => $name,
        );
    }
}
