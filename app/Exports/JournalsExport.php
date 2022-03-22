<?php

namespace App\Exports;

use App\Models\Journal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JournalsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Journal::all();
    }
    public function headings(): array
    {
        return ['id', 'title', 'date', 'remark', 'ref', 'note_decline', 'balance', 'is_reimburse', 'filebukti', 
        'buktireimburse', 'status', 'created_at', 'updated_at', 'chart_account_id', 
        'accounting_period_id', 'bank_account_id', 'project_id', 'user_id'];
    }
}
