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
        Schema::table('biographies', function (Blueprint $table) {
            if (!Schema::hasColumn('biographies', 'cover_path')) {
                $table->string('cover_path')->nullable();
            }
            if (!Schema::hasColumn('biographies', 'document_path')) {
                $table->string('document_path')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biographies', function (Blueprint $table) {
            $table->dropColumn(['cover_path', 'document_path']);
        });
    }
};
