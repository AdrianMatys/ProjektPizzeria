<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogType extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(LogCategory::class);
    }
    public function logs(){
        return $this->hasMany(Log::class);
    }
}
