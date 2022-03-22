<?php

namespace App\Imports;

use App\Models\Journal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JournalsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Journal([
            'title' => $row['title'],
            'date' => $row['date'],
            'remark' => $row['remark'],
            'ref' => $row['ref'],
            'note_decline' => $row['note_decline'],
            'balance' => $row['balance'],
            'is_reimburse' => $row['is_reimburse'],
            'filebukti' => $row['filebukti'],
            'status' => $row['status'],
            'buktireimburse' => $row['buktireimburse'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'chart_account_id' => $row['chart_account_id'],
            'accounting_period_id' => $row['accounting_period_id'],
            'bank_account_id' => $row['bank_account_id'],
            'project_id' => $row['project_id'],
            'user_id' => $row['user_id']
        ]);
    }
}
