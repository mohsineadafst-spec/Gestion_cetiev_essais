<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Nouvelle demande</p>
                <h2 class="font-medium text-base text-gray-800 leading-tight">Demande confirmée</h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('demandes_confirmees.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Infos produit --}}
                @if($produit)
                    <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-5">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-4">Informations produit</p>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Produit ID</p>
                                <p class="text-sm font-medium text-gray-800">{{ $produit->id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Client</p>
                                <p class="text-sm font-medium text-gray-800">{{ $produit->client_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Laboratoire</p>
                                <p class="text-sm font-medium text-gray-800">{{ $produit->laboratoire->nom ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Date réception</p>
                                <p class="text-sm font-medium text-gray-800">{{ optional($produit->date_reception)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Numéro BC + Code rapport --}}
                <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">Numéro BC</label>
                            <input type="text" name="numero_bc" placeholder="ex. BC-2024-001"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">Code rapport</label>
                            <input type="text" name="code_rapport" placeholder="ex. RPT-2024-001"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        </div>
                    </div>
                </div>

                {{-- Dates --}}
                <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">Date réception BC</label>
                            <input type="date" name="date_reception_bc"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">Date réception échantillons</label>
                            <input type="date" name="date_reception_échantillons"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        </div>
                    </div>
                </div>

                {{-- Confirmation --}}
                <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                    <label class="block text-xs text-gray-500 mb-1.5">Confirmation</label>
                    <select name="confirmation"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="oui">Oui</option>
                        <option value="non">Non</option>
                    </select>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between pt-2">
                    <p class="text-xs text-gray-400">Tous les champs sont requis</p>
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Enregistrer
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>