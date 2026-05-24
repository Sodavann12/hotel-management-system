<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('housekeeping_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', [
                'cleaning',
                'turndown',
                'deep_clean',
                'inspection',
            ]);
            $table->enum('status', [
                'pending',
                'in_progress',
                'completed',
                'skipped',
            ])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('scheduled_at');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['room_id', 'status']);
            $table->index(['staff_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('housekeeping_tasks');
    }
};