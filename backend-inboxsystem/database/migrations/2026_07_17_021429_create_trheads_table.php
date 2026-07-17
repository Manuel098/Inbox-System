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
        Schema::create('trheads', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['New', 'Ready', 'Running', 'Waiting', 'Timed Waiting', 'sleep', 'Terminated'])->default('New');
            $table->dateTime('last_message_at');
            $table->string('subject');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trheads');
    }
};
