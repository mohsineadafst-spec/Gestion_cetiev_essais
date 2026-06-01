<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Demandes Confirmées</h2>
            <a href="{{ route('demandes_confirmees.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-150 shadow-md shadow-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter une confirmation du demande
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages de succès/erreur --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tableau des demandes --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Demande Essai</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date Réception</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Numéro BC</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Laboratoire</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Confirmation</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Code Rapport</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($demandesConfirmees as $demande)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-mono font-semibold text-indigo-600">#{{ $demande->id }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($demande->demandeEssai)
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-gray-900">#{{ $demande->demandeEssai->id }}</span>
                                                <span class="text-xs text-gray-500">{{ $demande->demandeEssai->essai->nom_essai ?? 'N/A' }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $demande->client }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $demande->date_reception->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $demande->numero_bc }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $demande->laboratoire->nom }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @php
                                            $confirmClass = $demande->confirmation === 'oui' 
                                                ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                                                : 'bg-amber-50 text-amber-700 ring-1 ring-amber-200';
                                            $confirmLabel = $demande->confirmation === 'oui' ? 'Oui' : 'Non';
                                        @endphp
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $confirmClass }}">
                                            {{ $confirmLabel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $demande->code_rapport }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('demandes_confirmees.edit', $demande->id) }}"
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                                Modifier
                                            </a>
                                            <form method="POST" action="{{ route('demandes_confirmees.destroy', $demande->id) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Êtes-vous sûr?')"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg transition-colors">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">
                                        <p class="text-gray-500">Aucune demande confirmée trouvée.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $demandesConfirmees->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
