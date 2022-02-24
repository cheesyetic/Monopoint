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
                'end' => '01-31-2022'
            ],
            [
                'name' => 'Februari',
                'start' => '02-01-2022',
                'end' => '01-28-2022'
            ],
            [
                'name' => 'Maret',
                'start' => '03-01-2022',
                'end' => '01-31-2022'
            ],
            [
                'name' => 'April',
                'start' => '04-01-2022',
                'end' => '04-30-2022'
            ],
            [
                'name' => 'Mei',
                'start' => '05-01-2022',
                'end' => '05-31-2022'
            ],
            [
                'name' => 'Juni',
                'start' => '06-01-2022',
                'end' => '06-30-2022'
            ],
            [
                'name' => 'Juli',
                'start' => '07-01-2022',
                'end' => '07-31-2022'
            ],
            [
                'name' => 'Agustus',
                'start' => '08-01-2022',
                'end' => '08-31-2022'
            ],
            [
                'name' => 'September',
                'start' => '09-01-2022',
                'end' => '09-30-2022'
            ],
            [
                'name' => 'Oktober',
                'start' => '10-01-2022',
                'end' => '10-31-2022'
            ],
            [
                'name' => 'November',
                'start' => '11-01-2022',
                'end' => '11-30-2022'
            ],
            [
                'name' => 'Desember',
                'start' => '12-01-2022',
                'end' => '12-31-2022'
            ],

        ];

        DB::table('accounting_periods')->insert($accountingperiod);
    }
}
