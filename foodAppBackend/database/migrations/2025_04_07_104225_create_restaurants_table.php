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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('city')->default('Wrocław');
            $table->string('cuisine');
            $table->decimal('rating', 3, 1)->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('price_level', 2, 1)->nullable()->comment('Price level from 1.0 to 5.0');
            $table->boolean('is_tiktok_recommended')->default(false);
            $table->integer('popularity_score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
