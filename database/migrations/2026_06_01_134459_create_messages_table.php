<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // Utilisateur qui envoie le message
            $table->unsignedBigInteger('sender_id');

            // Utilisateur qui reçoit le message
            $table->unsignedBigInteger('receiver_id');

            // Contenu du message
            $table->text('content');

            // Statut optionnel (envoyé, lu, etc.)
            $table->enum('status', ['sent', 'received', 'read'])->default('sent');

            $table->timestamps();

            // Relations avec la table users
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
}
