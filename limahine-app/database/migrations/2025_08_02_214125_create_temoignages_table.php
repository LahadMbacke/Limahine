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
        Schema::create('temoignages', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Translatable
            $table->longText('content'); // Translatable
            $table->string('author_name');
            $table->json('author_title')->nullable(); // Translatable
            $table->json('author_description')->nullable(); // Translatable
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('location')->nullable();
            $table->date('date_temoignage')->nullable();
            $table->boolean('verified')->default(false);
            $table->text('meta_description')->nullable(); // Translatable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temoignages');
    }
};
