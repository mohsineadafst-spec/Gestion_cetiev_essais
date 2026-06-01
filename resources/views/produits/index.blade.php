<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gérer les rapports/demandes') }}
            </h2>
            <a href="{{ route('produits.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Nouvelle demande
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Messages de succès/erreur -->
            @if ($message = Session::get('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ $message }}
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $message }}
                </div>
            @endif

            <!-- Tableau des rapports -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($produits->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Laboratoire</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date réception</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marque</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paiement</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Résultat</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rapport</th>

                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($produits as $produit)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $produit->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $produit->client_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $produit->laboratoire->nom }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $produit->date_reception->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if ($produit->marque)
                                                    {{ $produit->marque }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">  
                                             <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                             @if($produit->type=='réglementaire') bg-purple-100 text-purple-800
                                             @elseif($produit->type=='développement') bg-indigo-100 text-indigo-800
                                             @endif">
                                                @if ($produit->type)
                                                    {{ $produit->type }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    @if($produit->quantite > 20) bg-green-100 text-green-800
                                                    @elseif($produit->quantite > 5) bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ $produit->quantite }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if ($produit->montant_ttc)
                                                    {{ number_format($produit->montant_ttc, 2, ',', ' ') }} DH
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            

                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($produit->statut === 'done') bg-green-100 text-green-800
                                                    @elseif($produit->statut === 'in_progress') bg-blue-100 text-blue-800
                                                    @elseif($produit->statut === 'todo') bg-yellow-100 text-yellow-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    @switch($produit->statut)
                                                        @case('todo') À faire @break
                                                        @case('in_progress') En cours @break
                                                        @case('done') Fait @break
                                                        @case('cancelled') Annulé @break
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($produit->statut_paiement === 'paid') bg-green-100 text-green-800
                                                    @elseif($produit->statut_paiement === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    @switch($produit->statut_paiement)
                                                        @case('pending') En attente @break
                                                        @case('paid') Payé @break
                                                        @case('cancelled') Annulé @break
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if ($produit->resultat)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        @if($produit->resultat === 'conforme') bg-green-100 text-green-800
                                                        @elseif($produit->resultat === 'non_conforme') bg-red-100 text-red-800
                                                        @else bg-yellow-100 text-yellow-800
                                                        @endif">
                                                        {{ ucfirst(str_replace('_', ' ', $produit->resultat)) }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('produits.edit', $produit) }}" class="text-blue-600 hover:text-blue-900">
                                                    Éditer
                                                </a>
                                                <form method="POST" action="{{ route('produits.destroy', $produit) }}" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-900">
                                                @if($produit->url_rapport)
                                                    <p>
                                                        
                                                        <a href="{{ $produit->url_rapport }}" target="_blank" >Télécharger</a>
                                                    </p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $produits->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg">Aucun rapport trouvé.</p>
                            <a href="{{ route('produits.create') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Créer la première demande
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
