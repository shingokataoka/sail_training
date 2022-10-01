<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('primary_categories')->insert([
            [
                'name' => '3スノーボード',
                'sort_order' => 3,
            ],
            [
                'name' => '2キャンプ',
                'sort_order' => 2,
            ],
            [
                'name' => '1自転車',
                'sort_order' => 1,
            ],
        ]);
        DB::table('secondary_categories')->insert([
            [
                'primary_category_id' => 1,
                'name' => '6サロモン',
                'sort_order' => 6,
            ],
            [
                'primary_category_id' => 1,
                'name' => '5バートン',
                'sort_order' => 5,
            ],
            [
                'primary_category_id' => 2,
                'name' => '4コールマン',
                'sort_order' => 4,
            ],
            [
                'primary_category_id' => 2,
                'name' => '3スノーピーク',
                'sort_order' => 3,
            ],
            [
                'primary_category_id' => 3,
                'name' => '2クロスバイク',
                'sort_order' => 2,
            ],
            [
                'primary_category_id' => 3,
                'name' => '1ロードバイク',
                'sort_order' => 1,
            ],
        ]);
    }
}
