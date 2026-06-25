<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-2.5 mb-0.5">
                    <a href="{{ route('demande_essai.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <span class="text-gray-300">/</span>
                    <span class="text-sm text-gray-400">Demandes</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-3">
                    Demande
                    <span class="text-lg font-mono font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded-lg">#{{ $produit->id }}</span>
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">Visualisation complète et gestion des assignations</p>
            </div>
            <a href="{{ route('demande_essai.create', ['demande_id' => $produit->id]) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-150 shadow-md shadow-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter un essai
            </a>
        </div>
    </x-slot>

    <style>
        .fade-in { animation: fadeIn 0.5s ease both; }
        .fade-in-up { animation: fadeInUp 0.4s ease both; }
        .fade-in-up-2 { animation: fadeInUp 0.4s ease 0.1s both; }

        @keyframes fadeIn    { from { opacity: 0; }                        to { opacity: 1; } }
        @keyframes fadeInUp  { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .stat-card {
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .stat-card:hover::before { opacity: 1; }

        .essai-row { transition: background 0.15s ease; }
        .essai-row:hover { background: #f9fafb; }
    </style>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ══════════════ PRODUCT INFO CARD ══════════════ --}}
            <div class="fade-in-up bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                {{-- Header band --}}
                <div class="px-8 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/60">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800">Informations demande</h3>
                            <p class="text-xs text-gray-400">Fiche complète</p>
                        </div>
                    </div>

                    {{-- Statut produit --}}
                    @php
                        $statutClass = match($produit->statut) {
                            'todo'        => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
                            'in_progress' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                            'done'        => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                            'cancelled'   => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                            default       => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200',
                        };
                        $statutDot = match($produit->statut) {
                            'todo'        => 'bg-slate-400',
                            'in_progress' => 'bg-amber-400',
                            'done'        => 'bg-emerald-400',
                            'cancelled'   => 'bg-rose-400',
                            default       => 'bg-gray-400',
                        };
                        $statutLabel = match($produit->statut) {
                            'todo'        => 'À faire',
                            'in_progress' => 'En cours',
                            'done'        => 'Terminé',
                            'cancelled'   => 'Annulé',
                            default       => ucfirst($produit->statut),
                        };
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $statutClass }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $statutDot }}"></span>
                        {{ $statutLabel }}
                    </span>
                </div>

                <div class="p-8">

                    {{-- Top stats row --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

                        <div class="stat-card bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-1">Référence</p>
                            <p class="text-2xl font-extrabold text-gray-900 font-mono">#{{ $produit->id }}</p>
                        </div>

                        <div class="stat-card bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-1">Client</p>
                            <p class="text-sm font-bold text-gray-800 leading-snug">{{ $produit->client_name }}</p>
                        </div>

                        <div class="stat-card bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-1">Type</p>
                            @php
                                $typeLabel = match($produit->type) {
                                    'réglementaire' => 'Réglementaire',
                                    'développement' => 'Développement',
                                    default => ucfirst($produit->type)
                                };
                            @endphp
                            <p class="text-sm font-bold text-gray-800">{{ $typeLabel }}</p>
                        </div>

                        <div class="stat-card bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-1">Laboratoire</p>
                            <p class="text-sm font-bold text-gray-800">{{ $produit->laboratoire?->nom ?? 'N/A' }}</p>
                        </div>
                    </div>

                    {{-- Details grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-5 pb-6 border-b border-gray-100">

                        @if($produit->marque)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-1">Marque</p>
                            <p class="text-sm text-gray-700 font-medium">{{ $produit->marque }}</p>
                        </div>
                        @endif

                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-1">Quantité</p>
                            <p class="text-sm text-gray-700 font-medium">{{ $produit->quantite }} unité(s)</p>
                        </div>

                        @if($produit->montant_ttc)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-1">Montant TTC</p>
                            <p class="text-base font-bold text-indigo-600">{{ number_format($produit->montant_ttc, 2, ',', ' ') }} DH</p>
                        </div>
                        @endif

                        {{-- Paiement --}}
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-1.5">Paiement</p>
                            @php
                                $paiementClass = match($produit->statut_paiement) {
                                    'pending'   => 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200',
                                    'paid'      => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                    'cancelled' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                                    default     => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200',
                                };
                                $paiementLabel = match($produit->statut_paiement) {
                                    'pending'   => 'En attente',
                                    'paid'      => 'Payé',
                                    'cancelled' => 'Annulé',
                                    default     => ucfirst($produit->statut_paiement),
                                };
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $paiementClass }}">
                                {{ $paiementLabel }}
                            </span>
                        </div>

                        {{-- Résultat --}}
                        @if($produit->resultat)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-1.5">Résultat</p>
                            @php
                                $resultatClass = match($produit->resultat) {
                                    'conforme'     => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                    'non_conforme' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                                    'partiel'      => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                    default        => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200',
                                };
                                $resultatLabel = match($produit->resultat) {
                                    'conforme'     => 'Conforme',
                                    'non_conforme' => 'Non conforme',
                                    'partiel'      => 'Partiel',
                                    default        => ucfirst($produit->resultat),
                                };
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $resultatClass }}">
                                {{ $resultatLabel }}
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Dates row --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-5">
                        @foreach([
                            ['Date reçue',  $produit->date_reception?->format('d/m/Y H:i')],
                            ['Date prévue', $produit->date_prevue?->format('d/m/Y')],
                            ['Créé le',     $produit->created_at?->format('d/m/Y H:i')],
                        ] as [$dateLabel, $dateValue])
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider leading-none mb-0.5">{{ $dateLabel }}</p>
                                <p class="text-sm text-gray-700 font-medium">{{ $dateValue ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Notes --}}
                    @if($produit->notes)
                    <div class="mt-6 pt-5 border-t border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] mb-2">Notes</p>
                        <div class="bg-amber-50/60 border border-amber-100 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                            {{ $produit->notes }}
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- ══════════════ KPI ROW ══════════════ --}}
            @if($produit->type === 'développement')
            <div class="fade-in-up-2 grid grid-cols-2 md:grid-cols-4 gap-4">

                {{-- Total --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0 group-hover:bg-indigo-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Total études</p>
                        <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $kpi['total'] }}</p>
                    </div>
                </div>

                {{-- Faisables --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0 group-hover:bg-emerald-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Faisables</p>
                        <div class="flex items-baseline gap-1.5">
                            <p class="text-2xl font-extrabold text-emerald-600 leading-none">{{ $kpi['faisables'] }}</p>
                            @if($kpi['total'] > 0)
                                <p class="text-xs font-semibold text-gray-400">{{ round($kpi['faisables'] / $kpi['total'] * 100) }}%</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Non faisables --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-11 h-11 rounded-xl bg-rose-50 flex items-center justify-center shrink-0 group-hover:bg-rose-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Non faisables</p>
                        <div class="flex items-baseline gap-1.5">
                            <p class="text-2xl font-extrabold text-rose-600 leading-none">{{ $kpi['non_faisables'] }}</p>
                            @if($kpi['total'] > 0)
                                <p class="text-xs font-semibold text-gray-400">{{ round($kpi['non_faisables'] / $kpi['total'] * 100) }}%</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- À confirmer --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center shrink-0 group-hover:bg-amber-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">À confirmer</p>
                        <div class="flex items-baseline gap-1.5">
                            <p class="text-2xl font-extrabold text-amber-600 leading-none">{{ $kpi['non_confirmes'] }}</p>
                            @if($kpi['total'] > 0)
                                <p class="text-xs font-semibold text-gray-400">{{ round($kpi['non_confirmes'] / $kpi['total'] * 100) }}%</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            

            {{-- Progress bar --}}
            @if($kpi['total'] > 0)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-4 flex items-center gap-4">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest shrink-0">Répartition faisabilité</p>
                @php
                    $pctFaisable    = $kpi['total'] > 0 ? round($kpi['faisables']     / $kpi['total'] * 100) : 0;
                    $pctNonFaisable = $kpi['total'] > 0 ? round($kpi['non_faisables'] / $kpi['total'] * 100) : 0;
                    $pctConfirmer   = $kpi['total'] > 0 ? round($kpi['non_confirmes'] / $kpi['total'] * 100) : 0;
                @endphp
                <div class="flex-1 flex h-2.5 rounded-full overflow-hidden bg-gray-100 gap-px">
                    @if($kpi['faisables'] > 0)
                        <div class="bg-emerald-400 transition-all duration-500" style="--w: {{ $pctFaisable }}%; width: var(--w)"></div>
                    @endif
                    @if($kpi['non_faisables'] > 0)
                        <div class="bg-rose-400 transition-all duration-500" style="--w: {{ $pctNonFaisable }}%; width: var(--w)"></div>
                    @endif
                    @if($kpi['non_confirmes'] > 0)
                        <div class="bg-amber-400 transition-all duration-500" style="--w: {{ $pctConfirmer }}%; width: var(--w)"></div>
                    @endif
                </div>
                <div class="flex items-center gap-4 shrink-0 text-[11px] font-semibold text-gray-500">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-400"></span>{{ $kpi['faisables'] }}</span>
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-rose-400"></span>{{ $kpi['non_faisables'] }}</span>
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-400"></span>{{ $kpi['non_confirmes'] }}</span>
                </div>
            </div>
            @endif
            @endif

            {{-- ══════════════ ESSAIS CARD ══════════════ --}}
            <div class="fade-in-up-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                {{-- Section header --}}
                <div class="px-8 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/60">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-violet-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800">Essais assignés</h3>
                            <p class="text-xs text-gray-400">
                                <span class="font-semibold text-violet-600">{{ $produit->demandesEssai->count() }}</span> essai(s) associé(s)
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('demande_essai.create', ['demande_id' => $produit->id]) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-violet-50 text-violet-600 text-xs font-semibold rounded-xl hover:bg-violet-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajouter
                    </a>
                </div>

                @if($produit->demandesEssai->count() > 0)
                    <div class="divide-y divide-gray-50">
                        @foreach($produit->demandesEssai as $demande)
                            @php
                                $badgeEssai = match($demande->statut) {
                                    'catalogué'     => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
                                    'non catalogué' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                    default         => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200',
                                };
                            @endphp
                            

                            <div class="essai-row px-8 py-6">
                                <div class="flex items-start justify-between gap-6">
                                    <div class="flex-1 min-w-0">

                                        {{-- Title + badge --}}
                                        <div class="flex flex-wrap items-center gap-2.5 mb-3">
                                            <h4 class="text-base font-bold text-gray-900 leading-tight">
                                                {{ $demande->essai->nom_essai }}
                                            </h4>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $badgeEssai }}">
                                                {{ $demande->statut }}
                                            </span>
                                            @if($demande->demande->type === 'développement' && $demande->etude)
                                                @php
                                                    $faisabiliteClass = match($demande->etude->faisabilite) {
                                                        'faisable'     => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                                        'non_faisable' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                                                        'a_confirmer'  => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                                        default        => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200',
                                                    };
                                                    $faisabiliteLabel = match($demande->etude->faisabilite) {
                                                        'faisable'     => 'Faisable',
                                                        'non_faisable' => 'Non faisable',
                                                        'a_confirmer'  => 'À confirmer',
                                                        default        => ucfirst($demande->etude->faisabilite),
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $faisabiliteClass }}">
                                                    {{ $faisabiliteLabel }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Labo --}}
                                        <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                            <span class="font-medium">{{ $demande->laboratoire->nom ?? 'N/A' }}</span>
                                        </div>

                                        {{-- Optional fields --}}
                                        @if($demande->description || $demande->informations_complementaires || $demande->echantillons)
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 rounded-xl p-4 mt-2">
                                                @if($demande->description)
                                                    <div>
                                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Description</p>
                                                        <p class="text-xs text-gray-600 leading-relaxed">{{ $demande->description }}</p>
                                                    </div>
                                                @endif
                                                @if($demande->informations_complementaires)
                                                    <div>
                                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Infos complémentaires</p>
                                                        <p class="text-xs text-gray-600 leading-relaxed">{{ $demande->informations_complementaires }}</p>
                                                    </div>
                                                @endif
                                                @if($demande->echantillons)
                                                    <div>
                                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Échantillons</p>
                                                        <p class="text-xs text-gray-600 leading-relaxed">{{ $demande->echantillons }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- Footer meta --}}
                                        <p class="mt-3 text-[11px] text-gray-400 font-medium">
                                            Assignation #{{ $demande->id }} · Créée le {{ $demande->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>

                                    {{-- ── Actions ── --}}
                                    <div class="flex flex-col items-stretch gap-2 shrink-0 w-40">

    {{-- Accéder à l’étude : toujours visible si conditions respectées --}}
    @if($demande->demande->type === 'développement' 
        && Auth::check() 
        && Auth::user()->manageLaboratoire($demande->laboratoire_id))
        <a href="{{ route('etudes.show', $demande) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                  text-emerald-700 bg-emerald-50 ring-1 ring-emerald-200
                  hover:bg-emerald-100 active:scale-95 transition-all duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7 12a5 5 0 1110 0 5 5 0 01-10 0z"/>
            </svg>
            Accéder à l'étude
        </a>
    @endif

    {{-- Actions sensibles : affichées uniquement si user responsable --}}
    @if(Auth::check() && Auth::user()->manageLaboratoire($demande->laboratoire_id))
        <a href="{{ route('demande_essai.edit', $demande->id) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                  text-blue-700 bg-blue-50 ring-1 ring-blue-200
                  hover:bg-blue-100 active:scale-95 transition-all duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Modifier
        </a>

        @if($demande->cloture)
            <div class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                    text-emerald-700 bg-emerald-50 ring-1 ring-emerald-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                </svg>
                Clôturé
            </div>
        @else
            <form method="POST" action="{{ route('demande_essai.cloture', $demande->id) }}">
                @csrf
                <button type="submit"
                        onclick="return confirm('Êtes-vous sûr de vouloir clôturer cet essai?')"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                               text-orange-700 bg-orange-50 ring-1 ring-orange-200
                               hover:bg-orange-100 active:scale-95 transition-all duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Clôturer
                </button>
            </form>
        @endif

        <form method="POST" action="{{ route('demande_essai.destroy', $demande->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette assignation?')"
                    class="w-full inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                           text-rose-700 bg-rose-50 ring-1 ring-rose-200
                           hover:bg-rose-100 active:scale-95 transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Supprimer
            </button>
        </form>
    @endif

</div>
{{-- ── /Actions ── --}}

                                    {{-- ── /Actions ── --}}

                                </div>
                            </div>
                        @endforeach
                    </div>

                @else
                    {{-- Empty state --}}
                    <div class="py-20 flex flex-col items-center justify-center text-center">
                        <div class="w-14 h-14 rounded-2xl bg-violet-50 border border-violet-100 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-700 mb-1">Aucun essai assigné</p>
                        <p class="text-xs text-gray-400 mb-6">Aucun essai n'a encore été associé à ce produit.</p>
                        <a href="{{ route('demande_essai.create', ['demande_id' => $produit->id]) }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-150 shadow-md shadow-indigo-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Ajouter un essai
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
