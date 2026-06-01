<?php

namespace App\Http\Controllers;

use App\Models\Laboratoire;
use App\Models\User;
use Illuminate\Http\Request;

class LaboratoireController extends Controller
{
    /**
     * Afficher la liste des laboratoires.
     */
    public function index()
    {
        $laboratoires = Laboratoire::with('responsable')->orderBy('created_at', 'desc')->paginate(10);
        return view('laboratoires.index', compact('laboratoires'));
    }

    /**
     * Afficher le formulaire de création de laboratoire.
     */
    public function create()
    {
        $users = User::orderBy('username')->get();
        return view('laboratoires.create', compact('users'));
    }

    /**
     * Stocker un nouveau laboratoire en base de données.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:laboratoires,nom'],
            'email_principal' => ['nullable', 'string', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'responsable_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $laboratoire = Laboratoire::create($validated);

        // Si un responsable est assigné, l'ajouter à la table responsables_laboratoires
        if ($validated['responsable_id']) {
            $laboratoire->responsables()->create([
                'user_id' => $validated['responsable_id'],
                'fonction' => 'Responsable Principal',
            ]);
        }

        return redirect()->route('laboratoires.index')->with('success', 'Laboratoire créé avec succès.');
    }

    /**
     * Afficher le formulaire d'édition de laboratoire.
     */
    public function edit(Laboratoire $laboratoire)
    {
        $users = User::orderBy('username')->get();
        return view('laboratoires.edit', compact('laboratoire', 'users'));
    }

    /**
     * Mettre à jour le laboratoire en base de données.
     */
    public function update(Request $request, Laboratoire $laboratoire)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:laboratoires,nom,' . $laboratoire->id],
            'email_principal' => ['nullable', 'string', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'responsable_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $oldResponsableId = $laboratoire->responsable_id;

        $laboratoire->update($validated);

        // Si le responsable a changé
        if ($validated['responsable_id'] !== $oldResponsableId) {
            // Supprimer l'ancien responsable principal de la table pivot
            if ($oldResponsableId) {
                $laboratoire->responsables()
                    ->where('user_id', $oldResponsableId)
                    ->where('fonction', 'Responsable Principal')
                    ->delete();
            }

            // Ajouter le nouveau responsable
            if ($validated['responsable_id']) {
                $laboratoire->responsables()->create([
                    'user_id' => $validated['responsable_id'],
                    'fonction' => 'Responsable Principal',
                ]);
            }
        }

        return redirect()->route('laboratoires.index')->with('success', 'Laboratoire modifié avec succès.');
    }

    /**
     * Supprimer le laboratoire de la base de données.
     */
    public function destroy(Laboratoire $laboratoire)
    {
        $laboratoire->delete();

        return redirect()->route('laboratoires.index')->with('success', 'Laboratoire supprimé avec succès.');
    }
}
