<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('occupation')->nullable();
            $table->string('company')->nullable();
            $table->string('nationality');
            $table->string('id_card_number')->nullable(); // No KTP
            $table->string('passport_number')->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('member_number')->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique(); // Auto-generated
            $table->foreignId('guest_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('receptionist_id')->constrained('users')->onDelete('cascade');
            $table->integer('num_guests');
            $table->integer('num_rooms')->default(1);
            $table->date('check_in_date');
            $table->time('arrival_time');
            $table->date('check_out_date');
            $table->date('departure_date')->nullable();
            $table->string('deposit_box_number')->nullable();
            $table->string('issued_by')->nullable(); // Issued
            $table->decimal('total_price', 12, 2)->default(0);
            $table->enum('status', ['active', 'checked_out', 'cancelled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('guests');
    }
};
