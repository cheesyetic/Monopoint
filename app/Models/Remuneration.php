<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remuneration extends Model
{
    use HasFactory;

    protected $fillable = [
        'kas',
        'pemilik',
        'project_id'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function userRemuneration(){
        return $this->hasMany(UserRemuneration::class);
    }
}
