<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('responsables_laboratoires', function (Blueprint $table) {
            $table->bigIncrements('id');

            // FK vers users (responsable)
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // FK vers laboratoires
            $table->unsignedBigInteger('laboratoire_id');
            $table->foreign('laboratoire_id')->references('id')->on('laboratoires')->onDelete('cascade');

            // Optionnel : rôle ou titre
            $table->string('fonction')->nullable();

            // Audit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responsables_laboratoires');
    }
};
