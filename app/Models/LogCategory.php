<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function logType(){
        return $this->hasMany(LogType::class);
    }
    public function getIdByName(string $name){
        return self::query()->where('name', $name)->first();
    }
}
