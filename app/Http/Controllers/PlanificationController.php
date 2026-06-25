<?php

namespace App\Http\Controllers;

use App\Models\Planification;
use App\Models\DemandeConfirmee;
use App\Models\User;
use Illuminate\Http\Request;

class PlanificationController extends Controller
{
    // Affiche la liste des planifications
    public function index()
    {
        $planifications = Planification::with(['demandeConfirmee.essai', 'demandeConfirmee.laboratoire', 'intervenant'])
            ->paginate(10);

        return view('planifications.index', compact('planifications'));
    }

    // Formulaire de création
   public function create()
{
    $demandesConfirmees = DemandeConfirmee::with(['produit', 'demandesEssais.essai'])->get();
    $intervenants = User::all();

    return view('planifier.create', compact('demandesConfirmees', 'intervenants'));
}


    // Enregistrement en BDD
    public function store(Request $request)
    {
        $request->validate([
            'demande_confirmee_id' => 'required|exists:demandes_confirmees,id',
            'intervenant_id' => 'required|exists:users,id',
        ]);

        $data = $request->only([
            'demande_confirmee_id',
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
        ]);

        Planification::create($data);

        return redirect()->route('planifications.index')->with('success', 'Planification créée avec succès.');
    }

    // Formulaire d’édition
    public function edit($id)
    {
        $planification = Planification::findOrFail($id);
        $intervenants = User::all();

        return view('planifications.edit', compact('planification', 'intervenants'));
    }

    // Mise à jour
    public function update(Request $request, $id)
    {
        $planification = Planification::findOrFail($id);

        $data = $request->only([
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
        ]);

        $planification->update($data);

        return redirect()->route('planifications.index')->with('success', 'Planification mise à jour.');
    }

    // Suppression
    public function destroy($id)
    {
        $planification = Planification::findOrFail($id);
        $planification->delete();

        return redirect()->route('planifications.index')->with('success', 'Planification supprimée.');
    }
}
