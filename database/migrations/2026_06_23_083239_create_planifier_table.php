<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planifier', function (Blueprint $table) {
            $table->id(); // clé primaire

            // Relation avec la demande confirmée
            $table->foreignId('demande_confirme_id')
                  ->constrained('demandes_confirme')
                  ->onDelete('cascade');

            // Relation avec l’essai (via demandes_essais)
            $table->foreignId('demande_essai_id')
                  ->constrained('demande_essai')
                  ->onDelete('cascade');

            // Intervenant (user)
            $table->foreignId('intervenant_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Dates de planification
            $table->date('dd_p')->nullable();
            $table->dateTime('df_p')->nullable();
            $table->dateTime('dd_real')->nullable();
            $table->dateTime('df_real')->nullable();
            $table->dateTime('dd_prevu')->nullable();
            $table->date('d_reception')->nullable();
            $table->date('datereceptionechan')->nullable();
            $table->date('datereception_BC')->nullable();
            $table->dateTime('dateedition')->nullable();

            // Informations complémentaires
            $table->text('Rapport_redige')->nullable();
            $table->string('typerapport', 40)->nullable();
            $table->string('code_rapport', 40)->nullable();
            $table->string('soustrait', 40)->default('interne');
            $table->string('statue', 50)->default('todo');
            $table->string('etat', 40)->default('en_attente');
            $table->integer('start')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planifier');
    }
};
