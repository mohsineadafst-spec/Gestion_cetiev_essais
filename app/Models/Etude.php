<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etude extends Model
{
    protected $table = 'etudes';
    
    protected $fillable = [
        'demande_essai_id',
        'faisabilite',
        'besoin_information',
        'motif_non_faisabilite',
        'raison',
        'norme_cdc',
        'besoin_sous_traitance',
        'sous_traitant',
        'besoin_outillage',
        'details_outillage',
        'besoin_heures_sup',
        'nombre_heures_sup',
        'personnes_concernees',
        'delai_previsionnel',
        'conditions_particulieres',
        'responsable_id',
    ];

    protected $casts = [
        'besoin_sous_traitance' => 'boolean',
        'besoin_outillage' => 'boolean',
        'besoin_heures_sup' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation : la demande d'essai associée
     */
    public function demandeEssai()
    {
        return $this->belongsTo(DemandeEssai::class);
    }

    /**
     * Relation : le responsable qui valide l'étude
     */
    public function responsable()
    {
        return $this->belongsTo(ResponsableLaboratoire::class);
    }
}
