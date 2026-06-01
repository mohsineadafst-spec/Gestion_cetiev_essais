<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laboratoires', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Infos labo
            $table->string('nom')->unique();              // ancien nom_laboratoire
            $table->string('email_principal')->nullable();// email principal
            $table->string('telephone')->nullable();      // contact

            // Relations
            $table->unsignedBigInteger('responsable_id')->nullable();

            // Statut
            $table->boolean('is_active')->default(true);

            // Audit
            $table->timestamps(); // created_at & updated_at auto-gérés
        });

        // Contraintes FK
        Schema::table('laboratoires', function (Blueprint $table) {
            $table->foreign('responsable_id')
                  ->references('id')->on('users')
                  ->onDelete('set null'); // si user supprimé, responsable_id devient NULL
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laboratoires');
    }
};
