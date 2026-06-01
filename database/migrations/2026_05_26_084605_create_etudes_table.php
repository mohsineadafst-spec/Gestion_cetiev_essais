<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('etudes', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relation avec demande_essai
            $table->unsignedBigInteger('demande_essai_id');
            $table->foreign('demande_essai_id')
                  ->references('id')
                  ->on('demande_essai')
                  ->onDelete('cascade');

            // Faisabilité
            $table->enum('faisabilite', ['faisable', 'non_faisable', 'a_confirmer'])->default('a_confirmer');

            // Besoin d'information complémentaire
            $table->text('besoin_information')->nullable();

            // Motif de non faisabilité
            $table->string('motif_non_faisabilite')->nullable();

            // Raison sélectionnée
            $table->string('raison')->nullable();

            // Norme / CDC
            $table->string('norme_cdc')->nullable();

            // Besoin de sous-traitance
            $table->boolean('besoin_sous_traitance')->default(false);
            $table->string('sous_traitant')->nullable();

            // Besoin de montage/outillage spécifique
            $table->boolean('besoin_outillage')->default(false);
            $table->text('details_outillage')->nullable();

            // Besoin des heures supplémentaires
            $table->boolean('besoin_heures_sup')->default(false);
            $table->integer('nombre_heures_sup')->nullable();
            $table->string('personnes_concernees')->nullable();

            // Délai prévisionnel de réalisation (jours)
            $table->integer('delai_previsionnel')->nullable();

            // Conditions particulières
            $table->text('conditions_particulieres')->nullable();

            // Responsable qui valide l’étude
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->foreign('responsable_id')
                  ->references('id')
                  ->on('responsables_laboratoires')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etudes');
    }
};
