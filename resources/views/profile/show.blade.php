<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow">
            <!-- Profile Header -->
            <div class="px-6 py-8 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-600 text-white text-2xl font-bold">
                            {{ strtoupper(substr($user->username ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $user->username }}</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                {{ ucfirst($user->role) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom d'utilisateur -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nom d'utilisateur
                        </label>
                        <p class="text-base text-gray-900 font-semibold">{{ $user->username }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <p class="text-base text-gray-900 font-semibold">{{ $user->email }}</p>
                    </div>

                    <!-- Rôle -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Rôle
                        </label>
                        <p class="text-base text-gray-900 font-semibold capitalize">{{ $user->role }}</p>
                    </div>

                    <!-- Statut -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Statut
                        </label>
                        <div class="flex items-center">
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                    </div>

                    <!-- Date de création -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Compte créé le
                        </label>
                        <p class="text-base text-gray-900 font-semibold">{{ $user->created_at->format('d/m/Y à H:i') }}</p>
                    </div>

                    <!-- Dernière connexion -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Dernière connexion
                        </label>
                        <p class="text-base text-gray-900 font-semibold">
                            {{ $user->last_login ? $user->last_login->format('d/m/Y à H:i') : 'Jamais' }}
                        </p>
                    </div>
                </div>

                <!-- Laboratoires gérés (si applicable) -->
                @if($user->laboratoiresResponsable->count() > 0)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Laboratoires gérés
                        </h3>
                        <div class="space-y-3">
                            @foreach($user->laboratoiresResponsable as $responsable)
                                <div class="flex items-center justify-between bg-blue-50 rounded-lg p-4 border border-blue-200">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $responsable->laboratoire->nom }}</p>
                                        @if($responsable->fonction)
                                            <p class="text-sm text-gray-600 mt-1">{{ $responsable->fonction }}</p>
                                        @endif
                                    </div>
                                    
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 border-t border-gray-200 flex justify-between gap-3">
                <!-- Edit Button -->
                <a href="{{ route('profile.edit') }}"
                    class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Éditer le profil
                </a>

                <!-- Delete Button -->
                <button type="button"
                    @click="deleteAccountModal = true"
                    class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer le compte
                </button>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('dashboard.index') }}"
                class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold">
                ← Retour au tableau de bord
            </a>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div x-data="{ deleteAccountModal: false }" class="relative z-50">
    <div x-show="deleteAccountModal"
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        @click="deleteAccountModal = false"></div>

    <div x-show="deleteAccountModal"
        class="fixed inset-0 flex items-center justify-center p-4"
        style="display: none;">

        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6"
            @click.stop>

            <h3 class="text-lg font-bold text-gray-900 mb-2">
                Supprimer votre compte ?
            </h3>

            <p class="text-gray-600 mb-6">
                Cette action est irréversible. Tous vos données seront supprimées définitivement.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('DELETE')

                <!-- Password Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Entrez votre mot de passe pour confirmer
                    </label>
                    <input type="password"
                        name="mdp"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent"
                        placeholder="Mot de passe">
                    @error('mdp')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3">
                    <button type="button"
                        @click="deleteAccountModal = false"
                        class="px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                        Annuler
                    </button>

                    <button type="submit"
                        class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 transition-colors">
                        Supprimer le compte
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</x-app-layout>
