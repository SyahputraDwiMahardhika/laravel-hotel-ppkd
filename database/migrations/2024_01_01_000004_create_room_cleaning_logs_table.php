<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_cleaning_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Staff who cleaned
            $table->enum('action', ['start_cleaning', 'finish_cleaning', 'ready_for_checkin', 'maintenance_start', 'maintenance_done']);
            $table->text('notes')->nullable();
            $table->timestamp('action_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_cleaning_logs');
    }
};
