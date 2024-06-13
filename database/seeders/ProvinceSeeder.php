<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provinces')->insert([
            'province_name' => 'Jakarta',
            'place_image' => 'jakarta.jpg'
        ]);
        DB::table('provinces')->insert([
            'province_name' => 'Bali',
            'place_image' => 'bali.jpg'
        ]);
        DB::table('provinces')->insert([
            'province_name' => 'Yogyakarta',
            'place_image' => 'jogja.jpg'
        ]);
        DB::table('provinces')->insert([
            'province_name' => 'Nusa Tenggara Timur',
            'place_image' => 'ntt.webp'
        ]);
        DB::table('provinces')->insert([
            'province_name' => 'Papua Barat',
            'place_image' => 'papuabarat.jpg'
        ]);
    }
}
