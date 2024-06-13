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
        Schema::create('request_trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('total_guest');
            $table->bigInteger('max_price');
            $table->text('trip_plan')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamp('request_date')->nullable();
            $table->foreignId('province_id')->references('id')->on('provinces')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('status_id')->references('id')->on('statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->text('note')->nullable();
            $table->timestamp('approval_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_trips');
    }
};
