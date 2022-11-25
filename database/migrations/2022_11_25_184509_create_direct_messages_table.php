<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('direct_messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('content');
            $table->unsignedBigInteger('target_user_id');

            $table->foreignId('user_id')->constrained();

            $table->foreign('target_user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('direct_messages');
    }
};
