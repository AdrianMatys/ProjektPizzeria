<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Carbon $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Cart $cart
 */

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole($role): bool
    {
        return $this->role === $role;
    }
    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }
    public function isEmployee(): bool
    {
        return $this->role == 'employee';
    }
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }
    public function forceLogout()
    {
        $this->remember_token = null;
        DB::table('sessions')
            ->where('user_id', $this->id)
            ->delete();
        $this->save();
    }
    public function isLoggedIn(): bool
    {
        if($this->remember_token) return true;

        $session = DB::table('sessions')
            ->where('user_id', $this->id)
            ->first();

        if($session) return true;

        return false;
    }
}
