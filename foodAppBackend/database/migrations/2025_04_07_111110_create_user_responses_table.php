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
        if (!Schema::hasTable('user_responses')) {
            Schema::create('user_responses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                $table->string('session_id')->nullable()->comment('For non-authenticated users');
                $table->foreignId('question_id')->constrained()->onDelete('cascade');
                $table->foreignId('answer_id')->constrained()->onDelete('cascade');
                $table->timestamps();

                // Ensure we don't have duplicate responses for the same question from the same user/session
                $table->unique(['user_id', 'question_id']);
                $table->unique(['session_id', 'question_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_responses');
    }
};
