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
                'start' => '2022-01-01',
                'end' => '2022-01-31'
            ],
            [
                'name' => 'Februari',
                'start' => '2022-02-01',
                'end' => '2022-02-28'
            ],
            [
                'name' => 'Maret',
                'start' => '2022-03-01',
                'end' => '2022-03-31'
            ],
            [
                'name' => 'April',
                'start' => '2022-04-01',
                'end' => '2022-04-30'
            ],
            [
                'name' => 'Mei',
                'start' => '2022-05-01',
                'end' => '2022-05-31'
            ],
            [
                'name' => 'Juni',
                'start' => '2022-06-01',
                'end' => '2022-06-30'
            ],
            [
                'name' => 'Juli',
                'start' => '2022-07-01',
                'end' => '2022-07-31'
            ],
            [
                'name' => 'Agustus',
                'start' => '2022-08-01',
                'end' => '2022-08-31'
            ],
            [
                'name' => 'September',
                'start' => '2022-09-01',
                'end' => '2022-09-30'
            ],
            [
                'name' => 'Oktober',
                'start' => '2022-10-01',
                'end' => '2022-10-31'
            ],
            [
                'name' => 'November',
                'start' => '2022-11-01',
                'end' => '2022-11-30'
            ],
            [
                'name' => 'Desember',
                'start' => '2022-12-01',
                'end' => '2022-12-31'
            ],

        ];

        DB::table('accounting_periods')->insert($accountingperiod);
    }
}
