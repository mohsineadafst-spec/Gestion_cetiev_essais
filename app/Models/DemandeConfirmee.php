<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeConfirmee extends Model
{
    protected $table = 'demandes_confirmees';

    protected $fillable = [
        'demande_essai_id',
        'client',
        'date_reception',
        'numero_bc',
        'date_reception_bc',
        'laboratoire_id',
        'confirmation',
        'code_rapport',
    ];

    protected $casts = [
        'date_reception' => 'date',
        'date_reception_bc' => 'date',
    ];

    /**
     * Relation : la demande d'essai associée
     */
    public function demandeEssai()
    {
        return $this->belongsTo(DemandeEssai::class, 'demande_essai_id');
    }

    /**
     * Relation : le laboratoire associé
     */
    public function laboratoire()
    {
        return $this->belongsTo(Laboratoire::class);
    }
}
