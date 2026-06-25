<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tableau de bord</h2>
            <p class="text-sm text-gray-500 mt-0.5">Vue d'ensemble de l'activité</p>
        </div>
    </x-slot>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alertes --}}
            @if ($message = Session::get('error'))
                <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $message }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <p class="font-semibold mb-2">Une erreur est survenue :</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="dashboardChartError" class="hidden p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                Impossible de charger les graphiques du tableau de bord. Veuillez actualiser la page.
            </div>

            {{-- Cartes chiffrées --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="p-5 bg-white rounded-2xl border border-gray-200 shadow-sm">
                    <p class="text-xs text-gray-500 mb-0.5">Total demandes</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalDemandes }}</p>
                </div>
                <div class="p-5 bg-white rounded-2xl border border-gray-200 shadow-sm">
                    <p class="text-xs text-gray-500 mb-0.5">Demandes faites</p>
                    <p class="text-2xl font-bold text-green-600">{{ $DemandesFaites }}</p>
                </div>
                <div class="p-5 bg-white rounded-2xl border border-gray-200 shadow-sm">
                    <p class="text-xs text-gray-500 mb-0.5">En cours</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $DemandesEnCours }}</p>
                </div>
                <div class="p-5 bg-white rounded-2xl border border-gray-200 shadow-sm">
                    <p class="text-xs text-gray-500 mb-0.5">À faire</p>
                    <p class="text-2xl font-bold text-red-600">{{ $DemandesAFaire }}</p>
                </div>
                <div class="p-5 bg-white rounded-2xl border border-gray-200 shadow-sm">
                    <p class="text-xs text-gray-500 mb-0.5">Réglementaires</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $DemandesReglementaires }}</p>
                </div>
                <div class="p-5 bg-white rounded-2xl border border-gray-200 shadow-sm">
                    <p class="text-xs text-gray-500 mb-0.5">Développement</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $DemandesDeveloppement }}</p>
                </div>
            </div>

            {{-- Ligne 1 : Statut (bar) + Types (pie) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Statut des demandes</h3>
                    <canvas id="statutDemandesChart" class="max-h-56"></canvas>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Types de demandes</h3>
                    <canvas id="typesDemandesChart" class="max-h-56"></canvas>
                </div>
            </div>

            {{-- Ligne 2 : Clôture (doughnut) + Évolution (line) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Essais clôturés vs non clôturés</h3>
                    <canvas id="clotureChart" class="max-h-56"></canvas>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 lg:col-span-2">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Évolution mensuelle des demandes</h3>
                    <canvas id="evolutionChart" class="max-h-56"></canvas>
                </div>
            </div>

        </div>
    </div>


    @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
try {
    // Statut des demandes
    const ctxStatutDemandes = document.getElementById('statutDemandesChart');
    if (ctxStatutDemandes) {
        new Chart(ctxStatutDemandes, {
            type: 'bar',
            data: {
                labels: ['Faites', 'En cours', 'À faire'],
                datasets: [{
                    label: 'Demandes',
                    data: [{{ $DemandesFaites }}, {{ $DemandesEnCours }}, {{ $DemandesAFaire }}],
                    backgroundColor: ['#10b981','#f97316','#ef4444']
                }]
            }
        });
    }

    // Types de demandes
    const ctxTypesDemandes = document.getElementById('typesDemandesChart');
    if (ctxTypesDemandes) {
        new Chart(ctxTypesDemandes, {
            type: 'pie',
            data: {
                labels: ['Réglementaires', 'Développement'],
                datasets: [{
                    label: 'Types',
                    data: [{{ $DemandesReglementaires }}, {{ $DemandesDeveloppement }}],
                    backgroundColor: ['#8b5cf6','#3b82f6']
                }]
            }
        });
    }

    // Clôturés vs Non clôturés
    const ctxCloture = document.getElementById('clotureChart');
    if (ctxCloture) {
        new Chart(ctxCloture, {
            type: 'doughnut',
            data: {
                labels: ['Clôturés', 'Non clôturés'],
                datasets: [{
                    label: 'Essais',
                    data: [{{ $clotures }}, {{ $totalEssais - $clotures }}],
                    backgroundColor: ['#ef4444','#10b981']
                }]
            }
        });
    }

    // Évolution mensuelle
    const ctxEvolution = document.getElementById('evolutionChart');
    if (ctxEvolution) {
        new Chart(ctxEvolution, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Demandes',
                    data: {!! json_encode($values) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    fill: true,
                    tension: 0.3
                }]
            }
        });
    }
} catch (e) {
    document.getElementById('dashboardChartError').classList.remove('hidden');
    console.error(e);
}
</script>
@endpush


</x-app-layout>