<?php

namespace App\Http\Controllers;

use App\Models\DemandeEssai;
use App\Models\Etude;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtudeController extends Controller
{
 


    /**
     * Afficher l'étude de faisabilité
     */
    public function show(DemandeEssai $demande)
    {
          
        // Vérifier que c'est une demande de type développement
        if ($demande->demande->type !== 'développement') {
            abort(403, 'Les études de faisabilité sont uniquement pour les demandes de type développement.');
        }

        // Vérifier que l'utilisateur est responsable du labo
        /** @var User $user */
        $user = Auth::user();
        if (!$user || !$user->manageLaboratoire($demande->laboratoire_id)) {
            abort(403, 'Vous n\'avez pas accès à cette étude.');
        }

        // Charger l'étude ou créer une nouvelle
        $etude = $demande->etude;
        
        return view('etudes.show', compact('demande', 'etude'));
    }

    /**
     * Afficher le formulaire de création d'étude
     */
    public function create(DemandeEssai $demande)
    {
        // Vérifier que c'est une demande de type développement
        if ($demande->demande->type !== 'développement') {
            abort(403, 'Les études de faisabilité sont uniquement pour les demandes de type développement.');
        }

        // Vérifier que l'utilisateur est responsable du labo
        /** @var User $user */
        $user = Auth::user();
        if (!$user || !$user->manageLaboratoire($demande->laboratoire_id)) {
            abort(403, 'Vous n\'avez pas accès à cette étude.');
        }

        // Vérifier qu'il n'existe pas déjà une étude
        if ($demande->etude) {
            return redirect()->route('etudes.show', $demande);
        }

        return view('etudes.create', compact('demande'));
    }

    /**
     * Stocker une nouvelle étude
     */
    public function store(Request $request, DemandeEssai $demande)
    {
        // Vérifier que c'est une demande de type développement
        if ($demande->demande->type !== 'développement') {
            abort(403, 'Les études de faisabilité sont uniquement pour les demandes de type développement.');
        }

        // Vérifier que l'utilisateur est responsable du labo
        /** @var User $user */
        $user = Auth::user();
        if (!$user || !$user->manageLaboratoire($demande->laboratoire_id)) {
            abort(403, 'Vous n\'avez pas accès à cette étude.');
        }

        $validated = $request->validate([
            'faisabilite' => ['required', 'in:faisable,non_faisable,a_confirmer'],
            'besoin_information' => ['nullable', 'string'],
            'motif_non_faisabilite' => ['nullable', 'string'],
            'raison' => ['nullable', 'string'],
            'norme_cdc' => ['nullable', 'string'],
            'besoin_sous_traitance' => ['sometimes', 'boolean'],
            'sous_traitant' => ['nullable', 'string'],
            'besoin_outillage' => ['sometimes', 'boolean'],
            'details_outillage' => ['nullable', 'string'],
            'besoin_heures_sup' => ['sometimes', 'boolean'],
            'nombre_heures_sup' => ['nullable', 'integer', 'min:0'],
            'personnes_concernees' => ['nullable', 'string'],
            'delai_previsionnel' => ['nullable', 'integer', 'min:0'],
            'conditions_particulieres' => ['nullable', 'string'],
        ]);

        $validated['demande_essai_id'] = $demande->id;
        $validated['responsable_id'] = $user->laboratoiresResponsable()
            ->where('laboratoire_id', $demande->laboratoire_id)
            ->first()
            ?->id;

        $etude = Etude::create($validated);

        return redirect()->route('etudes.show', $demande)
                        ->with('success', 'Étude de faisabilité créée avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(DemandeEssai $demande)
    {
        // Vérifier que c'est une demande de type développement
        if ($demande->demande->type !== 'développement') {
            abort(403, 'Les études de faisabilité sont uniquement pour les demandes de type développement.');
        }

        // Vérifier que l'utilisateur est responsable du labo
        /** @var User $user */
        $user = Auth::user();
        if (!$user || !$user->manageLaboratoire($demande->laboratoire_id)) {
            abort(403, 'Vous n\'avez pas accès à cette étude.');
        }

        $etude = $demande->etude;
        
        if (!$etude) {
            return redirect()->route('etudes.create', $demande);
        }

        return view('etudes.edit', compact('demande', 'etude'));
    }

    /**
     * Mettre à jour l'étude
     */
    public function update(Request $request, DemandeEssai $demande)
    {
        // Vérifier que c'est une demande de type développement
        if ($demande->demande->type !== 'développement') {
            abort(403, 'Les études de faisabilité sont uniquement pour les demandes de type développement.');
        }

        // Vérifier que l'utilisateur est responsable du labo
        /** @var User $user */
        $user = Auth::user();
        if (!$user || !$user->manageLaboratoire($demande->laboratoire_id)) {
            abort(403, 'Vous n\'avez pas accès à cette étude.');
        }

        $etude = $demande->etude;
        
        if (!$etude) {
            abort(404, 'Étude non trouvée.');
        }

        $validated = $request->validate([
            'faisabilite' => ['required', 'in:faisable,non_faisable,a_confirmer'],
            'besoin_information' => ['nullable', 'string'],
            'motif_non_faisabilite' => ['nullable', 'string'],
            'raison' => ['nullable', 'string'],
            'norme_cdc' => ['nullable', 'string'],
            'besoin_sous_traitance' => ['sometimes', 'boolean'],
            'sous_traitant' => ['nullable', 'string'],
            'besoin_outillage' => ['sometimes', 'boolean'],
            'details_outillage' => ['nullable', 'string'],
            'besoin_heures_sup' => ['sometimes', 'boolean'],
            'nombre_heures_sup' => ['nullable', 'integer', 'min:0'],
            'personnes_concernees' => ['nullable', 'string'],
            'delai_previsionnel' => ['nullable', 'integer', 'min:0'],
            'conditions_particulieres' => ['nullable', 'string'],
        ]);

        $etude->update($validated);

        return redirect()->route('etudes.show', $demande)
                        ->with('success', 'Étude de faisabilité mise à jour avec succès.');
    }
}
