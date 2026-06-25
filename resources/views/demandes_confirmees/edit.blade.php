<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier demande confirmée
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('demandes_confirmees.update', $demandesConfirmee) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Produit -->
<div class="mb-4">
    <label class="block text-gray-700">Produit (statut = done)</label>
    <select name="produit_id" class="w-full border rounded px-3 py-2">
        @foreach($demandesEssaiCloturees as $produit)
            <option value="{{ $produit->id }}"
                {{ $produit->id == $demandesConfirmee->produit_id ? 'selected' : '' }}>
                ID: {{ $produit->id }} 
                client: {{ $produit->client_name }}
                laboratoire: {{ $produit->laboratoire->nom ?? 'N/A' }}
                date réception: {{ optional($produit->date_reception)->format('d/m/Y') }}
            </option>
        @endforeach
    </select>
</div>


                    <!-- Numéro BC -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Numéro BC</label>
                        <input type="text" name="numero_bc"
                               value="{{ $demandesConfirmee->numero_bc }}"
                               class="w-full border rounded px-3 py-2" required>
                    </div>

                    <!-- Date réception BC -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Date réception BC</label>
                        <input type="date" name="date_reception_bc"
                               value="{{ optional($demandesConfirmee->date_reception_bc)->format('Y-m-d') }}"
                               class="w-full border rounded px-3 py-2" required>
                    </div>

                    <!-- Date réception échantillons -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Date réception échantillons</label>
                        <input type="date" name="date_reception_échantillons"
                               value="{{ optional($demandesConfirmee->date_reception_échantillons)->format('Y-m-d') }}"
                               class="w-full border rounded px-3 py-2" required>
                    </div>

                    <!-- Confirmation -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Confirmation</label>
                        <select name="confirmation" class="w-full border rounded px-3 py-2">
                            <option value="oui" {{ $demandesConfirmee->confirmation === 'oui' ? 'selected' : '' }}>Oui</option>
                            <option value="non" {{ $demandesConfirmee->confirmation === 'non' ? 'selected' : '' }}>Non</option>
                        </select>
                    </div>

                    <!-- Code rapport -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Code rapport</label>
                        <input type="text" name="code_rapport"
                               value="{{ $demandesConfirmee->code_rapport }}"
                               class="w-full border rounded px-3 py-2" required>
                    </div>

                    <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">
                        Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
