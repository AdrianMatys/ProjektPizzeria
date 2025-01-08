<?php

namespace App\Models;

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
    public function category(){

    }
}
