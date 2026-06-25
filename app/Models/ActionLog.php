<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class ActionLog extends Model
{
    protected $fillable = ['action', 'details', 'user_id'];
     public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getReadableActionAttribute()
{
    $parts = explode(' ', $this->action); // ex: DELETE users/5
    $method = $parts[0] ?? '';
    $route  = $parts[1] ?? '';

    switch ($method) {
        case 'POST':
            return "a créé $route";
        case 'PUT':
        case 'PATCH':
            return "a modifié $route";
        case 'DELETE':
            return "a supprimé $route";
        case 'GET':
            return "a consulté $route";
        default:
            return "$method $route";
    }
}

}

