<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            ProvinceSeeder::class,
            CategorySeeder::class,
            PlaceSeeder::class,
            TourSeeder::class,
            StatusSeeder::class,
            TourCategorySeeder::class,
            TourPlaceSeeder::class,
            RequestTripSeeder::class,
            RequestPlaceSeeder::class,
            TransactionSeeder::class,
            TransactionDetailSeeder::class,
        ]);
    }
}
