<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-2.5 mb-0.5">
                    <a href="{{ route('demande_essai.produit.show', $demande->demande_id) }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <span class="text-gray-300">/</span>
                    <span class="text-sm text-gray-400">Études</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-3">
                    Étude de faisabilité
                    <span class="text-lg font-mono font-semibold text-violet-600 bg-violet-50 px-2.5 py-0.5 rounded-lg">#{{ $demande->essai->nom_essai }}</span>
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">{{ $demande->demande->client_name }} - {{ $demande->laboratoire->nom }}</p>
            </div>
            <div class="card">
   
</div>

            
            @if($etude)
                <a href="{{ route('etudes.edit', $demande) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-150 shadow-md shadow-indigo-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
            @else
                <a href="{{ route('etudes.create', $demande) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-150 shadow-md shadow-indigo-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Créer l'étude
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($etude)
                {{-- Affichage de l'étude existante --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                    {{-- Faisabilité --}}
                    <div class="px-8 py-6 border-b border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-2">Faisabilité</p>
                        <div class="flex items-center gap-3">
                            @php
                                $faisabiliteClass = match($etude->faisabilite) {
                                    'faisable' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                    'non_faisable' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                                    'a_confirmer' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                    default => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200',
                                };
                                $faisabiliteLabel = match($etude->faisabilite) {
                                    'faisable' => 'Faisable',
                                    'non_faisable' => 'Non faisable',
                                    'a_confirmer' => 'À confirmer',
                                    default => ucfirst($etude->faisabilite),
                                };
                            @endphp
                            <span class="inline-flex px-4 py-2 rounded-full text-sm font-semibold {{ $faisabiliteClass }}">
                                {{ $faisabiliteLabel }}
                            </span>
                        </div>
                    </div>

                    {{-- Contenu principal --}}
                    <div class="p-8 space-y-6">

                        {{-- Motif de non faisabilité (si applicable) --}}
                        @if($etude->faisabilite === 'non_faisable')
                            <div class="bg-rose-50 border border-rose-200 rounded-lg p-4">
                                @if($etude->motif_non_faisabilite)
                                <div class="mb-4">
                                    <p class="text-[10px] font-bold text-rose-600 uppercase tracking-[0.12em] mb-2">Motif de non faisabilité</p>
                                    <p class="text-sm text-rose-700">{{ $etude->motif_non_faisabilite }}</p>
                                </div>
                                @endif
                                @if($etude->raison)
                                <div>
                                    <p class="text-[10px] font-bold text-rose-600 uppercase tracking-[0.12em] mb-2">Raison</p>
                                    <p class="text-sm text-rose-700">{{ $etude->raison }}</p>
                                </div>
                                @endif
                            </div>
                        @endif

                        {{-- Besoin d'information --}}
                        @if($etude->besoin_information)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-2">Besoin d'information</p>
                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 text-sm text-blue-700">
                                {{ $etude->besoin_information }}
                            </div>
                        </div>
                        @endif

                        {{-- Norme / CDC --}}
                        @if($etude->norme_cdc)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-2">Norme / Cahier des charges</p>
                            <p class="text-sm text-gray-700">{{ $etude->norme_cdc }}</p>
                        </div>
                        @endif

                        {{-- Besoins --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Sous-traitance --}}
                            <div class="bg-gray-50 border border-gray-100 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-8 h-8 rounded-full {{ $etude->besoin_sous_traitance ? 'bg-emerald-100' : 'bg-gray-100' }} flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $etude->besoin_sous_traitance ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-700">Sous-traitance</span>
                                </div>
                                <p class="text-[11px] text-gray-500">{{ $etude->besoin_sous_traitance ? 'Oui' : 'Non' }}</p>
                                @if($etude->besoin_sous_traitance && $etude->sous_traitant)
                                    <p class="text-xs text-gray-700 font-medium mt-2 pt-2 border-t border-gray-200">{{ $etude->sous_traitant }}</p>
                                @endif
                            </div>

                            {{-- Outillage --}}
                            <div class="bg-gray-50 border border-gray-100 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-8 h-8 rounded-full {{ $etude->besoin_outillage ? 'bg-emerald-100' : 'bg-gray-100' }} flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $etude->besoin_outillage ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-700">Montage/Outillage</span>
                                </div>
                                <p class="text-[11px] text-gray-500">{{ $etude->besoin_outillage ? 'Oui' : 'Non' }}</p>
                            </div>

                            {{-- Heures supplémentaires --}}
                            <div class="bg-gray-50 border border-gray-100 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-8 h-8 rounded-full {{ $etude->besoin_heures_sup ? 'bg-emerald-100' : 'bg-gray-100' }} flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $etude->besoin_heures_sup ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-700">Heures supplémentaires</span>
                                </div>
                                <p class="text-[11px] text-gray-500">{{ $etude->besoin_heures_sup ? 'Oui' : 'Non' }}</p>
                            </div>
                        </div>

                        {{-- Détails Outillage --}}
                        @if($etude->besoin_outillage && $etude->details_outillage)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-2">Détails du montage/outillage</p>
                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 text-sm text-gray-700 whitespace-pre-wrap">
                                {{ $etude->details_outillage }}
                            </div>
                        </div>
                        @endif

                        {{-- Heures supplémentaires détails --}}
                        @if($etude->besoin_heures_sup)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($etude->nombre_heures_sup)
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-2">Nombre d'heures supplémentaires</p>
                                <div class="flex items-center gap-2 bg-gray-50 rounded-lg p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-700">{{ $etude->nombre_heures_sup }} heure(s)</p>
                                </div>
                            </div>
                            @endif
                            @if($etude->personnes_concernees)
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-2">Personnes concernées</p>
                                <p class="text-sm text-gray-700 bg-gray-50 rounded-lg p-3">{{ $etude->personnes_concernees }}</p>
                            </div>
                            @endif
                        </div>
                        @endif

                        {{-- Délai previsionnel --}}
                        @if($etude->delai_previsionnel)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-2">Délai prévisionnel</p>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm text-gray-700 font-medium">{{ $etude->delai_previsionnel }} jour(s)</p>
                            </div>
                        </div>
                        @endif

                        {{-- Conditions particulières --}}
                        @if($etude->conditions_particulieres)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-2">Conditions particulières</p>
                            <div class="bg-amber-50 border border-amber-100 rounded-lg p-4 text-sm text-gray-700 whitespace-pre-wrap">
                                {{ $etude->conditions_particulieres }}
                            </div>
                        </div>
                        @endif

                        {{-- Footer --}}
                        <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                            <p class="text-[11px] text-gray-400">
                                Créée le {{ $etude->created_at->format('d/m/Y H:i') }}
                                @if($etude->updated_at->ne($etude->created_at))
                                    · Modifiée le {{ $etude->updated_at->format('d/m/Y H:i') }}
                                @endif
                            </p>
                            <a href="{{ route('demande_essai.produit.show', $demande->demande_id) }}"
                               class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition text-sm font-medium">
                                Retour
                            </a>
                        </div>
                    </div>
                </div>

            @else
                {{-- Affichage du message vide --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-violet-50 border border-violet-100 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7 12a5 5 0 1110 0 5 5 0 01-10 0z"/>
                        </svg>
                    </div>
                    <p class="text-lg font-bold text-gray-900 mb-2">Aucune étude créée</p>
                    <p class="text-sm text-gray-500 mb-6">Aucune étude de faisabilité n'a été créée pour ce produit.</p>
                    <a href="{{ route('etudes.create', $demande) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-150 shadow-md shadow-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Créer l'étude
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
