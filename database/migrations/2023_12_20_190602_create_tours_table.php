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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->text('tour_title');
            $table->foreignId('province_id')->references('id')->on('provinces')->onDelete('cascade')->onUpdate('cascade');
            $table->text('description');
            $table->integer('max_slot');
            $table->date('start_date');
            $table->date('end_date');
            $table->bigInteger('price');
            $table->text('highlights');
            $table->text('include');
            $table->text('not_include')->nullable();
            $table->text('itinerary');
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
