<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer un nouvel utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <!-- Nom d'utilisateur -->
                        <div class="mb-6">
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom d'utilisateur *
                            </label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" 
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('username') border-red-500 @enderror"
                                   required>
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email *
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-6">
                            <label for="mdp" class="block text-sm font-medium text-gray-700 mb-2">
                                Mot de passe (minimum 8 caractères) *
                            </label>
                            <input type="password" id="mdp" name="mdp"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('mdp') border-red-500 @enderror"
                                   required>
                            @error('mdp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmation du mot de passe -->
                        <div class="mb-6">
                            <label for="mdp_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmer le mot de passe *
                            </label>
                            <input type="password" id="mdp_confirmation" name="mdp_confirmation"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>

                        <!-- Rôle -->
                        <div class="mb-6">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                Rôle *
                            </label>
                            <select id="role" name="role"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-500 @enderror"
                                    required>
                                <option value="">-- Sélectionner un rôle --</option>
                                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Utilisateur</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                                <option value="root" {{ old('role') === 'root' ? 'selected' : '' }}>Root</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Laboratoires (si admin) -->
                        <div class="mb-6" id="laboratoires_section" style="display: none;">
                            <label for="laboratoires" class="block text-sm font-medium text-gray-700 mb-2">
                                Laboratoires responsables
                            </label>
                            <div class="space-y-2 border border-gray-300 rounded-md p-4">
                                @forelse($laboratoires as $labo)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="laboratoires[]" value="{{ $labo->id }}"
                                               class="rounded border-gray-300 text-blue-600 shadow-sm"
                                               {{ in_array($labo->id, old('laboratoires', [])) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">{{ $labo->nom }}</span>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-500">Aucun laboratoire disponible</p>
                                @endforelse
                            </div>
                            @error('laboratoires')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label for="is_active" class="ml-2 text-sm text-gray-700">
                                    Utilisateur actif
                                </label>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('users.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                Annuler
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Créer l'utilisateur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function() {
            const laboratoiresSection = document.getElementById('laboratoires_section');
            laboratoiresSection.style.display = this.value === 'admin' ? 'block' : 'none';
        });

        // Afficher la section si admin est déjà sélectionné (en cas de rechargement)
        if (document.getElementById('role').value === 'admin') {
            document.getElementById('laboratoires_section').style.display = 'block';
        }
    </script>
</x-app-layout>
