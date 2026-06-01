<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demande_essai', function (Blueprint $table) {
            $table->id();

            // Clés étrangères
            $table->unsignedBigInteger('demande_id');
            $table->foreign('demande_id')
                  ->references('id')
                  ->on('produits')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('essai_id');
            $table->foreign('essai_id')
                  ->references('id')
                  ->on('essais')
                  ->onDelete('cascade');

            // Champs supplémentaires du formulaire
            $table->boolean('nouvel_essai')->default(true); // Nouvel essai ou non
            $table->enum('statut', ['en_attente', 'en_cours', 'termine'])->default('en_attente'); // Statut de l’essai
            $table->text('description')->nullable(); // Description
            $table->text('informations_complementaires')->nullable(); // Infos complémentaires
            $table->string('echantillons')->nullable(); // Échantillons

            // Clé étrangère vers laboratoires (pôle)
            $table->unsignedBigInteger('laboratoire_id')->nullable();
            $table->foreign('laboratoire_id')
                  ->references('id')
                  ->on('laboratoires')
                  ->onDelete('set null');

            // Audit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demande_essai');
    }
};
