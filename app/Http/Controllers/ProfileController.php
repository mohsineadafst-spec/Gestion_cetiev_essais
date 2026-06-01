<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Afficher le profil de l'utilisateur connecté
     */
    public function show(): View
    {
        return view('profile.show', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Afficher le formulaire d'édition du profil
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Mettre à jour le profil de l'utilisateur
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['nullable', 'string'],
            'mdp' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Vérifier le mot de passe actuel si une nouvelle est fournie
        if (!empty($validated['mdp'])) {
            if (empty($validated['current_password'])) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est requis pour changer le mot de passe.']);
            }

            if (!Hash::check($validated['current_password'], $user->mdp)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }

            $validated['mdp'] = Hash::make($validated['mdp']);
        } else {
            unset($validated['mdp']);
        }

        unset($validated['current_password']);

        $user->update($validated);

        return back()->with('status', 'Profil mis à jour avec succès.');
    }

    /**
     * Supprimer le compte de l'utilisateur
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'mdp' => ['required', 'string'],
        ]);

        $user = $request->user();

        // Vérifier le mot de passe
        if (!Hash::check($request->input('mdp'), $user->mdp)) {
            return back()->withErrors(['mdp' => 'Le mot de passe est incorrect.']);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Compte supprimé.');
    }
}

