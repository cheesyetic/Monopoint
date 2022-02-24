<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chartaccount =[
            [
                'name' => 'Pemasukan DP Project',
                'code' => '1',
                'type' => '1'
            ],
            [
                'name' => 'Pemasukan Pelunasan Project',
                'code' => '2',
                'type' => '1'
            ],
            [
                'name' => 'Pemasukan Hosting Domain',
                'code' => '3',
                'type' => '1'
            ],
            [
                'name' => 'Bunga Rekening',
                'code' => '4',
                'type' => '1'
            ],
            [
                'name' => 'Pemasukan Lain-Lain',
                'code' => '5',
                'type' => '1'
            ],
            [
                'name' => 'Pemasukan Modal',
                'code' => '6',
                'type' => '1'
            ],
            [
                'name' => 'Perpindahan Antar Rekening (Masuk)',
                'code' => '7',
                'type' => '1'
            ],
            [
                'name' => 'Pengeluaran Hosting Domain',
                'code' => '8',
                'type' => '2'
            ],
            [
                'name' => 'Pengeluaran Transport',
                'code' => '9',
                'type' => '2'
            ],
            [
                'name' => 'Pengeluaran Wifi',
                'code' => '10',
                'type' => '2'
            ],
            [
                'name' => 'Pengeluaran Sewa Kantor',
                'code' => '11',
                'type' => '2'
            ],
            [
                'name' => 'Pengeluaran Fee Karyawan',
                'code' => '12',
                'type' => '2'
            ],
            [
                'name' => 'Pengeluaran Listrik',
                'code' => '13',
                'type' => '2'
            ],
            [
                'name' => 'Pembagian Fee Internal',
                'code' => '14',
                'type' => '2'
            ],
            [
                'name' => 'Pengeluaran Peralatan Kantor',
                'code' => '15',
                'type' => '2'
            ],
            [
                'name' => 'Biaya Admin',
                'code' => '16',
                'type' => '2'
            ],
            [
                'name' => 'Prive Hamdi',
                'code' => '17',
                'type' => '2'
            ],
            [
                'name' => 'Prive Saleh',
                'code' => '18',
                'type' => '2'
            ],
            [
                'name' => 'Pengeluaran Lain-Lain',
                'code' => '19',
                'type' => '2'
            ],
            [
                'name' => 'Perpindahan Antar Rekening (Keluar)',
                'code' => '20',
                'type' => '2'
            ]
        ];
        DB::table('chart_accounts')->insert($chartaccount);
    }
}
