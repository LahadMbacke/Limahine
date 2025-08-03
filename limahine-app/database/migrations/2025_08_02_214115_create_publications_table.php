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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Translatable
            $table->text('content'); // Translatable
            $table->text('excerpt')->nullable(); // Translatable
            $table->string('slug')->unique();
            $table->string('category');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('featured_image')->nullable();
            $table->text('meta_description')->nullable(); // Translatable
            $table->foreignId('author_id')->constrained('users');
            $table->integer('reading_time')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
