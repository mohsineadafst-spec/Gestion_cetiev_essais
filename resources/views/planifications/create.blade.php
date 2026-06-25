<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('planifications.index') }}"
               class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-indigo-500 mb-0.5">Planifications</p>
                <h2 class="text-2xl font-bold text-gray-900 leading-tight">Nouvelle planification</h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl px-5 py-4 flex gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <ul class="text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('planifications.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- ── Section 1 : Affectation ──────────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">1</span>
                        <h3 class="text-sm font-semibold text-gray-700">Affectation</h3>
                    </div>
                    <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- Demande confirmée --}}
                        <div class="sm:col-span-2">
                            <label for="demande_confirmee_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                Demande confirmée <span class="text-red-500">*</span>
                            </label>
                            <select name="demande_confirmee_id" id="demande_confirmee_id" required
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="" disabled selected>— Sélectionner une demande —</option>
                                @foreach($demandesConfirmees as $demande)
                                    <option value="{{ $demande->id }}" {{ old('demande_confirmee_id') == $demande->id ? 'selected' : '' }}>
                                        {{ $demande->essai->nom_essai ?? 'Essai inconnu' }} – {{ $demande->laboratoire->nom ?? 'Laboratoire inconnu' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Intervenant --}}
                        <div class="sm:col-span-2">
                            <label for="intervenant_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                Intervenant <span class="text-red-500">*</span>
                            </label>
                            <select name="intervenant_id" id="intervenant_id" required
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="" disabled selected>— Sélectionner un intervenant —</option>
                                @foreach($intervenants as $user)
                                    <option value="{{ $user->id }}" {{ old('intervenant_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                {{-- ── Section 2 : Dates ────────────────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">2</span>
                        <h3 class="text-sm font-semibold text-gray-700">Planification temporelle</h3>
                    </div>
                    <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

                        @foreach([
                            ['date_reception', 'Date de réception'],
                            ['date_debut',     'Date de début'],
                            ['date_fin',       'Date de fin'],
                            ['date_prevue',    'Date prévue'],
                            ['date_fin_reel',  'Date de fin réelle'],
                        ] as [$name, $label])
                        <div>
                            <label for="{{ $name }}" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                {{ $label }}
                            </label>
                            <input type="datetime-local" name="{{ $name }}" id="{{ $name }}"
                                   value="{{ old($name) }}"
                                   class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>
                        @endforeach

                    </div>
                </div>

                {{-- ── Section 3 : Paramètres ──────────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">3</span>
                        <h3 class="text-sm font-semibold text-gray-700">Paramètres</h3>
                    </div>
                    <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- Type rapport --}}
                        <div>
                            <label for="type_rapport" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                Type de rapport
                            </label>
                            <input type="text" name="type_rapport" id="type_rapport"
                                   value="{{ old('type_rapport') }}"
                                   placeholder="ex : Rapport final"
                                   class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>

                        {{-- Mode exécution --}}
                        <div>
                            <label for="mode_execution" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                Mode d'exécution
                            </label>
                            <select name="mode_execution" id="mode_execution"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="interne"      {{ old('mode_execution') === 'interne'      ? 'selected' : '' }}>Interne</option>
                                <option value="sous-traite"  {{ old('mode_execution') === 'sous-traite'  ? 'selected' : '' }}>Sous-traité</option>
                            </select>
                        </div>

                        {{-- Statut --}}
                        <div>
                            <label for="statut" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                Statut
                            </label>
                            <select name="statut" id="statut"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="todo"        {{ old('statut') === 'todo'        ? 'selected' : '' }}>À faire</option>
                                <option value="in_progress" {{ old('statut') === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="done"        {{ old('statut') === 'done'        ? 'selected' : '' }}>Terminé</option>
                                <option value="cancelled"   {{ old('statut') === 'cancelled'   ? 'selected' : '' }}>Annulé</option>
                            </select>
                        </div>

                        {{-- Action --}}
                        <div class="sm:col-span-2">
                            <label for="action" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                Action / Remarques
                            </label>
                            <textarea name="action" id="action" rows="4"
                                      placeholder="Décrivez les actions prévues ou toute remarque utile…"
                                      class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none">{{ old('action') }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- ── Footer actions ──────────────────────────────────── --}}
                <div class="flex items-center justify-end gap-3 pb-2">
                    <a href="{{ route('planifications.index') }}"
                       class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Créer la planification
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
