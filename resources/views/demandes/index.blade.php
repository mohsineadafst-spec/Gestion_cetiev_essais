<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gérer les demandes de faisabilité') }}
            </h2>
            <a href="{{ route('demandes.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
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

            <!-- Tableau des demandes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($demandes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date réception</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pôle</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faisabilité</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($demandes as $demande)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $demande->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $demande->client }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div>{{ $demande->nom }}</div>
                                                @if ($demande->tel)
                                                    <div class="text-xs text-gray-400">{{ $demande->tel }}</div>
                                                @endif
                                                @if ($demande->mail)
                                                    <a href="mailto:{{ $demande->mail }}" class="text-xs text-blue-600 hover:text-blue-900">
                                                        {{ $demande->mail }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $demande->datereception?->format('d/m/Y') ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    {{ $demande->laboratoire }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($demande->cloture === 'En cours de traitement') bg-yellow-100 text-yellow-800
                                                    @elseif($demande->cloture === 'Clos') bg-green-100 text-green-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ $demande->cloture }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if ($demande->faisable)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        @if($demande->faisable === 'Oui') bg-green-100 text-green-800
                                                        @elseif($demande->faisable === 'Non') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800
                                                        @endif">
                                                        {{ $demande->faisable }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('demandes.edit', $demande) }}" class="text-blue-600 hover:text-blue-900">
                                                    Éditer
                                                </a>
                                                <form method="POST" action="{{ route('demandes.destroy', $demande) }}" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $demandes->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg">Aucune demande trouvée.</p>
                            <a href="{{ route('demandes.create') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Créer la première demande
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
