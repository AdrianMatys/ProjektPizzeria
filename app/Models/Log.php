<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'log_type_id',
      'details'
    ];
    protected $casts = [
        'details' => 'array'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function type(){
        return $this->belongsTo(LogType::class, 'log_type_id');
    }

    public function stringDetails(): Attribute
    {
        return Attribute::get(
            fn (): string => $this->flattenDetails($this->details)
        );
    }
    private function flattenDetails(array $details, string $prefix = ''): string
    {
        $result = [];

        foreach ($details as $key => $value) {
            $currentKey = $prefix ? "{$prefix} {$key}" : $key;

            if (is_array($value) || is_object($value)) {
                $result[] = $this->flattenDetails((array) $value, $currentKey);
            } else {
                $result[] = "{$currentKey}: {$value}";
            }
        }

        return implode("<br>", $result);
    }
}
