<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TourCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tour_categories')->insert([
            'tour_id' => '1',
            'category_id' => '3'
        ]);
        DB::table('tour_categories')->insert([
            'tour_id' => '1',
            'category_id' => '5'
        ]);
        DB::table('tour_categories')->insert([
            'tour_id' => '2',
            'category_id' => '2'
        ]);
        DB::table('tour_categories')->insert([
            'tour_id' => '2',
            'category_id' => '7'
        ]);
        DB::table('tour_categories')->insert([
            'tour_id' => '3',
            'category_id' => '3'
        ]);
        DB::table('tour_categories')->insert([
            'tour_id' => '3',
            'category_id' => '7'
        ]);
        DB::table('tour_categories')->insert([
            'tour_id' => '4',
            'category_id' => '2'
        ]);
        DB::table('tour_categories')->insert([
            'tour_id' => '4',
            'category_id' => '4'
        ]);
        DB::table('tour_categories')->insert([
            'tour_id' => '4',
            'category_id' => '11'
        ]);
        DB::table('tour_categories')->insert([
            'tour_id' => '5',
            'category_id' => '3'
        ]);
        DB::table('tour_categories')->insert([
            'tour_id' => '5',
            'category_id' => '4'
        ]);
    }
}
