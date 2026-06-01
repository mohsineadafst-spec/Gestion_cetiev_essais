<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2.5">
            <a href="{{ route('demandes_confirmees.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <span class="text-gray-300">/</span>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Nouvelle demande confirmée</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">

                <form method="POST" action="{{ route('demandes_confirmees.store') }}" class="space-y-6" x-data="{ selectedDemande: null }">
                    @csrf

                    {{-- Demande d'essai clôturée --}}
                    <div>
                        <label for="demande_essai_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Demande d'essai clôturée <span class="text-red-500">*</span>
                        </label>
                        <select id="demande_essai_id" name="demande_essai_id" 
                                @change="selectedDemande = $event.target.options[$event.target.selectedIndex].dataset"
                                class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('demande_essai_id') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }} text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                required>
                            <option value="">-- Sélectionner une demande d'essai --</option>
                            @foreach($demandesEssaiCloturees as $demande)
                                <option value="{{ $demande->id }}" 
                                        data-client="{{ $demande->demande->client_name }}" 
                                        data-laboratoire="{{ $demande->laboratoire_id }}">
                                    #{{ $demande->id }} - {{ $demande->essai->nom_essai }} - {{ $demande->laboratoire->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('demande_essai_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Client --}}
                    <div>
                        <label for="client" class="block text-sm font-semibold text-gray-700 mb-2">
                            Client <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="client" name="client" 
                               :value="selectedDemande?.client || '{{ old('client') }}'"
                               class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('client') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }} text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="Nom du client"
                               required>
                        @error('client')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date de réception --}}
                    <div>
                        <label for="date_reception" class="block text-sm font-semibold text-gray-700 mb-2">
                            Date de réception <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="date_reception" name="date_reception" value="{{ old('date_reception') }}"
                               class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('date_reception') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }} text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               required>
                        @error('date_reception')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Numéro BC --}}
                    <div>
                        <label for="numero_bc" class="block text-sm font-semibold text-gray-700 mb-2">
                            Numéro BC <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="numero_bc" name="numero_bc" value="{{ old('numero_bc') }}"
                               class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('numero_bc') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }} text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="Numéro du bon de commande"
                               required>
                        @error('numero_bc')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date réception BC --}}
                    <div>
                        <label for="date_reception_bc" class="block text-sm font-semibold text-gray-700 mb-2">
                            Date réception BC <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="date_reception_bc" name="date_reception_bc" value="{{ old('date_reception_bc') }}"
                               class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('date_reception_bc') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }} text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               required>
                        @error('date_reception_bc')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Laboratoire --}}
                    <div>
                        <label for="laboratoire_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Laboratoire <span class="text-red-500">*</span>
                        </label>
                        <select id="laboratoire_id" name="laboratoire_id"
                                :value="selectedDemande?.laboratoire || '{{ old('laboratoire_id') }}'"
                                class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('laboratoire_id') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }} text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                required>
                            <option value="">-- Sélectionner un laboratoire --</option>
                            @foreach($laboratoires as $lab)
                                <option value="{{ $lab->id }}" {{ old('laboratoire_id') == $lab->id ? 'selected' : '' }}>
                                    {{ $lab->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('laboratoire_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmation --}}
                    <div>
                        <label for="confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirmation <span class="text-red-500">*</span>
                        </label>
                        <select id="confirmation" name="confirmation"
                                class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('confirmation') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }} text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                required>
                            <option value="">-- Sélectionner --</option>
                            <option value="oui" {{ old('confirmation') == 'oui' ? 'selected' : '' }}>Oui</option>
                            <option value="non" {{ old('confirmation') == 'non' ? 'selected' : '' }}>Non</option>
                        </select>
                        @error('confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Code rapport --}}
                    <div>
                        <label for="code_rapport" class="block text-sm font-semibold text-gray-700 mb-2">
                            Code rapport <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="code_rapport" name="code_rapport" value="{{ old('code_rapport') }}"
                               class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('code_rapport') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }} text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="Code du rapport"
                               required>
                        @error('code_rapport')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Boutons --}}
                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                                class="flex-1 px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-150 shadow-md shadow-indigo-200">
                            Créer la demande
                        </button>
                        <a href="{{ route('demandes_confirmees.index') }}"
                           class="flex-1 px-6 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 active:scale-95 transition-all duration-150 text-center">
                            Annuler
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
