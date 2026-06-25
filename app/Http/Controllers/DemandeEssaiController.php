<?php

namespace App\Http\Controllers;

use App\Models\DemandeEssai;
use App\Models\Produit;
use App\Models\Essai;
use App\Models\Laboratoire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeEssaiController extends Controller
{
    /**
     * Afficher la liste des assignations demande-essai
     */
   public function index(Request $request)
{
    $query = Produit::with(['laboratoire', 'essais']);

    // Si une recherche est envoyée
    if ($request->filled('search')) {
        $query->where('id', $request->input('search'));
    }

    $demandeEssais = $query->paginate(9);

    return view('demande_essai.index', compact('demandeEssais'));
}


    /**
     * Afficher le formulaire de création
     */
 public function create(Request $request)
{
    $produits = Produit::orderBy('created_at', 'desc')->get();
/** @var User $user */
        $user = Auth::user();
    // Récupérer les IDs des laboratoires gérés par le user connecté
    $laboratoireIds = $user->getLaboratoiresManagedIds();

    // Filtrer les essais par ces laboratoires
    $essais = Essai::whereIn('laboratoire_id', $laboratoireIds)
                   ->orderBy('nom_essai')
                   ->get();

    $laboratoires = Laboratoire::where('is_active', true)
                               ->orderBy('nom')
                               ->get();

    $demandeIdPreselectionne = $request->query('demande_id');

    return view('demande_essai.create', compact(
        'produits',
        'essais',
        'laboratoires',
        'demandeIdPreselectionne'
    ));
}



    /**
     * Enregistrer une nouvelle assignation demande-essai
     */
   public function store(Request $request)
{
    $essaiOption = $request->get('essai_option', 'existant');

    $rules = [
        'demande_id' => ['required', 'exists:produits,id'],
        'laboratoire_id' => ['required', 'exists:laboratoires,id'],
        'statut' => ['required', 'in:catalogué,non catalogué'],
        'description' => ['nullable', 'string', 'max:1000'],
        'informations_complementaires' => ['nullable', 'string', 'max:1000'],
        'echantillons' => ['nullable', 'string', 'max:255'],
    ];

    if ($essaiOption === 'existant') {
        $rules['essai_id'] = ['required', 'exists:essais,id'];
    } else {
        $rules['nouveau_essai_nom'] = ['required', 'string', 'max:255'];
        // ⚠️ plus besoin de demander le laboratoire dans le formulaire
    }

    $validated = $request->validate($rules);

    // Création de l’essai si c’est un nouveau
    $essaiId = null;
    /** @var User $user */
     $user = Auth::user();
    // Récupérer les IDs des laboratoires gérés par le user connecté
    $laboratoireIds = $user->getLaboratoiresManagedIds()[0] ?? null;
    if ($essaiOption === 'nouveau') {
        $essai = Essai::create([
            'nom_essai'      => $validated['nouveau_essai_nom'],
            'laboratoire_id' => $laboratoireIds, // 🔑 même labo que le user
            'actif'          => true,
            'nouveau'        => true,
        ]);
        $essaiId = $essai->id;
    } else {
        $essaiId = $validated['essai_id'];
    }

    // Créer l’assignation Demande ↔ Essai
    $assignationData = [
        'demande_id'                => $validated['demande_id'],
        'essai_id'                  => $essaiId,
        'laboratoire_id'            => $validated['laboratoire_id'],
        'statut'                    => $validated['statut'],
        'description'               => $validated['description'] ?? null,
        'informations_complementaires' => $validated['informations_complementaires'] ?? null,
        'echantillons'              => $validated['echantillons'] ?? null,
    ];

    DemandeEssai::create($assignationData);

    return redirect()->route('demande_essai.index')
                     ->with('success', 'Assignation créée avec succès.');
}
 public function show(DemandeEssai $demandeEssai)
    {
       
        $demandeEssai->load(['demande', 'essai', 'laboratoire']);
        return view('demande_essai.show', compact('demandeEssai', 'kpi'));
    }

    /**
     * Afficher un produit avec toutes ses assignations demande-essai
     */
    public function showProduit(Produit $produit)
    {
        $produit->load(['laboratoire', 'demandesEssai.essai', 'demandesEssai.laboratoire', 'demandesEssai.etude']);
        
        // Calculer les KPI sur TOUTES les demandes d'essai du produit
        $totalEssais = $produit->demandesEssai()->count();
        $faisables = $produit->demandesEssai()
            ->whereHas('etude', fn($q) => $q->where('faisabilite', 'faisable'))
            ->count();
        $nonFaisables = $produit->demandesEssai()
            ->whereHas('etude', fn($q) => $q->where('faisabilite', 'non_faisable'))
            ->count();
        $nonConfirmes = $produit->demandesEssai()
            ->whereHas('etude', fn($q) => $q->where('faisabilite', 'a_confirmer'))
            ->count();

        $kpi = [
            'total' => $totalEssais,
            'faisables' => $faisables,
            'faisables_percent' => $totalEssais > 0 ? round(($faisables / $totalEssais) * 100) : 0,
            'non_faisables' => $nonFaisables,
            'non_faisables_percent' => $totalEssais > 0 ? round(($nonFaisables / $totalEssais) * 100) : 0,
            'non_confirmes' => $nonConfirmes,
            'non_confirmes_percent' => $totalEssais > 0 ? round(($nonConfirmes / $totalEssais) * 100) : 0,
        ];

        return view('demande_essai.produit-show', compact('produit', 'kpi'));
    }

  public function edit(DemandeEssai $demandeEssai)
{
    $demandeEssai->load(['demande', 'essai', 'laboratoire']);
    $produits = Produit::orderBy('created_at', 'desc')->get();
    $essais = Essai::orderBy('nom_essai')->get();
    $laboratoires = Laboratoire::where('is_active', true)->orderBy('nom')->get();

    /** @var User $user */
    $user = Auth::user();
    $laboratoireIds = $user->getLaboratoiresManagedIds();

    // Vérifier que l’utilisateur est autorisé
    if (!in_array($demandeEssai->laboratoire_id, $laboratoireIds)) {
        return back()->with('error', 'Vous n\'êtes pas autorisé à modifier cette assignation.');
    }

    // Si autorisé, afficher la vue
    return view('demande_essai.edit', compact('demandeEssai', 'produits', 'essais', 'laboratoires'));
}

public function update(Request $request, DemandeEssai $demandeEssai)
{
    /** @var User $user */
    $user = Auth::user();
    $laboratoireIds = $user->getLaboratoiresManagedIds();

    // Vérifier que l’utilisateur est autorisé
    if (!in_array($demandeEssai->laboratoire_id, $laboratoireIds)) {
        return back()->with('error', 'Vous n\'êtes pas autorisé à mettre à jour cette assignation.');
    }

    $essaiOption = $request->get('essai_option', 'existant');

    $rules = [
        'demande_id' => ['required', 'exists:produits,id'],
        'laboratoire_id' => ['required', 'exists:laboratoires,id'],
        'statut' => ['required', 'in:catalogué,non catalogué'],
        'description' => ['nullable', 'string', 'max:1000'],
        'informations_complementaires' => ['nullable', 'string', 'max:1000'],
        'echantillons' => ['nullable', 'string', 'max:255'],
    ];

    if ($essaiOption === 'existant') {
        $rules['essai_id'] = ['required', 'exists:essais,id'];
    } else {
        $rules['nouveau_essai_nom'] = ['required', 'string', 'max:255'];
        // ⚠️ pas besoin de demander le laboratoire, on prend celui du user
    }

    $validated = $request->validate($rules);

    // Si c'est un nouvel essai, le créer d'abord
    $essaiId = null;
    if ($essaiOption === 'nouveau') {
        $essai = Essai::create([
            'nom_essai'      => $validated['nouveau_essai_nom'],
            'laboratoire_id' => $user->getLaboratoiresManagedIds()[0] ?? null, // 🔑 premier labo du user
            'actif'          => true,
            'nouveau'        => true,
        ]);
        $essaiId = $essai->id;
    } else {
        $essaiId = $validated['essai_id'];
    }

    // Mettre à jour l'assignation
    $updateData = [
        'demande_id'                => $validated['demande_id'],
        'essai_id'                  => $essaiId,
        'laboratoire_id'            => $validated['laboratoire_id'],
        'statut'                    => $validated['statut'],
        'description'               => $validated['description'] ?? null,
        'informations_complementaires' => $validated['informations_complementaires'] ?? null,
        'echantillons'              => $validated['echantillons'] ?? null,
    ];

    $demandeEssai->update($updateData);

    return redirect()->route('demande_essai.index')
                     ->with('success', 'Assignation mise à jour avec succès.');
}



    /**
     * Supprimer l'assignation
     */
    public function destroy(DemandeEssai $demandeEssai)
{
    /** @var User $user */
    $user = Auth::user();
    $laboratoireIds = $user->getLaboratoiresManagedIds();

    // Vérifier que l’utilisateur est autorisé
    if (!in_array($demandeEssai->laboratoire_id, $laboratoireIds)) {
        return back()->with('error', 'Vous n\'êtes pas autorisé à supprimer cette assignation.');
    }

    $demandeEssai->delete();

    return redirect()->route('demande_essai.index')
                     ->with('success', 'Assignation supprimée avec succès.');
}


    /**
     * Clôturer un essai
     */
   public function cloture(DemandeEssai $demandeEssai)
{
    /** @var User $user */
    $user = Auth::user();
    $laboratoireIds = $user->getLaboratoiresManagedIds();

    // Vérifier que l’utilisateur est autorisé
    if (!in_array($demandeEssai->laboratoire_id, $laboratoireIds)) {
        return back()->with('error', 'Vous n\'êtes pas autorisé à clôturer cet essai.');
    }

    $demandeEssai->update(['cloture' => true]);

    return back()->with('success', 'Essai clôturé avec succès.');
}

}
