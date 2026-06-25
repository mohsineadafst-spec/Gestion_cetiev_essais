<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandesConfirmeTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demandes_confirme', function (Blueprint $table) {
            $table->bigIncrements('id'); // id primaire

            $table->string('client', 255); // client
            $table->date('date_reception'); // date réception
            $table->string('numero_bc', 255); // numéro BC
            $table->date('date_reception_bc'); // date réception BC

            $table->foreignId('laboratoire_id')
                  ->constrained('laboratoires')
                  ->onDelete('cascade'); // FK vers laboratoires

            $table->enum('confirmation', ['oui', 'non'])
                  ->default('non'); // confirmation

            $table->string('code_rapport', 255); // code rapport

            $table->foreignId('produit_id')
                  ->constrained('produits')
                  ->onDelete('cascade'); // FK vers produits

            $table->foreignId('demande_essai_id')
                  ->nullable()
                  ->constrained('demande_essai')
                  ->onDelete('set null'); // FK optionnelle vers demande_essai

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes_confirme');
    }
}
