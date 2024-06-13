<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id'); // Menggunakan tipe data string
            $table->foreign('transaction_id')->references('trx_id')->on('transactions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('tour_id')->references('id')->on('tours')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions_details');
    }
};
