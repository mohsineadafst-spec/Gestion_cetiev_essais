<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActionLog;
use Illuminate\Support\Facades\Auth;

class ActionLogController extends Controller
{
    /**
     * Exemple de méthode pour enregistrer une action
     */
    public function store(Request $request)
    {
        ActionLog::create([
            'action' => 'Création demande confirmée',
            'details' => json_encode($request->all()),
            'user_id' => Auth::id()
        ]);

        return response()->json(['message' => 'Action log enregistrée avec succès']);
    }
   public function index(Request $request)
{
    $query = \App\Models\ActionLog::with('user')->latest();

    // Filtrage par méthode HTTP
    if ($request->filled('method')) {
        $query->where('action', 'like', $request->method.'%');
    }

    // Filtrage par utilisateur
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    $logs = $query->paginate(20);

    return view('logs.index', compact('logs'));
}

public function destroy($id)
{
    $log = \App\Models\ActionLog::findOrFail($id);
    $log->delete();

    return redirect()->route('logs.index')->with('success', 'Audit supprimé avec succès.');
}



}
