<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Standard, Superior, Deluxe, Suite, etc.
            $table->string('code', 10)->unique();
            $table->text('description')->nullable();
            $table->decimal('price_per_night', 12, 2);
            $table->integer('max_occupancy');
            $table->string('bed_type'); // Single, Double, Twin, King
            $table->json('facilities')->nullable(); // AC, TV, WiFi, etc.
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number', 10)->unique();
            $table->foreignId('room_type_id')->constrained()->onDelete('cascade');
            $table->integer('floor');
            $table->enum('status', ['available', 'occupied', 'cleaning', 'maintenance', 'out_of_order'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('room_types');
    }
};
