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
        Schema::create('demandes_confirmees', function (Blueprint $table) {
            $table->id();
            $table->string('client')->required();
            $table->date('date_reception')->required();
            $table->string('numero_bc')->required();
            $table->date('date_reception_bc')->required();
            $table->foreignId('laboratoire_id')->constrained('laboratoires')->onDelete('cascade');
            $table->enum('confirmation', ['oui', 'non'])->default('non');
            $table->string('code_rapport')->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes_confirmees');
    }
};
