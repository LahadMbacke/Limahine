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
        Schema::create('bibliographies', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Translatable
            $table->json('author_name'); // Translatable
            $table->json('description')->nullable(); // Translatable
            $table->string('type'); // livre, article, manuscrit, etc.
            $table->string('langue');
            $table->date('date_publication')->nullable();
            $table->string('editeur')->nullable();
            $table->string('isbn')->nullable();
            $table->integer('pages')->nullable();
            $table->boolean('disponible_en_ligne')->default(false);
            $table->string('url_telechargement')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('featured')->default(false);
            $table->string('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bibliographies');
    }
};
