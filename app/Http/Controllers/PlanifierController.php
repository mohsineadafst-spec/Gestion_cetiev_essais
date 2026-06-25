<?php

namespace App\Http\Controllers;

use App\Models\Planifier;
use App\Models\DemandeConfirmee;
use App\Models\DemandeEssai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PlanifierController extends Controller
{
    /**
     * Afficher la liste des planifications existantes
     */
   public function index()
{
    /** @var User $user */
    $user = Auth::user();
    $laboratoireIds = $user->getLaboratoiresManagedIds();

    $planifications = Planifier::with(['demandeConfirmee.produit', 'demandeConfirmee.demandesEssais.essai', 'intervenant'])
        ->whereHas('demandeConfirmee', function ($query) use ($laboratoireIds) {
            $query->whereIn('laboratoire_id', $laboratoireIds);
        })
        ->paginate(10);

    return view('planifier.index', compact('planifications'));
}


    /**
     * Formulaire de création d'une nouvelle planification
     */
   public function create()
{ /** @var User $user */
        $user = Auth::user();
    // Récupérer les IDs des laboratoires gérés par le user connecté
    $laboratoireIds = $user->getLaboratoiresManagedIds();
 $demandesConfirmees = DemandeConfirmee::with(['produit', 'demandesEssais.essai'])
        ->where('laboratoire_id', $laboratoireIds)
        ->get();    $intervenants = User::all();

    return view('planifier.create', compact('demandesConfirmees', 'intervenants'));
}


    /**
     * Enregistrer une nouvelle planification
     */
    public function store(Request $request)
{
    /** @var User $user */
    $user = Auth::user();
    $laboratoireIds = $user->getLaboratoiresManagedIds();

    $request->validate([
        'demande_confirme_id' => 'required|exists:demandes_confirme,id',
        'essais_planifies'    => 'required|array',
    ]);

    // Vérifier que la demande confirmée appartient bien au labo de l’utilisateur
    $demandeConfirmee = DemandeConfirmee::findOrFail($request->demande_confirme_id);
    if (!in_array($demandeConfirmee->laboratoire_id, $laboratoireIds)) {
        abort(403, 'Accès interdit : laboratoire non autorisé.');
    }

    foreach ($request->essais_planifies as $essaiData) {
        Planifier::create([
            'demande_confirme_id' => $request->demande_confirme_id,
            'demande_essai_id'    => $essaiData['essai_id'],
            'intervenant_id'      => $essaiData['intervenant_id'],
            'dd_prevu'            => $essaiData['dd_prevu'],
            'Rapport_redige'      => $essaiData['Rapport_redige'] ?? null,
        ]);
    }

    return redirect()->route('planifier.index')->with('success', 'Planifications créées avec succès.');
}



    /**
     * Afficher une planification
     */
   public function show($id)
{
    // Récupérer la planification avec ses relations
    $planification = Planifier::with([
        'demandeConfirmee.produit',   // pour accéder à client_name et nom produit
        'demandeEssai.essai',         // pour accéder au nom de l’essai
        'intervenant'                 // pour afficher l’intervenant
    ])->findOrFail($id);

    // Retourner la vue show avec les données
    return view('planifier.show', compact('planification'));
}


    /**
     * Formulaire d'édition
     */
  public function edit($id)
{
    /** @var User $user */
    $user = Auth::user();
    $laboratoireIds = $user->getLaboratoiresManagedIds();

    $planif = Planifier::with(['demandeConfirmee.produit', 'demandeEssai.essai', 'intervenant'])
        ->findOrFail($id);

    // Vérifier que la planification appartient au labo de l’utilisateur
    if (!in_array($planif->demandeConfirmee->laboratoire_id, $laboratoireIds)) {
        abort(403, 'Accès interdit : laboratoire non autorisé.');
    }

    $intervenants = User::all();

    return view('planifier.edit', compact('planif', 'intervenants'));
}



    /**
     * Mettre à jour une planification
     */
 public function update(Request $request, $id)
{
    /** @var User $user */
    $user = Auth::user();
    $laboratoireIds = $user->getLaboratoiresManagedIds();

    $request->validate([
        'intervenant_id'     => 'required|exists:users,id',
        'dd_prevu'           => 'nullable|date',
        'dd_p'               => 'nullable|date',
        'df_p'               => 'nullable|date',
        'datereceptionechan' => 'nullable|date',
        'Rapport_redige'     => 'nullable|string',
        'typerapport'        => 'required|in:intermediaire,finale',
        'statue'             => 'required|in:en_attente,en_cours,termine,annule',
    ]);

    $planif = Planifier::findOrFail($id);

    // Vérifier que la planification appartient au labo de l’utilisateur
    if (!in_array($planif->demandeConfirmee->laboratoire_id, $laboratoireIds)) {
        abort(403, 'Accès interdit : laboratoire non autorisé.');
    }

    $planif->update($request->all());

    return redirect()->route('planifier.index')->with('success', 'Planification mise à jour avec succès.');
}



    /**
     * Supprimer une planification
     */
   public function destroy($id)
{
    /** @var User $user */
    $user = Auth::user();
    $laboratoireIds = $user->getLaboratoiresManagedIds();

    $planification = Planifier::findOrFail($id);

    // Vérifier que la planification appartient au labo de l’utilisateur
    if (!in_array($planification->demandeConfirmee->laboratoire_id, $laboratoireIds)) {
        abort(403, 'Accès interdit : laboratoire non autorisé.');
    }

    $planification->delete();

    return redirect()->route('planifier.index')->with('success', 'Planification supprimée avec succès.');
}

}
