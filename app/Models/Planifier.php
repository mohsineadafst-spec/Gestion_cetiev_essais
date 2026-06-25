<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planifier extends Model
{
    use HasFactory;

    protected $table = 'planifier';

    protected $fillable = [
        'demande_confirme_id',
        'demande_essai_id',
        'intervenant_id',
        
        'Rapport_redige',
        'statue',
       
        'etat',
        'idessai',
        'd_reception',
        'typerapport',
        'dd_prevu',
        'soustrait',
        'code_rapport',
        'dateedition',
    ];

    // Relation : une planification appartient à une demande confirmée
    public function demandeConfirmee()
    {
        return $this->belongsTo(DemandeConfirmee::class, 'demande_confirme_id');
    }

    // Relation : une planification appartient à un essai lié à une demande
    public function demandeEssai()
    {
        return $this->belongsTo(DemandeEssai::class, 'demande_essai_id');
    }

    // Relation : une planification est assignée à un intervenant (user)
    public function intervenant()
    {
        return $this->belongsTo(User::class, 'intervenant_id');
    }
}
