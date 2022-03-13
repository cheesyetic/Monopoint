<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'remark',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function user_appointment(){
        return $this->hasMany(UserAppointment::class);
    }
}
