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
        Schema::table('restaurants', function (Blueprint $table) {
            // Dodanie pól dla dopasowania do pytań
            $table->integer('match_people_count')->default(0)->comment('Dopasowanie do pytania o ilość osób (0-9)');
            $table->integer('match_price_per_person')->default(0)->comment('Dopasowanie do pytania o maksymalną kwotę na osobę (0-9)');
            $table->integer('match_meal_type')->default(0)->comment('Dopasowanie do pytania o rodzaj posiłku (0-9)');
            $table->integer('match_visit_purpose')->default(0)->comment('Dopasowanie do pytania o cel wizyty (0-9)');
            $table->integer('match_dietary_preferences')->default(0)->comment('Dopasowanie do pytania o preferencje dietetyczne (0-9)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn([
                'match_people_count',
                'match_price_per_person',
                'match_meal_type',
                'match_visit_purpose',
                'match_dietary_preferences',
            ]);
        });
    }
};
