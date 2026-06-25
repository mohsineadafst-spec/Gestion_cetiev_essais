<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-indigo-500 mb-1">Gestion</p>
                <h2 class="text-2xl font-bold text-gray-900 leading-tight">Demandes confirmées</h2>
            </div>
            <a href="{{ route('demandes_confirmees.select') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle confirmation
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats strip --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @php
                    $total    = $demandesConfirmees->total();
                    $confirmé = $demandesConfirmees->getCollection()->where('confirmation', 'oui')->count();
                    $refusé   = $demandesConfirmees->getCollection()->where('confirmation', 'non')->count();
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-4">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $total }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-4">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Confirmées</p>
                    <p class="mt-1 text-3xl font-bold text-emerald-600">{{ $confirmé }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-4">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Non confirmées</p>
                    <p class="mt-1 text-3xl font-bold text-red-500">{{ $refusé }}</p>
                </div>
            </div>

            {{-- Table card --}}
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50">
                                @foreach(['Produit ID', 'Client', 'Laboratoire', 'Réception BC', 'Réception échantillons', 'Confirmation', 'Actions'] as $col)
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    {{ $col }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($demandesConfirmees as $demande)
                                <tr class="hover:bg-indigo-50/40 transition-colors duration-150">

                                    {{-- Produit ID --}}
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold">
                                            {{ $demande->produit_id }}
                                        </span>
                                    </td>

                                    {{-- Client --}}
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-600 text-xs font-bold uppercase">
                                                {{ substr($demande->client, 0, 1) }}
                                            </span>
                                            <span class="text-sm font-medium text-gray-900">{{ $demande->client }}</span>
                                        </div>
                                    </td>

                                    {{-- Laboratoire --}}
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $demande->laboratoire->nom ?? '—' }}
                                    </td>

                                    {{-- Date réception BC --}}
                                    <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $demande->date_reception_bc->format('d/m/Y') }}
                                        </div>
                                    </td>

                                    {{-- Date réception échantillons --}}
                                    <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $demande->date_reception_échantillons->format('d/m/Y') }}
                                        </div>
                                    </td>

                                    {{-- Confirmation badge --}}
                                    <td class="px-4 py-3">
                                        @if($demande->confirmation === 'oui')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Confirmée
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                Non confirmée
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('demandes_confirmees.show', $demande) }}"
                                               class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Voir
                                            </a>

                                            <a href="{{ route('demandes_confirmees.edit', $demande) }}"
                                               class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 hover:text-amber-800 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l1.586 1.586a1 1 0 010 1.414L12 16H9v-3z"/>
                                                </svg>
                                                Modifier
                                            </a>

                                            <form action="{{ route('demandes_confirmees.destroy', $demande) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Supprimer cette demande ?')"
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
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="text-sm font-medium">Aucune demande confirmée</p>
                                            <a href="{{ route('demandes_confirmees.create') }}"
                                               class="text-indigo-600 text-xs font-semibold hover:underline">
                                                Créer la première demande →
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($demandesConfirmees->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $demandesConfirmees->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>