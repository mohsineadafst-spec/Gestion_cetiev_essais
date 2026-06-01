<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsableLaboratoire extends Model
{
    protected $table = 'responsables_laboratoires';
    protected $fillable = ['user_id', 'laboratoire_id', 'fonction'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laboratoire()
    {
        return $this->belongsTo(Laboratoire::class);
    }
}
