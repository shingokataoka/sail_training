<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];
        for ($i = 1; $i <= 3; $i++) {
            $users[] = [
                'name' => "user{$i}",
                'email' => "user{$i}@test.com",
                'password' => Hash::make("user{$i}{$i}{$i}{$i}"),
            ];
        }
        DB::table('users')->insert($users);
    }
}
