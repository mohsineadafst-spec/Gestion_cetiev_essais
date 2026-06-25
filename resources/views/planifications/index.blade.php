<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-indigo-500 mb-1">Gestion</p>
                <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                    Planifications
                </h2>
            </div>
            <a href="{{ route('planifications.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle Planification
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats summary strip --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @php
                    $total      = $planifications->total();
                    $enCours    = $planifications->getCollection()->where('statut', 'en_cours')->count();
                    $termine    = $planifications->getCollection()->where('statut', 'termine')->count();
                    $enAttente  = $planifications->getCollection()->where('statut', 'en_attente')->count();
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-4">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $total }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-4">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">En cours</p>
                    <p class="mt-1 text-3xl font-bold text-indigo-600">{{ $enCours }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-4">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Terminé</p>
                    <p class="mt-1 text-3xl font-bold text-emerald-600">{{ $termine }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-4">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">En attente</p>
                    <p class="mt-1 text-3xl font-bold text-amber-500">{{ $enAttente }}</p>
                </div>
            </div>

            {{-- Table card --}}
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50">
                                @foreach(['Essai','Laboratoire','Intervenant','Réception','Début','Fin','Date prévue','Fin réelle','Rapport','Exécution','Statut','Actions'] as $col)
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    {{ $col }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($planifications as $planification)
                                <tr class="hover:bg-indigo-50/40 transition-colors duration-150">

                                    {{-- Essai --}}
                                    <td class="px-4 py-3">
                                        <span class="font-medium text-gray-900 text-sm">
                                            {{ $planification->demandeConfirmee->essai->nom ?? '—' }}
                                        </span>
                                    </td>

                                    {{-- Laboratoire --}}
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $planification->demandeConfirmee->laboratoire->nom ?? '—' }}
                                    </td>

                                    {{-- Intervenant --}}
                                    <td class="px-4 py-3">
                                        @if($planification->intervenant)
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase">
                                                    {{ substr($planification->intervenant->name, 0, 1) }}
                                                </span>
                                                <span class="text-sm text-gray-700">{{ $planification->intervenant->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">—</span>
                                        @endif
                                    </td>

                                    {{-- Dates --}}
                                    @foreach(['date_reception','date_debut','date_fin','date_prevue','date_fin_reel'] as $date)
                                    <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $planification->$date
                                            ? \Carbon\Carbon::parse($planification->$date)->format('d/m/Y')
                                            : '—' }}
                                    </td>
                                    @endforeach

                                    {{-- Type rapport --}}
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $planification->type_rapport ?? '—' }}
                                    </td>

                                    {{-- Mode exécution --}}
                                    <td class="px-4 py-3">
                                        @php $mode = strtolower($planification->mode_execution ?? ''); @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $mode === 'interne'       ? 'bg-blue-100 text-blue-700'   : '' }}
                                            {{ $mode === 'sous-traité'   ? 'bg-purple-100 text-purple-700' : '' }}
                                            {{ !in_array($mode, ['interne','sous-traité']) ? 'bg-gray-100 text-gray-600' : '' }}
                                        ">
                                            {{ ucfirst($planification->mode_execution) }}
                                        </span>
                                    </td>

                                    {{-- Statut --}}
                                    <td class="px-4 py-3">
                                        @php $statut = strtolower($planification->statut ?? ''); @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold
                                            {{ $statut === 'termine'    ? 'bg-emerald-100 text-emerald-700' : '' }}
                                            {{ $statut === 'en_cours'   ? 'bg-indigo-100 text-indigo-700'  : '' }}
                                            {{ $statut === 'en_attente' ? 'bg-amber-100 text-amber-700'    : '' }}
                                            {{ !in_array($statut, ['termine','en_cours','en_attente']) ? 'bg-gray-100 text-gray-600' : '' }}
                                        ">
                                            <span class="w-1.5 h-1.5 rounded-full
                                                {{ $statut === 'termine'    ? 'bg-emerald-500' : '' }}
                                                {{ $statut === 'en_cours'   ? 'bg-indigo-500'  : '' }}
                                                {{ $statut === 'en_attente' ? 'bg-amber-500'   : '' }}
                                                {{ !in_array($statut, ['termine','en_cours','en_attente']) ? 'bg-gray-400' : '' }}
                                            "></span>
                                            {{ ucfirst(str_replace('_', ' ', $planification->statut)) }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('planifications.edit', $planification->demande_confirmee_id) }}"
                                               class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l1.586 1.586a1 1 0 010 1.414L12 16H9v-3z"/>
                                                </svg>
                                                Modifier
                                            </a>

                                            <form action="{{ route('planifications.destroy', $planification->demande_confirmee_id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Supprimer cette planification ?')"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 text-xs font-semibold text-red-500 hover:text-red-700 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a1 1 0 00-1-1h-4a1 1 0 00-1 1m-4 0h10"/>
                                                    </svg>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            <p class="text-sm font-medium">Aucune planification trouvée</p>
                                            <a href="{{ route('planifications.create') }}"
                                               class="text-indigo-600 text-xs font-semibold hover:underline">
                                                Créer la première planification →
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($planifications->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $planifications->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>