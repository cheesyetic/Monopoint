<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = "Admin Monopoint";
        $user->email = "admin@mail.com";
        $user->phone_number = "81234567";
        $user->password = bcrypt('password');
        $user->type = 0;
        $user->save();
    }
}
