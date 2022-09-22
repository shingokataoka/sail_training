<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inserts = [];
        for ($i = 1; $i <= 7; $i++) {
            $inserts[] = [
                'owner_id' => ($i === 7)? 2 : 1,
                'title' => ($i % 2 === 0)? "画像タイトル{$i}" : null,
                'filename' => "product{$i}.jpg",
            ];
        }
        DB::table('images')->insert($inserts);
    }
}
