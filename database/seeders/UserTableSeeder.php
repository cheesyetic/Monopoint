<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Admin Monopoint',
            'email'     => 'admin@mail.com',
            'phone_number'     => '08123456789',
            'type'     => '0',
            'password'  => bcrypt('password')
        ]);
    }
}
