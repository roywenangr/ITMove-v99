<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transactions')->insert([
            'trx_id' => 'TRX-14421412-sXadX',
            'user_id' => '2',
            'transaction_time' => now(),
            'total_price' => '850000',
            'status' => 'Paid'
        ]);
    }
}
