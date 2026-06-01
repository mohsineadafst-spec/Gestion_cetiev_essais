<?php

namespace App\Observers;

use App\Models\DemandeEssai;
use App\Models\Produit;

class DemandeEssaiObserver
{
    /**
     * Déclenché après la sauvegarde d'une DemandeEssai
     */
    public function updated(DemandeEssai $demandeEssai): void
    {
        // Vérifier si tous les essais de cette demande sont clôturés
        $this->checkAndUpdateDemandaStatus($demandeEssai->demande_id);
    }

    /**
     * Vérifier et mettre à jour le statut de la demande
     */
    private function checkAndUpdateDemandaStatus($demandeId): void
    {
        $demande = Produit::find($demandeId);
        
        if (!$demande) {
            return;
        }

        // Compter les essais clôturés et non clôturés
        $totalEssais = $demande->demandesEssai()->count();
        $essaisClotures = $demande->demandesEssai()->where('cloture', true)->count();

        // Si tous les essais sont clôturés, mettre à jour le statut
        if ($totalEssais > 0 && $essaisClotures === $totalEssais) {
            $demande->update(['statut' => 'done']);
        } elseif ($demande->statut === 'done' && $essaisClotures < $totalEssais) {
            // Si au moins un essai n'est plus clôturé, remettre le statut en attente
            $demande->update(['statut' => 'en_attente']);
        }
    }
}
