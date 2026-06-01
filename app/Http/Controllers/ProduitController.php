<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Produit;
use App\Models\Laboratoire;
use App\Models\User;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Afficher la liste des produits/rapports.
     */
    public function index()
    {
        $produits = Produit::with(['laboratoire', 'createdBy'])->orderBy('date_reception', 'desc')->paginate(10);
        return view('produits.index', compact('produits'));
    }

    /**
     * Afficher le formulaire de création de produit.
     */
    public function create()
    {
        $laboratoires = Laboratoire::where('is_active', true)->orderBy('nom')->get();
        return view('produits.create', compact('laboratoires'));
    }

    /**
     * Stocker un nouveau produit en base de données.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'lab_id' => ['required', 'exists:laboratoires,id'],
            'date_reception' => ['required', 'date'],
            'date_prevue' => ['nullable', 'date'],
            'type' => ['required', 'string', 'in:réglementaire,développement'],
            'marque' => ['nullable', 'string', 'max:255'],
            'quantite' => ['required', 'integer', 'min:0'],
            'montant_ttc' => ['nullable', 'numeric', 'min:0'],
            'statut' => ['required', 'in:todo,in_progress,done,cancelled'],
            'statut_paiement' => ['required', 'in:pending,paid,cancelled'],
            'resultat' => ['nullable', 'in:conforme,non_conforme,partiel'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'details' => ['nullable', 'string', 'max:1000'],
            'rapport' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,docx', 'max:5120'],
        ]);

        // Ajout des infos d'audit
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        // Upload du fichier si présent
        if ($request->hasFile('rapport')) {
            $file = $request->file('rapport');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('build/assets'), $filename);
            $validated['url_rapport'] = asset('build/assets/' . $filename);
        }

        Produit::create($validated);

        return redirect()->route('produits.index')->with('success', 'Demande créée avec succès.');
    }


    /**
     * Afficher le formulaire d'édition de produit.
     */
    public function edit(Produit $produit)
    {
        $laboratoires = Laboratoire::where('is_active', true)->orderBy('nom')->get();
        return view('produits.edit', compact('produit', 'laboratoires'));
    }

    /**
     * Mettre à jour le produit en base de données.
     */
    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'lab_id' => ['required', 'exists:laboratoires,id'],
            'date_reception' => ['required', 'date'],
            'date_prevue' => ['nullable', 'date'],
            'type' => ['required', 'string', 'in:réglementaire,développement'],
            'marque' => ['nullable', 'string', 'max:255'],
            'quantite' => ['required', 'integer', 'min:0'],
            'montant_ttc' => ['nullable', 'numeric', 'min:0'],
            'statut' => ['required', 'in:todo,in_progress,done,cancelled'],
            'statut_paiement' => ['required', 'in:pending,paid,cancelled'],
            'resultat' => ['nullable', 'in:conforme,non_conforme,partiel'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'details' => ['nullable', 'string', 'max:1000'],
            'rapport' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,docx', 'max:5120'],
        ]);

        $validated['updated_by'] = Auth::id();

        // Upload du nouveau fichier si présent
        if ($request->hasFile('rapport')) {
            // Supprimer l'ancien fichier si exists
            if ($produit->url_rapport && file_exists(public_path(str_replace(asset(''), '', $produit->url_rapport)))) {
                @unlink(public_path(str_replace(asset(''), '', $produit->url_rapport)));
            }
            
            $file = $request->file('rapport');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('build/assets'), $filename);
            $validated['url_rapport'] = asset('build/assets/' . $filename);
        }

        $produit->update($validated);

        return redirect()->route('produits.index')->with('success', 'Demande modifiée avec succès.');
    }

    /**
     * Supprimer le produit de la base de données.
     */
    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Demande supprimée avec succès.');
    }
}
