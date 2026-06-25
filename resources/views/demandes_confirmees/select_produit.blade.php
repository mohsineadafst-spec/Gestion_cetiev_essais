<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Demande confirmée</p>
                <h2 class="font-medium text-base text-gray-800 leading-tight">Sélectionner un produit</h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Barre de recherche --}}
            <form method="GET" action="{{ route('demandes_confirmees.select') }}"
                  class="flex items-center gap-2 mb-5">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z" />
                    </svg>
                    <input type="number" name="produit_id" placeholder="Rechercher par ID"
                           value="{{ request('produit_id') }}"
                           class="pl-9 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-56">
                </div>
                <button type="submit"
                        class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z" />
                    </svg>
                    Rechercher
                </button>
            </form>

            {{-- Tableau --}}
            <div class="border border-gray-100 rounded-xl overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 w-16">ID</th>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-500">Client</th>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-500">Laboratoire</th>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-500">Date réception</th>
                            <th class="text-right px-5 py-3 text-xs font-medium text-gray-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($produits as $produit)
                            <tr class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-5 py-3.5 text-gray-400 tabular-nums">{{ $produit->id }}</td>
                                <td class="px-5 py-3.5 font-medium text-gray-800">{{ $produit->client_name }}</td>
                                <td class="px-5 py-3.5 text-gray-500">{{ $produit->laboratoire->nom ?? 'N/A' }}</td>
                                <td class="px-5 py-3.5 text-gray-500">{{ optional($produit->date_reception)->format('d/m/Y') }}</td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('demandes_confirmees.create', ['produit_id' => $produit->id]) }}"
                                       class="inline-flex items-center gap-1.5 bg-green-50 hover:bg-green-100 text-green-700 text-xs font-medium px-3 py-1.5 rounded-md border border-green-200 transition-colors">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                                        </svg>
                                        Créer confirmation
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-gray-400 text-sm">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z" />
                                    </svg>
                                    Aucun produit trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

               
            </div>

        </div>
    </div>
</x-app-layout>