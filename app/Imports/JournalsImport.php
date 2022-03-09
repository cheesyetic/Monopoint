<?php

namespace App\Imports;

use App\Models\Journal;
use Maatwebsite\Excel\Concerns\ToModel;

class JournalsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Journal([
            'title' => $row[0],
            'date' => $row[1],
            'remark' => $row[2],
            'ref' => $row[3],
            'note_decline' => $row[4],
            'balance' => $row[5],
            'is_reimburse' => $row[6],
            'filebukti' => $row[7],
            'status' => $row[8],
            'buktireimburse' => $row[9],
            'created_at' => $row[10],
            'updated_at' => $row[11],
            'chart_account_id' => $row[12],
            'accounting_period_id' => $row[13],
            'bank_account_id' => $row[14],
            'project_id' => $row[15],
            'user_id' => $row[16]
        ]);
    }
}
