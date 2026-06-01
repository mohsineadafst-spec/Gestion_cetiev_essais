<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('essais', function (Blueprint $table) {
            $table->id(); // id auto-incrémenté

            // Clé étrangère vers laboratoires
            $table->unsignedBigInteger('laboratoire_id');
            $table->foreign('laboratoire_id')
                  ->references('id')
                  ->on('laboratoires')
                  ->onDelete('cascade');

            // Nom de l’essai
            $table->string('nom_essai', 255);

            // Actif ou pas actif
            $table->boolean('actif')->default(true);

            // Nouveau ou non
            $table->boolean('nouveau')->default(false);

            // Audit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('essais');
    }
};
