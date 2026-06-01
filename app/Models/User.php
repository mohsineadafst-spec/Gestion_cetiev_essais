<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Table associée
    protected $table = 'users';

    // Colonnes modifiables
    protected $fillable = [
        'username',
        'mdp',
        'email',
        'role',
        'is_active',
        'last_login',
    ];

    // Indiquer à Laravel que le password est dans 'mdp'
    protected $hidden = ['mdp'];

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->attributes['mdp'];
    }

    /**
     * Relation : les laboratoires que cet utilisateur gère
     */
    public function laboratoiresResponsable()
    {
        return $this->hasMany(ResponsableLaboratoire::class, 'user_id');
    }

    /**
     * Obtenir les IDs des laboratoires que cet utilisateur gère
     */
    public function getLaboratoiresManagedIds()
    {
        return $this->laboratoiresResponsable()
                    ->pluck('laboratoire_id')
                    ->toArray();
    }

    /**
     * Vérifier si l'utilisateur gère un laboratoire spécifique
     */
    public function manageLaboratoire($laboratoireId)
    {
        return $this->laboratoiresResponsable()
                    ->where('laboratoire_id', $laboratoireId)
                    ->exists();
    }

    /**
     * Accessors pour getter le nom de l'utilisateur
     */
    public function getNameAttribute()
    {
        return $this->attributes['username'] ?? null;
    }
}
