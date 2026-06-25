<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute la migration.
     */
    public function up(): void
    {
        Schema::create('action_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // type d’action (ex: création, suppression…)
            $table->text('details')->nullable(); // infos supplémentaires
            $table->unsignedBigInteger('user_id')->nullable(); // utilisateur concerné
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Annule la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_logs');
    }
};
