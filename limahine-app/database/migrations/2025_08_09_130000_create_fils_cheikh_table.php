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
        Schema::create('fils_cheikh', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // Nom multilingue
            $table->json('biography')->nullable(); // Biographie multilingue
            $table->json('description')->nullable(); // Description courte multilingue
            $table->string('slug')->unique();
            $table->boolean('is_khalif')->default(false); // Indique s'il s'agit d'un Khalif
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->integer('order_of_succession')->nullable(); // Ordre de succession pour les Khalifs
            $table->boolean('is_published')->default(true);
            $table->json('meta_description')->nullable(); // Meta description multilingue pour SEO
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fils_cheikh');
    }
};
