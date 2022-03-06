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
        'journal_id',
        'chart_account_id',
        'accounting_period_id',
        'bank_account_id',
        'project_id',
        'user_id'
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function chartAccount(){
        return $this->belongsTo(ChartAccount::class);
    }
    public function accountingPeriod(){
        return $this->belongsTo(AccountingPeriod::class);
    }
    public function bankAccount(){
        return $this->belongsTo(BankAccount::class);
    }
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function asset(){
        return $this->belongsTo(Asset::class);
    }
    public function journal(){
        return $this->belongsTo(Journal::class);
    }

}
