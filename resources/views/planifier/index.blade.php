<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Planifications
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ $planifications->total() }} planification{{ $planifications->total() > 1 ? 's' : '' }}
                </p>
            </div>
            <a href="{{ route('planifier.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600
                      text-white text-sm font-medium rounded-lg hover:bg-indigo-700
                      transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle planification
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400
                                       uppercase tracking-wider">N° de planification</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400
                                       uppercase tracking-wider">N° de confirmation du demande</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400
                                       uppercase tracking-wider">Essai N°</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400
                                       uppercase tracking-wider">Client</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400
                                       uppercase tracking-wider">Intervenant</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400
                                       uppercase tracking-wider">Date prévue</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400
                                       uppercase tracking-wider">Statut</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400
                                       uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($planifications as $planif)
                        <tr class="hover:bg-gray-50 transition-colors group">

                            <td class="px-4 py-3.5 text-sm text-gray-400 font-mono">
                                #{{ $planif->id }}
                            </td>

                            <td class="px-4 py-3.5 text-sm text-gray-700">
                                {{ $planif->demande_confirme_id ?? '—' }}
                            </td>

                            <td class="px-4 py-3.5 text-sm text-gray-700">
                                {{ $planif->demande_essai_id ?? '—' }}
                            </td>

                            <td class="px-4 py-3.5 text-sm text-gray-700">
                                {{ $planif->demandeConfirmee->produit->client_name ?? '—' }}
                            </td>

                            <td class="px-4 py-3.5">
                                @if($planif->intervenant)
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-700
                                                  flex items-center justify-center text-xs font-semibold
                                                  flex-shrink-0">
                                        {{ strtoupper(substr($planif->intervenant->name, 0, 1)) }}
                                    </span>
                                    <span class="text-sm text-gray-700">{{ $planif->intervenant->name }}</span>
                                </div>
                                @else
                                    <span class="text-sm text-gray-400">—</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-sm text-gray-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($planif->dd_prevu)->format('d/m/Y') }}
                            </td>

                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full
                                    text-xs font-medium
                                    @if($planif->statue === 'terminé')
                                        bg-green-100 text-green-800
                                    @elseif($planif->statue === 'en_cours')
                                        bg-blue-100 text-blue-800
                                    @elseif($planif->statue === 'annulé')
                                        bg-red-100 text-red-800
                                    @else
                                        bg-gray-100 text-gray-600
                                    @endif">
                                    <span class="w-1.5 h-1.5 rounded-full
                                        @if($planif->statue === 'terminé') bg-green-500
                                        @elseif($planif->statue === 'en_cours') bg-blue-500
                                        @elseif($planif->statue === 'annulé') bg-red-500
                                        @else bg-gray-400 @endif"></span>
                                    {{ ucfirst($planif->statue) }}
                                </span>
                            </td>

                            <td class="px-4 py-3.5">
    <div class="flex items-center justify-end gap-2">

        {{-- Voir --}}
        <a href="{{ route('planifier.show', $planif->id) }}"
           title="Voir"
           class="inline-flex items-center justify-center p-2 rounded-lg 
                  text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 
                  transition-colors duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z 
                         M2.458 12C3.732 7.943 7.523 5 12 5c4.478 
                         0 8.268 2.943 9.542 7-1.274 4.057-5.064 
                         7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </a>

        {{-- Modifier --}}
        <a href="{{ route('planifier.edit', $planif->id) }}"
           title="Modifier"
           class="inline-flex items-center justify-center p-2 rounded-lg 
                  text-gray-500 hover:text-amber-600 hover:bg-amber-50 
                  transition-colors duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 
                         2 0 112.828 2.828L11.828 15.828A2 2 0 0110.414 
                         16H9v-1.414a2 2 0 01.586-1.414z"/>
            </svg>
        </a>

        {{-- Supprimer --}}
        <form action="{{ route('planifier.destroy', $planif->id) }}"
              method="POST" class="inline"
              onsubmit="return confirm('Supprimer cette planification ?')">
            @csrf @method('DELETE')
            <button type="submit" title="Supprimer"
                    class="inline-flex items-center justify-center p-2 rounded-lg 
                           text-gray-500 hover:text-red-600 hover:bg-red-50 
                           transition-colors duration-150 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 
                             2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 
                             7V4h6v3M4 7h16"/>
                </svg>
            </button>
        </form>
    </div>
</td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-16 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0
                                                 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0
                                                 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-sm">Aucune planification pour le moment.</p>
                                    <a href="{{ route('planifier.create') }}"
                                       class="mt-1 text-sm text-indigo-600 hover:underline">
                                        Créer la première
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($planifications->hasPages())
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $planifications->links() }}
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>