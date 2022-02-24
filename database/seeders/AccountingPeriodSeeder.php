<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountingPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountingperiod = [
            [
                'name' => 'Januari',
                'start' => '01-01-2022',
                'end' => '31-01-2022'
            ],
            [
                'name' => 'Februari',
                'start' => '01-02-2022',
                'end' => '28-01-2022'
            ],
            [
                'name' => 'Maret',
                'start' => '01-03-2022',
                'end' => '31-01-2022'
            ],
            [
                'name' => 'April',
                'start' => '01-04-2022',
                'end' => '31-04-2022'
            ],
            [
                'name' => 'Mei',
                'start' => '01-05-2022',
                'end' => '31-05-2022'
            ],
            [
                'name' => 'Juni',
                'start' => '01-06-2022',
                'end' => '31-06-2022'
            ],
            [
                'name' => 'Juli',
                'start' => '01-07-2022',
                'end' => '31-07-2022'
            ],
            [
                'name' => 'Agustus',
                'start' => '01-08-2022',
                'end' => '31-08-2022'
            ],
            [
                'name' => 'September',
                'start' => '01-09-2022',
                'end' => '31-09-2022'
            ],
            [
                'name' => 'Oktober',
                'start' => '01-10-2022',
                'end' => '31-10-2022'
            ],
            [
                'name' => 'November',
                'start' => '01-11-2022',
                'end' => '31-11-2022'
            ],
            [
                'name' => 'Desember',
                'start' => '01-12-2022',
                'end' => '31-12-2022'
            ],
            
        ];

        DB::table('accounting_periods')->insert($accountingperiod);
    }
}
