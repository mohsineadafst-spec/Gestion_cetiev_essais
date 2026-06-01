<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Affecter une essai à une demande') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" x-data="{ 
                    nouvelEssai: false,
                    essaiOption: '{{ old('essai_option', 'existant') }}'
                }">
                    <form method="POST" action="{{ route('demande_essai.store') }}">
                        @csrf

                        <!-- Demande (Produit) -->
                        <div class="mb-6">
                            <label for="demande_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Sélectionner une demande (Produit) *
                            </label>
                            <select id="demande_id" name="demande_id"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('demande_id') border-red-500 @enderror"
                                    required>
                                <option value="">-- Choisir une demande --</option>
                                @foreach ($produits as $produit)
                                    <option value="{{ $produit->id }}" {{ old('demande_id') == $produit->id ? 'selected' : '' }}>
                                        #{{ $produit->id }} - {{ $produit->client_name }} ({{ $produit->laboratoire->nom ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('demande_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Option: Essai existant ou nouveau -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <p class="text-sm font-medium text-gray-700 mb-3">Sélectionner ou créer un essai ?</p>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="essai_option" value="existant" 
                                           @change="essaiOption = 'existant'"
                                           {{ old('essai_option', 'existant') === 'existant' ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    <span class="ml-2 text-sm text-gray-700">Utiliser un essai existant</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="essai_option" value="nouveau" 
                                           @change="essaiOption = 'nouveau'"
                                           {{ old('essai_option') === 'nouveau' ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    <span class="ml-2 text-sm text-gray-700">Créer un nouvel essai</span>
                                </label>
                            </div>
                        </div>

                        <!-- Section: Essai Existant -->
                        <div x-show="essaiOption === 'existant'" class="mb-6 transition">
                            <label for="essai_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Sélectionner un essai *
                            </label>
                            <select id="essai_id" name="essai_id"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('essai_id') border-red-500 @enderror">
                                <option value="">-- Choisir un essai --</option>
                                @foreach ($essais as $essai)
                                    <option value="{{ $essai->id }}" {{ old('essai_id') == $essai->id ? 'selected' : '' }}>
                                        {{ $essai->nom_essai }}
                                    </option>
                                @endforeach
                            </select>
                            @error('essai_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Section: Nouvel Essai -->
                        <div x-show="essaiOption === 'nouveau'" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg transition">
                            <h3 class="text-sm font-medium text-gray-700 mb-4">Créer un nouvel essai</h3>
                            
                            <!-- Nom du nouvel essai -->
                            <div class="mb-4">
                                <label for="nouveau_essai_nom" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom de l'essai *
                                </label>
                                <input type="text" id="nouveau_essai_nom" name="nouveau_essai_nom" 
                                       value="{{ old('nouveau_essai_nom') }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('nouveau_essai_nom') border-red-500 @enderror"
                                       x-bind:required="essaiOption === 'nouveau'">
                                @error('nouveau_essai_nom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Laboratoire pour le nouvel essai -->
                            <div class="mb-4">
                                <label for="nouveau_essai_laboratoire" class="block text-sm font-medium text-gray-700 mb-2">
                                    Laboratoire associé *
                                </label>
                                <select id="nouveau_essai_laboratoire" name="nouveau_essai_laboratoire"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('nouveau_essai_laboratoire') border-red-500 @enderror"
                                        x-bind:required="essaiOption === 'nouveau'">
                                    <option value="">-- Choisir un laboratoire --</option>
                                    @foreach ($laboratoires as $labo)
                                        <option value="{{ $labo->id }}" {{ old('nouveau_essai_laboratoire') == $labo->id ? 'selected' : '' }}>
                                            {{ $labo->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nouveau_essai_laboratoire')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Laboratoire (Pôle) -->
                        <div class="mb-6">
                            <label for="laboratoire_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Affecter à un laboratoire (Pôle) *
                            </label>
                            <select id="laboratoire_id" name="laboratoire_id"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('laboratoire_id') border-red-500 @enderror"
                                    required>
                                <option value="">-- Choisir un laboratoire --</option>
                                @foreach ($laboratoires as $labo)
                                    <option value="{{ $labo->id }}" {{ old('laboratoire_id') == $labo->id ? 'selected' : '' }}>
                                        {{ $labo->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('laboratoire_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="mb-6">
                            <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                                Statut *
                            </label>
                            <select id="statut" name="statut"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('statut') border-red-500 @enderror"
                                    required>
                                <option value="catalogué" {{ old('statut') === 'catalogué' ? 'selected' : '' }}>Catalogué</option>
                                <option value="non catalogué" {{ old('statut') === 'non catalogué' ? 'selected' : '' }}>Non catalogué</option>
                            </select>
                            @error('statut')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="3"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Informations complémentaires -->
                        <div class="mb-6">
                            <label for="informations_complementaires" class="block text-sm font-medium text-gray-700 mb-2">
                                Informations complémentaires
                            </label>
                            <textarea id="informations_complementaires" name="informations_complementaires" rows="3"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('informations_complementaires') border-red-500 @enderror">{{ old('informations_complementaires') }}</textarea>
                            @error('informations_complementaires')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Échantillons -->
                        <div class="mb-6">
                            <label for="echantillons" class="block text-sm font-medium text-gray-700 mb-2">
                                Échantillons
                            </label>
                            <input type="text" id="echantillons" name="echantillons" value="{{ old('echantillons') }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('echantillons') border-red-500 @enderror">
                            @error('echantillons')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('demande_essai.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                Annuler
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Créer l'assignation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
