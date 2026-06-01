<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvelle demande de rapport') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('produits.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-2 gap-6">
                            <!-- Client Name -->
                            <div class="mb-6">
                                <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Client *
                                </label>
                                <input type="text" id="client_name" name="client_name" value="{{ old('client_name') }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('client_name') border-red-500 @enderror"
                                       required>
                                @error('client_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Laboratoire -->
                            <div class="mb-6">
                                <label for="lab_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Laboratoire *
                                </label>
                                <select id="lab_id" name="lab_id"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('lab_id') border-red-500 @enderror"
                                        required>
                                    <option value="">-- Sélectionner un laboratoire --</option>
                                    @foreach ($laboratoires as $labo)
                                        <option value="{{ $labo->id }}" {{ old('lab_id') == $labo->id ? 'selected' : '' }}>
                                            {{ $labo->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lab_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <!-- Date réception -->
                            <div class="mb-6">
                                <label for="date_reception" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date réception *
                                </label>
                                <input type="date" id="date_reception" name="date_reception" value="{{ old('date_reception') }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('date_reception') border-red-500 @enderror"
                                       required>
                                @error('date_reception')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date prévue -->
                            <div class="mb-6">
                                <label for="date_prevue" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date prévue
                                </label>
                                <input type="date" id="date_prevue" name="date_prevue" value="{{ old('date_prevue') }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('date_prevue') border-red-500 @enderror">
                                @error('date_prevue')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <!-- Quantité d'échantillon -->
                            <div class="mb-6">
                                <label for="quantite" class="block text-sm font-medium text-gray-700 mb-2">
                                    Quantité d'échantillon *
                                </label>
                                <input type="number" id="quantite" name="quantite" value="{{ old('quantite', 1) }}" min="0"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('quantite') border-red-500 @enderror"
                                       required>
                                @error('quantite')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Marque -->
                            <div class="mb-6">
                                <label for="marque" class="block text-sm font-medium text-gray-700 mb-2">
                                    Marque
                                </label>
                                <input type="text" id="marque" name="marque" value="{{ old('marque') }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('marque') border-red-500 @enderror">
                                @error('marque')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <!-- Montant TTC -->
                            <div class="mb-6">
                                <label for="montant_ttc" class="block text-sm font-medium text-gray-700 mb-2">
                                    Montant TTC (DH)
                                </label>
                                <input type="number" id="montant_ttc" name="montant_ttc" value="{{ old('montant_ttc') }}" step="0.01" min="0"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('montant_ttc') border-red-500 @enderror">
                                @error('montant_ttc')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                             <!-- type demande -->
                            <div class="mb-6">
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Type de demande *
                                </label>
                                <select id="type" name="type"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('type') border-red-500 @enderror"
                                        required>
                                    <option value="réglementaire" {{ old('type') === 'réglementaire' ? 'selected' : '' }}>Réglementaire</option>
                                    <option value="développement" {{ old('type') === 'développement' ? 'selected' : '' }}>Développement</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                                    
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Statut Paiement -->
                            <div class="mb-6">
                                <label for="statut_paiement" class="block text-sm font-medium text-gray-700 mb-2">
                                    Statut paiement *
                                </label>
                                <select id="statut_paiement" name="statut_paiement"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('statut_paiement') border-red-500 @enderror"
                                        required>
                                    <option value="pending" {{ old('statut_paiement') === 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="paid" {{ old('statut_paiement') === 'paid' ? 'selected' : '' }}>Payé</option>
                                    <option value="cancelled" {{ old('statut_paiement') === 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                </select>
                                @error('statut_paiement')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <!-- Statut -->
                            <div class="mb-6">
                                <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                                    Statut *
                                </label>
                                <select id="statut" name="statut"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('statut') border-red-500 @enderror"
                                        required>
                                    <option value="todo" {{ old('statut') === 'todo' ? 'selected' : '' }}>À faire</option>
                                    <option value="in_progress" {{ old('statut') === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                    <option value="done" {{ old('statut') === 'done' ? 'selected' : '' }}>Fait</option>
                                    <option value="cancelled" {{ old('statut') === 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                </select>
                                @error('statut')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Résultat -->
                            <div class="mb-6">
                                <label for="resultat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Résultat
                                </label>
                                <select id="resultat" name="resultat"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('resultat') border-red-500 @enderror">
                                    <option value="">-- Aucun --</option>
                                    <option value="conforme" {{ old('resultat') === 'conforme' ? 'selected' : '' }}>Conforme</option>
                                    <option value="non_conforme" {{ old('resultat') === 'non_conforme' ? 'selected' : '' }}>Non conforme</option>
                                    <option value="partiel" {{ old('resultat') === 'partiel' ? 'selected' : '' }}>Partiel</option>
                                </select>
                                @error('resultat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Notes (Type d'échantillon, adresse, etc.)
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Joindre un rapport/fichier -->
                        <div class="mb-6">
                            <label for="rapport" class="block text-sm font-medium text-gray-700 mb-2">
                                Joindre un rapport (PDF, Image, Document)
                            </label>
                            <input type="file" id="rapport" name="rapport" accept=".pdf,.jpg,.jpeg,.png,.docx"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('rapport') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Formats acceptés: PDF, JPG, PNG, DOCX (Max: 5 Mo)</p>
                            @error('rapport')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Details -->
                        <div class="mb-6">
                            <label for="details" class="block text-sm font-medium text-gray-700 mb-2">
                                Détails supplémentaires
                            </label>
                            <textarea id="details" name="details" rows="3"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('details') border-red-500 @enderror">{{ old('details') }}</textarea>
                            @error('details')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('produits.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                Annuler
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Créer la demande
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
