<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Planification</p>
                <h2 class="font-medium text-base text-gray-800 leading-tight">Nouvelle planification</h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Erreurs --}}
            @if ($errors->any())
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
                    <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    <div>
                        <p class="text-xs font-medium text-red-700 mb-1">Erreur de validation</p>
                        <ul class="text-xs text-red-600 space-y-0.5 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('planifier.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Sélection demande --}}
                <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                    <label for="demande_confirme_id" class="block text-xs text-gray-500 mb-1.5">
                        Demande confirmée
                    </label>
                    <select name="demande_confirme_id" id="demande_confirme_id" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">-- Sélectionner --</option>
                        @foreach($demandesConfirmees as $demande)
                            <option value="{{ $demande->id }}">
                                {{ $demande->produit->nom ?? 'Demande' }} — #{{ $demande->produit_id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Liste des essais --}}
                <div id="essais-container" class="hidden bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                    <p class="text-xs text-gray-500 mb-3">Sélectionner les essais</p>
                    <div id="essais-list" class="flex flex-col gap-2"></div>
                </div>

                {{-- Formulaires dynamiques --}}
                <div id="formulaires-essais" class="space-y-4"></div>

                {{-- Soumission --}}
                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                    <p class="text-xs text-gray-400" id="essais-count"></p>
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                        </svg>
                        Créer les planifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const demandesData = {!! json_encode($demandesConfirmees) !!};

        const essaisContainer = document.getElementById('essais-container');
        const essaisList      = document.getElementById('essais-list');
        const formulaires     = document.getElementById('formulaires-essais');
        const essaisCount     = document.getElementById('essais-count');

        let checkedCount = 0;

        function updateCount() {
            essaisCount.textContent = checkedCount > 0
                ? `${checkedCount} essai(s) sélectionné(s)`
                : '';
        }

        document.getElementById('demande_confirme_id').addEventListener('change', function () {
            const demandeId = this.value;
            essaisList.innerHTML = '';
            formulaires.innerHTML = '';
            checkedCount = 0;
            updateCount();

            if (!demandeId) { essaisContainer.classList.add('hidden'); return; }

            const demande = demandesData.find(d => d.id == demandeId);
            if (!demande?.demandes_essais?.length) { essaisContainer.classList.add('hidden'); return; }

            essaisContainer.classList.remove('hidden');

            demande.demandes_essais.forEach(essai => {

                const label = document.createElement('label');
                label.className = 'flex items-center gap-3 px-3 py-2 rounded-lg border border-gray-100 bg-gray-50 cursor-pointer text-sm text-gray-700 hover:border-green-200 hover:bg-green-50 transition-colors select-none';
                label.innerHTML = `
                    <input type="checkbox" name="essais_planifies[${essai.id}][essai_id]"
                           value="${essai.id}"
                           class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <span>${essai.essai.nom_essai}</span>
                `;
                essaisList.appendChild(label);

                const checkbox = label.querySelector('input');

                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        checkedCount++;
                        label.classList.add('border-green-200', 'bg-green-50', 'text-green-700', 'font-medium');
                        label.classList.remove('border-gray-100', 'bg-gray-50', 'text-gray-700');

                        const card = document.createElement('div');
                        card.id = `form-essai-${essai.id}`;
                        card.className = 'bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden';
                        card.innerHTML = `
                            <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-800">${essai.essai.nom_essai}</p>
                                <span class="text-xs px-2 py-0.5 bg-green-50 text-green-700 border border-green-200 rounded-md">Sélectionné</span>
                            </div>
                            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <input type="hidden" name="essais_planifies[${essai.id}][essai_id]" value="${essai.id}">

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Date réception</label>
                                    <input type="date" name="essais_planifies[${essai.id}][date_reception]"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Date prévue</label>
                                    <input type="datetime-local" name="essais_planifies[${essai.id}][dd_prevu]"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Date début</label>
                                    <input type="datetime-local" name="essais_planifies[${essai.id}][date_debut]"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Date fin</label>
                                    <input type="datetime-local" name="essais_planifies[${essai.id}][date_fin]"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Intervenant</label>
                                    <select name="essais_planifies[${essai.id}][intervenant_id]"
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="">-- Sélectionner --</option>
                                        @foreach($intervenants as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Type de rapport</label>
                                    <select name="essais_planifies[${essai.id}][type_rapport]"
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="intermediaire">Intermédiaire</option>
                                        <option value="finale">Finale</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Statut</label>
                                    <select name="essais_planifies[${essai.id}][statut]"
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="en_attente">En attente</option>
                                        <option value="en_cours">En cours</option>
                                        <option value="termine">Terminé</option>
                                        <option value="annule">Annulé</option>
                                    </select>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-xs text-gray-500 mb-1.5">Rapport rédigé</label>
                                    <textarea name="essais_planifies[${essai.id}][Rapport_redige]" rows="3"
                                              placeholder="Saisir le rapport..."
                                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm resize-y focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                                </div>
                            </div>
                        `;
                        formulaires.appendChild(card);
                    } else {
                        checkedCount--;
                        label.classList.remove('border-green-200', 'bg-green-50', 'text-green-700', 'font-medium');
                        label.classList.add('border-gray-100', 'bg-gray-50', 'text-gray-700');
                        document.getElementById(`form-essai-${essai.id}`)?.remove();
                    }
                    updateCount();
                });
            });
        });
    </script>
</x-app-layout>