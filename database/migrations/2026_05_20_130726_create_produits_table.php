<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relations
              
            $table->unsignedBigInteger('lab_id');      // FK vers laboratoires
            $table->unsignedBigInteger('created_by');  // FK vers users
            $table->unsignedBigInteger('updated_by');  // FK vers users

            // Dates
            $table->dateTime('date_prevue')->nullable();
            $table->dateTime('date_edition')->nullable();
            $table->dateTime('date_reception')->nullable();

            // Infos produit
            $table->string('client_name'); 
            $table->string('type');
            $table->string('marque')->nullable();
            $table->integer('quantite')->default(0);
            $table->decimal('montant_ttc', 10, 2)->default(0);

            // Statuts
            $table->enum('statut_paiement', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->enum('statut', ['todo', 'in_progress', 'done', 'cancelled'])->default('todo');
            $table->enum('resultat', ['conforme', 'non_conforme', 'partiel'])->nullable();

            // Autres infos
            $table->string('url_rapport')->nullable();
            $table->text('notes')->nullable();
            $table->text('details')->nullable();

            // Audit
            $table->timestamps(); // created_at & updated_at auto-gérés
        });

        // Contraintes FK
        Schema::table('produits', function (Blueprint $table) {
            $table->foreign('lab_id')->references('id')->on('laboratoires')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
