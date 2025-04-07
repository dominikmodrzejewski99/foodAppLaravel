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
        Schema::table('answers', function (Blueprint $table) {
            // Dodajemy nowe kolumny do istniejącej tabeli
            if (!Schema::hasColumn('answers', 'cuisine_tags')) {
                $table->json('cuisine_tags')->nullable()->comment('Cuisine types this answer is associated with');
            }

            if (!Schema::hasColumn('answers', 'price_range')) {
                $table->json('price_range')->nullable()->comment('Price range this answer is associated with');
            }

            if (!Schema::hasColumn('answers', 'score')) {
                $table->integer('score')->default(0)->comment('Score for recommendation algorithm');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn(['cuisine_tags', 'price_range', 'score']);
        });
    }
};
