<?php

namespace App\Http\Controllers;

use App\Models\DemandeConfirmee;
use App\Models\DemandeEssai;
use App\Models\Laboratoire;
use Illuminate\Http\Request;

class DemandeConfirmeeController extends Controller
{
    /**
     * Afficher la liste des demandes confirmées
     */
    public function index()
    {
        $demandesConfirmees = DemandeConfirmee::with(['laboratoire', 'demandeEssai.essai'])->paginate(10);
        return view('demandes_confirmees.index', compact('demandesConfirmees'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $demandesEssaiCloturees = DemandeEssai::with(['demande', 'essai', 'laboratoire'])
            ->where('cloture', true)
            ->orderBy('created_at', 'desc')
            ->get();
        $laboratoires = Laboratoire::where('is_active', true)->orderBy('nom')->get();
        return view('demandes_confirmees.create', compact('demandesEssaiCloturees', 'laboratoires'));
    }

    /**
     * Enregistrer une nouvelle demande confirmée
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'demande_essai_id' => ['required', 'exists:demande_essai,id'],
            'client' => ['required', 'string', 'max:255'],
            'date_reception' => ['required', 'date'],
            'numero_bc' => ['required', 'string', 'max:255'],
            'date_reception_bc' => ['required', 'date'],
            'laboratoire_id' => ['required', 'exists:laboratoires,id'],
            'confirmation' => ['required', 'in:oui,non'],
            'code_rapport' => ['required', 'string', 'max:255'],
        ]);

        DemandeConfirmee::create($validated);

        return redirect()->route('demandes_confirmees.index')->with('success', 'Demande confirmée créée avec succès.');
    }

    /**
     * Afficher une demande confirmée
     */
    public function show(DemandeConfirmee $demandesConfirmee)
    {
        $demandesConfirmee->load(['laboratoire', 'demandeEssai.essai', 'demandeEssai.demande']);
        return view('demandes_confirmees.show', compact('demandesConfirmee'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(DemandeConfirmee $demandesConfirmee)
    {
        $demandesConfirmee->load(['laboratoire', 'demandeEssai']);
        $demandesEssaiCloturees = DemandeEssai::with(['demande', 'essai', 'laboratoire'])
            ->where('cloture', true)
            ->orderBy('created_at', 'desc')
            ->get();
        $laboratoires = Laboratoire::where('is_active', true)->orderBy('nom')->get();
        return view('demandes_confirmees.edit', compact('demandesConfirmee', 'demandesEssaiCloturees', 'laboratoires'));
    }

    /**
     * Mettre à jour une demande confirmée
     */
    public function update(Request $request, DemandeConfirmee $demandesConfirmee)
    {
        $validated = $request->validate([
            'demande_essai_id' => ['required', 'exists:demande_essai,id'],
            'client' => ['required', 'string', 'max:255'],
            'date_reception' => ['required', 'date'],
            'numero_bc' => ['required', 'string', 'max:255'],
            'date_reception_bc' => ['required', 'date'],
            'laboratoire_id' => ['required', 'exists:laboratoires,id'],
            'confirmation' => ['required', 'in:oui,non'],
            'code_rapport' => ['required', 'string', 'max:255'],
        ]);

        $demandesConfirmee->update($validated);

        return redirect()->route('demandes_confirmees.index')->with('success', 'Demande confirmée mise à jour avec succès.');
    }

    /**
     * Supprimer une demande confirmée
     */
    public function destroy(DemandeConfirmee $demandesConfirmee)
    {
        $demandesConfirmee->delete();
        return redirect()->route('demandes_confirmees.index')->with('success', 'Demande confirmée supprimée avec succès.');
    }
}
