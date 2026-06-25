<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails de la planification #{{ $planification->id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow rounded">
            <ul class="space-y-2">
                <li><strong>Demande confirmée :</strong> {{ $planification->demande_confirme_id ?? 'N/A' }}</li>
                <li><strong>Essai :</strong> {{ $planification->demandeEssai->essai->nom_essai ?? 'N/A' }}</li>
                <li><strong>Intervenant :</strong> {{ $planification->intervenant->name ?? 'N/A' }}</li>
                <li><strong>Date prévue :</strong> {{ $planification->dd_prevu }}</li>
                <li><strong>État :</strong> {{ $planification->etat }}</li>
                <li><strong>Rapport :</strong> {{ $planification->Rapport_redige }}</li>
            </ul>

            <div class="mt-4">
                <a href="{{ route('planifier.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Retour</a>
            </div>
        </div>
    </div>
</x-app-layout>
