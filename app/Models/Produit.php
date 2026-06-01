<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
       'id', 'client_name', 'lab_id', 'created_by', 'updated_by',
        'date_prevue', 'date_edition', 'date_reception',
        'marque', 'quantite', 'montant_ttc',
        'statut_paiement', 'statut', 'resultat',
        'type',
        'url_rapport', 'notes', 'details'
    ];

    protected $casts = [
        'date_prevue' => 'datetime',
        'date_edition' => 'datetime',
        'date_reception' => 'datetime',
        'montant_ttc' => 'decimal:2',
        'quantite' => 'integer',
    ];

    /**
     * Relation : le laboratoire
     */
    public function laboratoire()
    {
        return $this->belongsTo(Laboratoire::class, 'lab_id');
    }
    public function demandesEssai()
    {
        return $this->hasMany(DemandeEssai::class, 'demande_id');
    }
    public function essais()
{
    return $this->belongsToMany(Essai::class, 'demande_essai', 'demande_id', 'essai_id')
                ->withPivot([
                    
                    'nouvel_essai',
                    'statut',
                    'description',
                    'informations_complementaires',
                    'echantillons',
                    'laboratoire_id',
                ])
                ->withTimestamps();
}


    /**
     * Relation : l'utilisateur qui a créé
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relation : l'utilisateur qui a mis à jour
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Vérifier si tous les essais de cette demande sont clôturés
     */
    public function areAllEssaisClotures(): bool
    {
        $totalEssais = $this->demandesEssai()->count();
        
        if ($totalEssais === 0) {
            return false;
        }

        $essaisClotures = $this->demandesEssai()->where('cloture', true)->count();
        
        return $essaisClotures === $totalEssais;
    }

    /**
     * Mettre à jour le statut en fonction des essais clôturés
     */
    public function updateStatusBasedOnEssais(): void
    {
        if ($this->areAllEssaisClotures()) {
            $this->update(['statut' => 'done']);
        } else {
            if ($this->statut === 'done') {
                $this->update(['statut' => 'en_attente']);
            }
        }
    }
}
