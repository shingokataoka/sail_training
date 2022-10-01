<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => '店１の商品名',
                'information' => "店１の商品説明。\nあああ",
                'price' => '100',
                'sort_order' => 1,
                'is_selling' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 1,
            ],
            [
                'name' => '店２の商品名',
                'information' => "店２の商品説明。\nあああ",
                'price' => '200',
                'sort_order' => 2,
                'is_selling' => 0,
                'shop_id' => 2,
                'secondary_category_id' => 2,
            ],
            [
                'name' => '店３の商品名',
                'information' => "店３の商品説明。\nあああ",
                'price' => '300',
                'sort_order' => 3,
                'is_selling' => 1,
                'shop_id' => 3,
                'secondary_category_id' => 3,
            ],
        ]);


    }
}
