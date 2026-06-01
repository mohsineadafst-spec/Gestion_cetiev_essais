<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la demande #') }} {{ $demande->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('demandes.update', $demande) }}">
                        @csrf
                        @method('PUT')

                        <!-- Client -->
                        <div class="mb-6">
                            <label for="client" class="block text-sm font-medium text-gray-700 mb-2">
                                Client *
                            </label>
                            <input type="text" id="client" name="client" value="{{ old('client', $demande->client) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('client') border-red-500 @enderror"
                                   required>
                            @error('client')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Contact *</label>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Nom du contact -->
                                <div>
                                    <label for="nom" class="block text-xs font-medium text-gray-600 mb-1">
                                        Nom du contact
                                    </label>
                                    <input type="text" id="nom" name="nom" value="{{ old('nom', $demande->nom) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('nom') border-red-500 @enderror"
                                           required>
                                    @error('nom')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Téléphone -->
                                <div>
                                    <label for="tel" class="block text-xs font-medium text-gray-600 mb-1">
                                        N° Téléphone
                                    </label>
                                    <input type="tel" id="tel" name="tel" value="{{ old('tel', $demande->tel) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('tel') border-red-500 @enderror">
                                    @error('tel')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="mail" class="block text-xs font-medium text-gray-600 mb-1">
                                        Adresse mail
                                    </label>
                                    <input type="email" id="mail" name="mail" value="{{ old('mail', $demande->mail) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('mail') border-red-500 @enderror">
                                    @error('mail')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Commentaires -->
                        <div class="mb-6">
                            <label for="commentaires" class="block text-sm font-medium text-gray-700 mb-2">
                                Commentaire
                            </label>
                            <textarea id="commentaires" name="commentaires" rows="4"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('commentaires') border-red-500 @enderror">{{ old('commentaires', $demande->commentaires) }}</textarea>
                            @error('commentaires')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <!-- Date réception demande -->
                            <div class="mb-6">
                                <label for="datereception" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date réception demande *
                                </label>
                                <input type="date" id="datereception" name="datereception" value="{{ old('datereception', $demande->datereception?->format('Y-m-d')) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('datereception') border-red-500 @enderror"
                                       required>
                                @error('datereception')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Délai prévu -->
                            <div class="mb-6">
                                <label for="delai_prev" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date prévue (délai en jours)
                                </label>
                                <input type="number" id="delai_prev" name="delai_prev" value="{{ old('delai_prev', $demande->delai_prev) }}" min="0"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('delai_prev') border-red-500 @enderror">
                                @error('delai_prev')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Laboratoire/Pôle -->
                        <div class="mb-6">
                            <label for="laboratoire" class="block text-sm font-medium text-gray-700 mb-2">
                                Sélectionner le pôle *
                            </label>
                            <select id="laboratoire" name="laboratoire"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('laboratoire') border-red-500 @enderror"
                                    required>
                                <option value="">-- Choisir un pôle --</option>
                                @foreach ($poles as $pole)
                                    <option value="{{ $pole }}" {{ old('laboratoire', $demande->laboratoire) === $pole ? 'selected' : '' }}>
                                        {{ $pole }}
                                    </option>
                                @endforeach
                            </select>
                            @error('laboratoire')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Faisabilité -->
                        <div class="mb-6">
                            <label for="faisable" class="block text-sm font-medium text-gray-700 mb-2">
                                Faisabilité
                            </label>
                            <select id="faisable" name="faisable"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('faisable') border-red-500 @enderror">
                                <option value="">-- Non défini --</option>
                                <option value="Oui" {{ old('faisable', $demande->faisable) === 'Oui' ? 'selected' : '' }}>Oui</option>
                                <option value="Non" {{ old('faisable', $demande->faisable) === 'Non' ? 'selected' : '' }}>Non</option>
                            </select>
                            @error('faisable')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Code rapport -->
                        <div class="mb-6">
                            <label for="code_rapport" class="block text-sm font-medium text-gray-700 mb-2">
                                Code rapport
                            </label>
                            <input type="text" id="code_rapport" name="code_rapport" value="{{ old('code_rapport', $demande->code_rapport) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('code_rapport') border-red-500 @enderror">
                            @error('code_rapport')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="mb-6">
                            <label for="cloture" class="block text-sm font-medium text-gray-700 mb-2">
                                Statut
                            </label>
                            <select id="cloture" name="cloture"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('cloture') border-red-500 @enderror">
                                <option value="En cours de traitement" {{ old('cloture', $demande->cloture) === 'En cours de traitement' ? 'selected' : '' }}>En cours de traitement</option>
                                <option value="Clos" {{ old('cloture', $demande->cloture) === 'Clos' ? 'selected' : '' }}>Clos</option>
                            </select>
                            @error('cloture')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">
                                <strong>Créé le :</strong> {{ $demande->created_at->format('d/m/Y à H:i') }}<br>
                                <strong>Modifié le :</strong> {{ $demande->updated_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>

                        <!-- Boutons -->
                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('demandes.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                Fermer
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
