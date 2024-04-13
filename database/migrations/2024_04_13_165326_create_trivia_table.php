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
        Schema::create('trivia', function (Blueprint $table) {
            $table->id();
            $table->string("question");
            $table->string("answerCorrect");
            $table->string("answerOne");
            $table->string("answerTwo");
            $table->string("answerThree");
            $table->boolean("isPublished");
            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('id')->on('levels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trivia');
    }
};
