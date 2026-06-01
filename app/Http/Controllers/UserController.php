<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Laboratoire;
use App\Models\ResponsableLaboratoire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création d'utilisateur.
     */
    public function create()
    {
        $laboratoires = Laboratoire::where('is_active', true)->orderBy('nom')->get();
        return view('users.create', compact('laboratoires'));
    }

    /**
     * Stocker un nouvel utilisateur en base de données.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'mdp' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:user,admin,root'],
            'is_active' => ['sometimes', 'boolean'],
            'laboratoires' => ['sometimes', 'array'],
            'laboratoires.*' => ['exists:laboratoires,id'],
        ]);

        $validated['mdp'] = Hash::make($validated['mdp']);
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $user = User::create($validated);

        // Si l'utilisateur est admin et a des laboratoires sélectionnés
        if ($validated['role'] === 'admin' && !empty($validated['laboratoires'])) {
            foreach ($validated['laboratoires'] as $laboratoireId) {
                $user->laboratoiresResponsable()->create([
                    'laboratoire_id' => $laboratoireId,
                    'fonction' => 'Responsable',
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Afficher le formulaire d'édition d'utilisateur.
     */
    public function edit(User $user)
    {
        $laboratoires = Laboratoire::where('is_active', true)->orderBy('nom')->get();
        $userLaboratoires = $user->laboratoiresResponsable()->pluck('laboratoire_id')->toArray();
        return view('users.edit', compact('user', 'laboratoires', 'userLaboratoires'));
    }

    /**
     * Mettre à jour l'utilisateur en base de données.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'mdp' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:user,admin,root'],
            'is_active' => ['sometimes', 'boolean'],
            'laboratoires' => ['sometimes', 'array'],
            'laboratoires.*' => ['exists:laboratoires,id'],
        ]);

        if ($request->filled('mdp')) {
            $validated['mdp'] = Hash::make($validated['mdp']);
        } else {
            unset($validated['mdp']);
        }

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $oldRole = $user->role;

        $user->update($validated);

        // Gérer les laboratoires
        if ($validated['role'] === 'admin') {
            // Supprimer les anciens laboratoires
            $user->laboratoiresResponsable()->delete();

            // Ajouter les nouveaux
            if (!empty($validated['laboratoires'])) {
                foreach ($validated['laboratoires'] as $laboratoireId) {
                    $user->laboratoiresResponsable()->create([
                        'laboratoire_id' => $laboratoireId,
                        'fonction' => 'Responsable',
                    ]);
                }
            }
        } else {
            // Si on change le rôle de admin à user, supprimer les laboratoires
            if ($oldRole === 'admin') {
                $user->laboratoiresResponsable()->delete();
            }
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Supprimer l'utilisateur de la base de données.
     */
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
