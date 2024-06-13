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
        Schema::create('request_places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->references('id')->on('request_trips')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('place_id')->references('id')->on('places')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_places');
    }
};
