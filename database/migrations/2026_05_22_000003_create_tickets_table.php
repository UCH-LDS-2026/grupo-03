<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('pending')->index();
            $table->string('priority')->default('medium')->index();
            $table->foreignId('area_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('ticket_category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('requester_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
