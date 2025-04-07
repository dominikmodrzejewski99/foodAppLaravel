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
        Schema::table('questions', function (Blueprint $table) {
            // Dodajemy nowe kolumny do istniejącej tabeli
            if (!Schema::hasColumn('questions', 'category')) {
                $table->string('category')->nullable();
            }

            if (!Schema::hasColumn('questions', 'weight')) {
                $table->integer('weight')->default(1)->comment('Importance weight for recommendation algorithm');
            }

            if (!Schema::hasColumn('questions', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['category', 'weight', 'is_active']);
        });
    }
};
