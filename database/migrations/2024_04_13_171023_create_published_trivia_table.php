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
        Schema::create('published_trivia', function (Blueprint $table) {
            $table->id();
            $table->string("state");
            $table->integer("pointsEarned");
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('trivia_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('trivia_id')->references('id')->on('trivia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('published_trivia');
    }
};
