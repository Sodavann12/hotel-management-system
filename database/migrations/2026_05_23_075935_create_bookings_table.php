<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedTinyInteger('guests')->default(1);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', [
                'pending',
                'confirmed',
                'checked_in',
                'checked_out',
                'cancelled',
                'no_show',
            ])->default('pending');
            $table->string('confirmation_code')->unique();
            $table->text('special_requests')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['check_in', 'check_out']);
            $table->index(['room_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};