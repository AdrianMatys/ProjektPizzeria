<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property Collection<CartItem> $items
 */
class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
