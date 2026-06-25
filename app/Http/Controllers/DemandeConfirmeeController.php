<?php

namespace App\Http\Controllers;

use App\Models\DemandeConfirmee;
use App\Models\Produit;
use App\Models\Laboratoire;
use App\Models\DemandeEssai;
use Illuminate\Http\Request;

class DemandeConfirmeeController extends Controller
{
    public function index()
    {
        $demandesConfirmees = DemandeConfirmee::with(['laboratoire', 'produit'])->paginate(10);
        return view('demandes_confirmees.index', compact('demandesConfirmees'));
    }

public function selectProduit(Request $request)
{
    $query = Produit::where('statut', 'done')->with('laboratoire');

    // Si un ID est fourni en recherche
    if ($request->filled('produit_id')) {
        $query->where('id', $request->produit_id);
    }

    $produits = $query->orderBy('created_at', 'desc')->get();

    return view('demandes_confirmees.select_produit', compact('produits'));
}


public function create(Request $request)
{
    $produit = null;
    if ($request->has('produit_id')) {
        $produit = Produit::with('laboratoire')->findOrFail($request->produit_id);
    }

    return view('demandes_confirmees.create', compact('produit'));
}



 public function store(Request $request)
{
    $validated = $request->validate([
        'produit_id'        => ['required', 'exists:produits,id'],
        'numero_bc'         => ['required', 'string', 'max:255'],
        'date_reception_bc' => ['required', 'date'],
        'date_reception_échantillons' => ['required', 'date'],
        'confirmation'      => ['required', 'in:oui,non'],
        'code_rapport'      => ['required', 'string', 'max:255'],
    ]);

    // Charger le produit choisi
    $produit = Produit::findOrFail($validated['produit_id']);

    // Créer la demande confirmée en copiant les infos du produit
    DemandeConfirmee::create([
        'produit_id'        => $produit->id,
        'client'            => $produit->client_name,   // ✅ utiliser client_name
         'laboratoire_id'    => $produit->lab_id, // ✅ utiliser laboratoire_id 
        'date_reception_échantillons' => $validated['date_reception_échantillons'],
        'numero_bc'         => $validated['numero_bc'],
        'date_reception_bc' => $validated['date_reception_bc'],
        'confirmation'      => $validated['confirmation'],
        'code_rapport'      => $validated['code_rapport'],
    ]);

    return redirect()->route('demandes_confirmees.index')
                     ->with('success', 'Demande confirmée créée avec succès.');
}


    public function show(DemandeConfirmee $demandesConfirmee)
    {
        $demandesConfirmee->load(['laboratoire', 'produit', 'demandeEssai.essai', 'demandeEssai.demande']);
        return view('demandes_confirmees.show', compact('demandesConfirmee'));
    }

   public function edit(DemandeConfirmee $demandesConfirmee)
{
    $demandesConfirmee->load(['laboratoire', 'produit']);

    // Produits avec statut = done
    $demandesEssaiCloturees = Produit::where('statut', 'done')
        ->with(['laboratoire'])
        ->orderBy('created_at', 'desc')
        ->get();

    return view('demandes_confirmees.edit', compact('demandesConfirmee', 'demandesEssaiCloturees'));
}


 public function update(Request $request, DemandeConfirmee $demandesConfirmee)
{
    $validated = $request->validate([
        'produit_id'                  => ['required', 'exists:produits,id'],
        'numero_bc'                   => ['required', 'string', 'max:255'],
        'date_reception_bc'           => ['required', 'date'],
        'date_reception_échantillons' => ['required', 'date'],
        'confirmation'                => ['required', 'in:oui,non'],
        'code_rapport'                => ['required', 'string', 'max:255'],
    ]);

    $produit = Produit::findOrFail($validated['produit_id']);

    $demandesConfirmee->update([
        'produit_id'                  => $produit->id,
        'client'                      => $produit->client_name,
        'date_reception'              => $produit->date_reception,
        'laboratoire_id'              => $produit->lab_id, // ✅ récupéré du produit
        'numero_bc'                   => $validated['numero_bc'],
        'date_reception_bc'           => $validated['date_reception_bc'],
        'date_reception_échantillons' => $validated['date_reception_échantillons'],
        'confirmation'                => $validated['confirmation'],
        'code_rapport'                => $validated['code_rapport'],
    ]);

    return redirect()->route('demandes_confirmees.index')
                     ->with('success', 'Demande confirmée mise à jour avec succès.');
}




    public function destroy(DemandeConfirmee $demandesConfirmee)
    {
        $demandesConfirmee->delete();
        return redirect()->route('demandes_confirmees.index')->with('success', 'Demande confirmée supprimée avec succès.');
    }
}
