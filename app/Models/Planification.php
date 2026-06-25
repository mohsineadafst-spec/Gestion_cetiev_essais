<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planification extends Model
{
    protected $fillable = [
        'demandes_confirmees',
        'intervenant_id',
        'date_reception',
        'date_debut',
        'date_fin',
        'date_prevue',
        'date_fin_reel',
        'type_rapport',
        'mode_execution',
        'statut',
        'action',
    ];

    public function demandeConfirmee()
    {
        return $this->belongsTo(DemandeConfirmee::class, 'demandes_confirmees');
    }

    public function intervenant()
    {
        return $this->belongsTo(User::class, 'intervenant_id');
    }
}
