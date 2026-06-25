<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeConfirmee extends Model
{
    protected $table = 'demandes_confirme';

    protected $fillable = [
        'produit_id',
        'client',
        'laboratoire_id',
        'date_reception_échantillons',
        'numero_bc',
        'date_reception_bc',
        'confirmation',
        'code_rapport',
        'demande_essai_id',
    ];

    protected $casts = [
        'date_reception_échantillons' => 'date',
        'date_reception_bc' => 'date',
    ];

    /**
     * Relation : le produit associé
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    /**
     * Relation : le laboratoire associé
     */
    public function laboratoire()
    {
        return $this->belongsTo(Laboratoire::class, 'laboratoire_id');
    }

    /**
     * Relation : la demande_essai associée (optionnelle)
     */
   public function demandesEssais()
    {
        return $this->hasMany(DemandeEssai::class, 'demande_id', 'produit_id');
    }

}
