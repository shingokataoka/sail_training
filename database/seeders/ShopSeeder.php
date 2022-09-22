<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->insert([
            [
                'owner_id' => 1,
                'name' => 'ここは店名が入ります。',
                'information' => "ここは店舗情報が入ります。\n改行。",
                'filename' => 'shop1.jpg',
                'is_selling' => true,
            ],
            [
                'owner_id' => 1,
                'name' => 'ここは店名が入ります。',
                'information' => "ここは店舗情報が入ります。\n改行。",
                'filename' => 'shop2.jpg',
                'is_selling' => false,
            ],
            [
                'owner_id' => 2,
                'name' => 'ここは店名が入ります。',
                'information' => "ここは店舗情報が入ります。\n改行。",
                'filename' => 'shop1.jpg',
                'is_selling' => true,
            ],
        ]);
    }
}
