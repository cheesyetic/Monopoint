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
            'uang_masuk' => $row[4],
            'uang_keluar' => $row[5],
            'is_reimburse' => $row[6],
            'category' => $row[7],
            'filebukti' => $row[8],
            'buktireimburse' => $row[9],
            'status' => $row[10],
            'created_at' => $row[11],
            'updated_at' => $row[12],
            'chart_account_id' => $row[13],
            'accounting_period_id' => $row[14],
            'bank_account_id' => $row[15],
            'project_id' => $row[16],
            'user_id' => $row[17]
        ]);
    }
}
