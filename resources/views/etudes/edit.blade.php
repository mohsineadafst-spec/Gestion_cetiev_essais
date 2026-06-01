<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-2.5 mb-0.5">
                    <a href="{{ route('etudes.show', $demande) }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <span class="text-gray-300">/</span>
                    <span class="text-sm text-gray-400">Études</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Modifier l'étude de faisabilité</h2>
                <p class="text-sm text-gray-400 mt-0.5">{{ $demande->essai->nom_essai }} - {{ $demande->laboratoire->nom }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/60">
                    <h3 class="text-sm font-bold text-gray-800">Modifiez les informations</h3>
                    <p class="text-xs text-gray-400 mt-1">Mettez à jour les données de l'étude de faisabilité</p>
                </div>

                <form method="POST" action="{{ route('etudes.update', $demande) }}" class="p-8 space-y-6" x-data="{ faisabilite: '{{ old('faisabilite', $etude->faisabilite) }}', besoin_sous_traitance: {{ old('besoin_sous_traitance', $etude->besoin_sous_traitance) ? 'true' : 'false' }}, besoin_outillage: {{ old('besoin_outillage', $etude->besoin_outillage) ? 'true' : 'false' }}, besoin_heures_sup: {{ old('besoin_heures_sup', $etude->besoin_heures_sup) ? 'true' : 'false' }} }">
                    @csrf
                    @method('PUT')

                    {{-- Faisabilité --}}
                    <div>
                        <label for="faisabilite" class="block text-sm font-bold text-gray-700 mb-2">Faisabilité <span class="text-red-500">*</span></label>
                        <select id="faisabilite" name="faisabilite" required x-model="faisabilite" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('faisabilite') border-red-500 @enderror">
                            <option value="">-- Sélectionner --</option>
                            <option value="faisable">Faisable</option>
                            <option value="non_faisable">Non faisable</option>
                            <option value="a_confirmer">À confirmer</option>
                        </select>
                        @error('faisabilite')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Motif de non faisabilité (si non_faisable) --}}
                    <div x-show="faisabilite === 'non_faisable'" class="space-y-4 p-4 bg-rose-50 rounded-lg border border-rose-100">
                        <div>
                            <label for="motif_non_faisabilite" class="block text-sm font-bold text-gray-700 mb-2">Motif de non faisabilité</label>
                            <textarea id="motif_non_faisabilite" name="motif_non_faisabilite" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent transition resize-none @error('motif_non_faisabilite') border-red-500 @enderror" placeholder="Expliquez pourquoi cet essai n'est pas faisable...">{{ old('motif_non_faisabilite', $etude->motif_non_faisabilite) }}</textarea>
                            @error('motif_non_faisabilite')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="raison" class="block text-sm font-bold text-gray-700 mb-2">Raison</label>
                            <input type="text" id="raison" name="raison" placeholder="Ex: Pas d'équipement disponible, Expertise manquante..." class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent transition @error('raison') border-red-500 @enderror" value="{{ old('raison', $etude->raison) }}">
                            @error('raison')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Besoin d'information --}}
                    <div>
                        <label for="besoin_information" class="block text-sm font-bold text-gray-700 mb-2">Besoin d'information supplémentaire</label>
                        <textarea id="besoin_information" name="besoin_information" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none @error('besoin_information') border-red-500 @enderror">{{ old('besoin_information', $etude->besoin_information) }}</textarea>
                        @error('besoin_information')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Norme / CDC --}}
                    <div>
                        <label for="norme_cdc" class="block text-sm font-bold text-gray-700 mb-2">Norme / Cahier des charges</label>
                        <input type="text" id="norme_cdc" name="norme_cdc" placeholder="Ex: ISO 9001, NF EN 12345..." class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('norme_cdc') border-red-500 @enderror" value="{{ old('norme_cdc', $etude->norme_cdc) }}">
                        @error('norme_cdc')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Besoins (Checkboxes) --}}
                    <div class="bg-gray-50 rounded-lg p-5 space-y-4">
                        <p class="text-sm font-bold text-gray-700 mb-3">Besoins spécifiques</p>
                        
                        {{-- Besoin de sous-traitance --}}
                        <div>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="besoin_sous_traitance" value="1" x-model="besoin_sous_traitance" {{ old('besoin_sous_traitance', $etude->besoin_sous_traitance) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">Besoin de sous-traitance d'essai(s)</span>
                            </label>
                            <div x-show="besoin_sous_traitance" class="mt-3 ml-7">
                                <input type="text" id="sous_traitant" name="sous_traitant" placeholder="Spécifier le sous-traitant..." class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm transition @error('sous_traitant') border-red-500 @enderror" value="{{ old('sous_traitant', $etude->sous_traitant) }}">
                                @error('sous_traitant')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Besoin d'outillage --}}
                        <div>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="besoin_outillage" value="1" x-model="besoin_outillage" {{ old('besoin_outillage', $etude->besoin_outillage) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">Besoin de Montage(s)/Outillage(s) spécifique(s)</span>
                            </label>
                            <div x-show="besoin_outillage" class="mt-3 ml-7">
                                <textarea id="details_outillage" name="details_outillage" rows="3" placeholder="Détails du montage/outillage requis..." class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm transition resize-none @error('details_outillage') border-red-500 @enderror">{{ old('details_outillage', $etude->details_outillage) }}</textarea>
                                @error('details_outillage')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Besoin d'heures supplémentaires --}}
                        <div>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="besoin_heures_sup" value="1" x-model="besoin_heures_sup" {{ old('besoin_heures_sup', $etude->besoin_heures_sup) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">Besoin d'heures supplémentaires</span>
                            </label>
                            <div x-show="besoin_heures_sup" class="mt-3 ml-7 space-y-3">
                                <div>
                                    <label for="nombre_heures_sup" class="block text-xs font-semibold text-gray-600 mb-1">Nombre d'heures supplémentaires</label>
                                    <input type="number" id="nombre_heures_sup" name="nombre_heures_sup" min="0" placeholder="Ex: 8" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm transition @error('nombre_heures_sup') border-red-500 @enderror" value="{{ old('nombre_heures_sup', $etude->nombre_heures_sup) }}">
                                    @error('nombre_heures_sup')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="personnes_concernees" class="block text-xs font-semibold text-gray-600 mb-1">Personnes concernées</label>
                                    <input type="text" id="personnes_concernees" name="personnes_concernees" placeholder="Ex: Technicien A, Technicien B..." class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm transition @error('personnes_concernees') border-red-500 @enderror" value="{{ old('personnes_concernees', $etude->personnes_concernees) }}">
                                    @error('personnes_concernees')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Délai previsionnel --}}
                    <div>
                        <label for="delai_previsionnel" class="block text-sm font-bold text-gray-700 mb-2">Délai prévisionnel (jours)</label>
                        <input type="number" id="delai_previsionnel" name="delai_previsionnel" min="0" placeholder="Ex: 15" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('delai_previsionnel') border-red-500 @enderror" value="{{ old('delai_previsionnel', $etude->delai_previsionnel) }}">
                        @error('delai_previsionnel')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Conditions particulières --}}
                    <div>
                        <label for="conditions_particulieres" class="block text-sm font-bold text-gray-700 mb-2">Conditions particulières</label>
                        <textarea id="conditions_particulieres" name="conditions_particulieres" rows="4" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none @error('conditions_particulieres') border-red-500 @enderror" placeholder="Conditions particulières de réalisation de l'essai...">{{ old('conditions_particulieres', $etude->conditions_particulieres) }}</textarea>
                        @error('conditions_particulieres')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <a href="{{ route('etudes.show', $demande) }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition text-sm font-medium">
                            Annuler
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 active:scale-95 transition-all duration-150">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
