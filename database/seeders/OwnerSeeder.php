<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\facades\DB;
use Illuminate\Support\facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owners = [];
        for ($i = 1; $i <= 10; $i++) {
            $owners[] = [
                'name' => "owner{$i}",
                'email' => "owner{$i}@test.com",
                'password' => Hash::make("owner{$i}{$i}{$i}{$i}"),
                'created_at' => "2021-02-03 04-05-{$i}",
            ];
        }

        DB::table('owners')->insert($owners);
    }
}
