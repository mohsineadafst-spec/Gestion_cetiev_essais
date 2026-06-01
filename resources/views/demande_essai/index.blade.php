<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Assignations Demande-Essai
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">Gestion et suivi des demandes d'essai</p>
            </div>
            <a href="{{ route('demande_essai.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-150 shadow-md shadow-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle assignation
            </a>
        </div>
    </x-slot>

    <style>
        .row-enter {
            animation: rowFadeIn 0.3s ease both;
        }
        @keyframes rowFadeIn {
            from { opacity: 0; transform: translateX(-6px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .row-enter:nth-child(1)  { animation-delay: 0.04s; }
        .row-enter:nth-child(2)  { animation-delay: 0.08s; }
        .row-enter:nth-child(3)  { animation-delay: 0.12s; }
        .row-enter:nth-child(4)  { animation-delay: 0.16s; }
        .row-enter:nth-child(5)  { animation-delay: 0.20s; }
        .row-enter:nth-child(6)  { animation-delay: 0.24s; }
        .row-enter:nth-child(7)  { animation-delay: 0.28s; }
        .row-enter:nth-child(8)  { animation-delay: 0.32s; }

        tbody tr:hover td {
            background-color: #f8faff;
        }
        tbody tr:hover td:first-child {
            border-left: 3px solid #6366f1;
        }
        tbody tr td:first-child {
            border-left: 3px solid transparent;
            transition: border-color 0.15s;
        }

        .essai-pill:not(:last-child)::after {
            content: '';
        }
    </style>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($demandeEssais->count() > 0)

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    {{-- Table toolbar --}}
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/60">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest">
                            {{ $demandeEssais->total() }} demande(s)
                        </p>
                        <div class="flex items-center gap-3 text-xs text-gray-400">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>En cours
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span>Terminé
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-400 inline-block"></span>Annulé
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-slate-300 inline-block"></span>Autre
                            </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-widest w-24">#</th>
                                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-widest">Client</th>
                                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-widest">Type</th>
                                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-widest">Statut</th>
                                    <th class="px-6 py-3.5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-widest">Essais</th>
                                    <th class="px-6 py-3.5 text-right text-[11px] font-bold text-gray-400 uppercase tracking-widest pr-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">

                                @foreach ($demandeEssais as $demande_essai)
                                    @php
                                        $statutCard = $demande_essai->statut;

                                        $badgeClass = match($statutCard) {
                                            'in_progress' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                            'done'        => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                            'cancelled'   => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                                            default       => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
                                        };
                                        $dotClass = match($statutCard) {
                                            'in_progress' => 'bg-amber-400',
                                            'done'        => 'bg-emerald-400',
                                            'cancelled'   => 'bg-rose-400',
                                            default       => 'bg-slate-400',
                                        };
                                        $label = match($statutCard) {
                                            'in_progress' => 'En cours',
                                            'done'        => 'Terminé',
                                            'cancelled'   => 'Annulé',
                                            default       => ucfirst($statutCard),
                                        };
                                    @endphp

                                    <tr class="row-enter transition-colors duration-150 cursor-default">

                                        {{-- ID --}}
                                        <td class="px-6 py-4">
                                            <span class="text-xs font-bold text-gray-400 tracking-wider">#{{ $demande_essai->id }}</span>
                                        </td>

                                        {{-- Client --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                                <span class="font-semibold text-gray-800 text-sm">{{ $demande_essai->client_name ?? 'N/A' }}</span>
                                            </div>
                                        </td>

                                        {{-- Type --}}
                                        <td class="px-6 py-4">
                                            @if($demande_essai->type)
                                                @php
                                                    $typeClass = match($demande_essai->type) {
                                                        'développement'  => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
                                                        'réglementaire'  => 'bg-purple-50 text-purple-700 ring-1 ring-purple-200',
                                                        default          => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200',
                                                    };
                                                    $typeLabel = match($demande_essai->type) {
                                                        'développement'  => 'Développement',
                                                        'réglementaire'  => 'Réglementaire',
                                                        default          => ucfirst($demande_essai->type),
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold {{ $typeClass }}">
                                                    {{ $typeLabel }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400 italic">N/A</span>
                                            @endif
                                        </td>

                                        {{-- Statut --}}
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                                {{ $label }}
                                            </span>
                                        </td>

                                        {{-- Essais --}}
                                        <td class="px-6 py-4">
                                            @if ($demande_essai->essais->count() > 0)
                                                <div class="flex flex-wrap gap-1.5">
                                                    @foreach ($demande_essai->essais as $essai)
                                                        @php
                                                            $essaiBadge = match($essai->pivot->statut) {
                                                                'non catalogué' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                                                'catalogué'     => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
                                                                default         => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200',
                                                            };
                                                        @endphp
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-medium {{ $essaiBadge }}"
                                                              title="{{ $essai->nom_essai }} — {{ $essai->pivot->statut }}">
                                                            {{ Str::limit($essai->nom_essai, 22) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Aucun essai</span>
                                            @endif
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('demande_essai.produit.show', $demande_essai->id) }}"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Voir
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{-- Table footer + Pagination --}}
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/60">
                        {{ $demandeEssais->links() }}
                    </div>

                </div>

            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 py-24 flex flex-col items-center justify-center text-center shadow-sm">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="text-gray-700 font-semibold text-sm mb-1">Aucune demande trouvée</p>
                    <p class="text-gray-400 text-xs mb-6">Commencez par créer une nouvelle assignation.</p>
                    <a href="{{ route('demande_essai.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-150 shadow-md shadow-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Créer une assignation
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
