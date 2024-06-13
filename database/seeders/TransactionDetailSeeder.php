<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaction_details')->insert([
            'transaction_id' => 'TRX-14421412-sXadX',
            'tour_id' => '1',
            'quantity' => '1'
        ]);
    }
}
