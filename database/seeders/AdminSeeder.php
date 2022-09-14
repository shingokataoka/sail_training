<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\facades\DB;
use Illuminate\Support\facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'name' => 'admin1',
                'email' => 'admin1@test.com',
                'password' => Hash::make('admin1111'),
            ],
        ]);
    }
}
