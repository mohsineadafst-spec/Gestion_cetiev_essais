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
        Schema::table('demandes_confirmees', function (Blueprint $table) {
            $table->foreignId('demande_essai_id')->nullable()->constrained('demande_essai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandes_confirmees', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['demande_essai_id']);
            $table->dropColumn('demande_essai_id');
        });
    }
};
