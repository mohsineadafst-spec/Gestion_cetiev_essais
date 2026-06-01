<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratoire extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'email_principal', 'telephone', 'responsable_id', 'is_active'];

    /**
     * Relation : le responsable principal du laboratoire
     */
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    /**
     * Relation : les responsables attachés au laboratoire (table pivot)
     */
    public function responsables()
    {
        return $this->hasMany(ResponsableLaboratoire::class);
    }

}
