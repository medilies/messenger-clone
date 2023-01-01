<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('content');

            $table->foreignId('user_id')->constrained();

            $table->foreignId('conversation_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
