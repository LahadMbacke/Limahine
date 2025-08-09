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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Translatable
            $table->string('slug')->unique();
            $table->longText('content'); // Translatable
            $table->text('excerpt')->nullable(); // Translatable
            $table->boolean('is_published')->default(false);
            $table->string('page_type')->default('custom');
            $table->json('meta_title')->nullable(); // Translatable
            $table->json('meta_description')->nullable(); // Translatable
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
