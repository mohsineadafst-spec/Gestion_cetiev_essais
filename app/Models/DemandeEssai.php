<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\DemandeEssaiObserver;

class DemandeEssai extends Model
{
    use HasFactory;

    protected $table = 'demande_essai';

    protected $fillable = [
        'demande_id',
        'essai_id',
        'nouvel_essai',
        'statut',
        'cloture',
        'description',
        'informations_complementaires',
        'echantillons',
        'laboratoire_id',
    ];

    protected $casts = [
        'nouvel_essai' => 'boolean',
        'cloture' => 'boolean',
    ];

    /**
     * Boot du modèle - Enregistrer les observers
     */
    protected static function boot()
    {
        parent::boot();
        static::observe(DemandeEssaiObserver::class);
    }

    // Relations
    public function demande()
    {
        return $this->belongsTo(Produit::class, 'demande_id');
    }

    public function essai()
    {
        return $this->belongsTo(Essai::class, 'essai_id');
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

    public function laboratoire()
    {
        return $this->belongsTo(Laboratoire::class, 'laboratoire_id');
    }

    public function etude()
    {
        return $this->hasOne(Etude::class);
    }

    // Accessors pour passer les attributs de la demande (Produit)
    public function getTypeAttribute()
    {
        return $this->demande?->type;
    }

    public function getClientNameAttribute()
    {
        return $this->demande?->client_name;
    }
}
