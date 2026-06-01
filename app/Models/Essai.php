<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Essai extends Model
{
    use HasFactory;

    protected $table = 'essais';

    protected $fillable = [
        'laboratoire_id',
        'nom_essai',
        'actif',
        'nouveau',
    ];

    // Relation avec le laboratoire
    public function laboratoire()
    {
        return $this->belongsTo(Laboratoire::class, 'laboratoire_id');
    }

    // Relation avec les demandes via la table pivot
    public function demandes()
    {
        return $this->belongsToMany(Produit::class, 'demande_essai', 'essai_id', 'demande_id')
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
}
