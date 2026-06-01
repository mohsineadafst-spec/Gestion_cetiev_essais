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
    public function index()
    {
        $demandeEssais = Produit::with(['laboratoire', 'essais'])->paginate(9);
        return view('demande_essai.index', compact('demandeEssais'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create(Request $request)
    {
        $produits = Produit::orderBy('created_at', 'desc')->get();
        $essais = Essai::orderBy('nom_essai')->get();
        $laboratoires = Laboratoire::where('is_active', true)->orderBy('nom')->get();
        
        // Récupérer l'ID de la demande pré-sélectionnée si fourni
        $demandeIdPreselectionne = $request->query('demande_id');

        return view('demande_essai.create', compact('produits', 'essais', 'laboratoires', 'demandeIdPreselectionne'));
    }

    /**
     * Enregistrer une nouvelle assignation demande-essai
     */
    public function store(Request $request)
    {
        // Validation conditionnelle selon le type d'essai
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
            $rules['nouveau_essai_laboratoire'] = ['required', 'exists:laboratoires,id'];
        }

        $validated = $request->validate($rules);

        // Si c'est un nouvel essai, le créer d'abord
        $essaiId = null;
        if ($essaiOption === 'nouveau') {
            $essai = Essai::create([
                'nom_essai' => $validated['nouveau_essai_nom'],
                'laboratoire_id' => $validated['nouveau_essai_laboratoire'],
                'actif' => true,
                'nouveau' => true,
            ]);
            $essaiId = $essai->id;
        } else {
            $essaiId = $validated['essai_id'];
        }

        // Créer l'assignation demande-essai
        $assignationData = [
            'demande_id' => $validated['demande_id'],
            'essai_id' => $essaiId,
            'laboratoire_id' => $validated['laboratoire_id'],
            'statut' => $validated['statut'],
            'description' => $validated['description'] ?? null,
            'informations_complementaires' => $validated['informations_complementaires'] ?? null,
            'echantillons' => $validated['echantillons'] ?? null,
        ];

        DemandeEssai::create($assignationData);

        return redirect()->route('demande_essai.index')->with('success', 'Assignation créée avec succès.');
    }

    /**
     * Afficher une assignation (optionnel)
     */
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

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(DemandeEssai $demandeEssai)
    {
        $demandeEssai->load(['demande', 'essai', 'laboratoire']);
        $produits = Produit::orderBy('created_at', 'desc')->get();
        $essais = Essai::orderBy('nom_essai')->get();
        $laboratoires = Laboratoire::where('is_active', true)->orderBy('nom')->get();

        return view('demande_essai.edit', compact('demandeEssai', 'produits', 'essais', 'laboratoires'));
    }

    /**
     * Mettre à jour l'assignation
     */
    public function update(Request $request, DemandeEssai $demandeEssai)
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
            $rules['nouveau_essai_laboratoire'] = ['required', 'exists:laboratoires,id'];
        }

        $validated = $request->validate($rules);

        // Si c'est un nouvel essai, le créer d'abord
        $essaiId = null;
        if ($essaiOption === 'nouveau') {
            $essai = Essai::create([
                'nom_essai' => $validated['nouveau_essai_nom'],
                'laboratoire_id' => $validated['nouveau_essai_laboratoire'],
                'actif' => true,
                'nouveau' => true,
            ]);
            $essaiId = $essai->id;
        } else {
            $essaiId = $validated['essai_id'];
        }

        // Mettre à jour l'assignation
        $updateData = [
            'demande_id' => $validated['demande_id'],
            'essai_id' => $essaiId,
            'laboratoire_id' => $validated['laboratoire_id'],
            'statut' => $validated['statut'],
            'description' => $validated['description'] ?? null,
            'informations_complementaires' => $validated['informations_complementaires'] ?? null,
            'echantillons' => $validated['echantillons'] ?? null,
        ];

        $demandeEssai->update($updateData);

        return redirect()->route('demande_essai.index')->with('success', 'Assignation mise à jour avec succès.');
    }

    /**
     * Supprimer l'assignation
     */
    public function destroy(DemandeEssai $demandeEssai)
    {
        $demandeEssai->delete();
        return redirect()->route('demande_essai.index')->with('success', 'Assignation supprimée avec succès.');
    }

    /**
     * Clôturer un essai
     */
    public function cloture(DemandeEssai $demandeEssai)
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est responsable du laboratoire de cet essai
        if (!$user->manageLaboratoire($demandeEssai->laboratoire_id)) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à clôturer cet essai.');
        }

        $demandeEssai->update(['cloture' => true]);
        
        return back()->with('success', 'Essai clôturé avec succès.');
    }
}
