<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRemuneration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'percent',
        'remuneration_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function remuneration(){
        return $this->belongsTo(Remuneration::class);
    }
}
