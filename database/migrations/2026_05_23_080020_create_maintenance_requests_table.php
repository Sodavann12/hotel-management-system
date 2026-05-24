<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reported_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'urgent',
            ])->default('medium');
            $table->enum('status', [
                'open',
                'in_progress',
                'resolved',
                'closed',
            ])->default('open');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['room_id', 'status']);
            $table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};