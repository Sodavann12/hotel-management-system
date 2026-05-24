<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->constrained()->cascadeOnDelete();
            $table->string('number')->unique();
            $table->unsignedTinyInteger('floor');
            $table->enum('status', [
                'available',
                'reserved',
                'occupied',
                'dirty',
                'maintenance',
                'out_of_order',
            ])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('floor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};