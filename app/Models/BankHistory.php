<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'balance',
        'bank_account_id'
    ];

    public function bankAccount(){
        return $this->belongsTo(BankAccount::class);
    }
}
