<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustingHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'remark',
        'ref',
        'uang_masuk',
        'uang_keluar',
        'is_reimburse',
        'chart_account_id',
        'accounting_period_id',
        'bank_account_id',
        'project_id',
        'user_id'
    ];
    
}
