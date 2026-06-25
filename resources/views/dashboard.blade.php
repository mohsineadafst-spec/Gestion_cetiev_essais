<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tableau de bord</h2>
            <p class="text-sm text-gray-500 mt-0.5">Vue d'ensemble de l'activité</p>
        </div>
    </x-slot>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alertes --}}
            @if ($message = Session::get('error'))
                <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                    {{ $message }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                    <p class="font-semibold mb-2">Une erreur est survenue :</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="dashboardChartError" class="hidden p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                Impossible de charger les graphiques. Veuillez actualiser la page.
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
        document.addEventListener('DOMContentLoaded', () => {

            const showChartError = (error) => {
                console.error('Erreur dashboard:', error);
                const alert = document.getElementById('dashboardChartError');
                if (alert) alert.classList.remove('hidden');
            };

            const getCanvas = (id) => {
                const canvas = document.getElementById(id);
                if (!canvas) throw new Error(`Canvas introuvable: ${id}`);
                return canvas;
            };

            try {
                if (typeof Chart === 'undefined') throw new Error('Chart.js non chargé (CDN).');

                Chart.defaults.font.family = 'inherit';


                Chart.defaults.color = '#6b7280';

                const n = (v) => {
                    const num = Number(v);
                    return Number.isFinite(num) ? num : 0;
                };

                const safeLabels = @json($labels ?? []);
                const safeValues = @json($values ?? []);

                console.log('dashboard-data', {
                    DemandesFaites: n(@json($DemandesFaites ?? 0)),
                    DemandesEnCours: n(@json($DemandesEnCours ?? 0)),
                    DemandesAFaire: n(@json($DemandesAFaire ?? 0)),
                    DemandesReglementaires: n(@json($DemandesReglementaires ?? 0)),
                    DemandesDeveloppement: n(@json($DemandesDeveloppement ?? 0)),
                    clotures: n(@json($clotures ?? 0)),
                    totalEssais: n(@json($totalEssais ?? 0)),
                    labels: safeLabels,
                    values: safeValues,
                });


                const sharedOptions = {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 16, boxWidth: 12 } }
                    }
                };

                new Chart(getCanvas('statutDemandesChart'), {
                    type: 'bar',
                    data: {
                        labels: ['Faites', 'En cours', 'À faire'],
                        datasets: [{
                            data: [{{ (int) $DemandesFaites }}, {{ (int) $DemandesEnCours }}, {{ (int) $DemandesAFaire }}],

                            backgroundColor: ['#10b981', '#f97316', '#ef4444'],
                            borderRadius: 6,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        ...sharedOptions,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { display: false } },
                            y: { grid: { color: '#f3f4f6' }, ticks: { precision: 0 } }
                        }
                    }
                });

                new Chart(getCanvas('typesDemandesChart'), {
                    type: 'pie',
                    data: {
                        labels: ['Réglementaires', 'Développement'],
                        datasets: [{
                            data: [{{ (int) $DemandesReglementaires }}, {{ (int) $DemandesDeveloppement }}],
                            backgroundColor: ['#8b5cf6', '#3b82f6'],
                            borderWidth: 0,
                            hoverOffset: 6,
                        }]
                    },
                    options: sharedOptions
                });

                new Chart(getCanvas('clotureChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Clôturés', 'Non clôturés'],
                        datasets: [{
                            data: @json([(int) $clotures, max(0, (int) $totalEssais - (int) $clotures)]),
                            backgroundColor: ['#ef4444', '#10b981'],
                            borderWidth: 0,
                            hoverOffset: 6,
                            cutout: '70%',
                        }]
                    },
                    options: sharedOptions
                });

                new Chart(getCanvas('evolutionChart'), {
                    type: 'line',
                    data: {
                        labels: @json($labels ?? []),
                        datasets: [{
                            label: 'Demandes',
                            data: @json($values ?? []),
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99, 102, 241, 0.08)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#6366f1',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        ...sharedOptions,
                        scales: {
                            x: { grid: { display: false } },
                            y: { grid: { color: '#f3f4f6' }, ticks: { precision: 0 } }
                        }
                    }
                });

            } catch (error) {
                showChartError(error);
            }
        });
    </script>
    @endpush

</x-app-layout>
