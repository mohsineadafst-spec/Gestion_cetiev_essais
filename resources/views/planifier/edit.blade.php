<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier la planification #{{ $planif->id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Affichage des erreurs --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulaire d’édition --}}
            <form action="{{ route('planifier.update', $planif->id) }}" method="POST" class="space-y-6 bg-white p-6 shadow rounded">
                @csrf
                @method('PUT')

                {{-- Demande confirmée + client --}}
                <div>
                    <label class="block font-medium">Demande confirmée :</label>
                    <p class="text-gray-700">
                        #{{ $planif->demandeConfirmee->id ?? 'N/A' }} —
                        Client : {{ $planif->demandeConfirmee->produit->client_name ?? 'N/A' }}
                    </p>
                </div>

                {{-- Essai --}}
                <div>
                    <label class="block font-medium">Essai :</label>
                    <p class="text-gray-700">
                        {{ $planif->demandeEssai->essai->nom_essai ?? 'N/A' }}
                    </p>
                </div>

                {{-- Intervenant --}}
                <div>
                    <label for="intervenant_id" class="block font-medium">Intervenant :</label>
                    <select name="intervenant_id" id="intervenant_id" class="w-full border rounded">
                        <option value="">-- Sélectionner --</option>
                        @foreach($intervenants as $user)
                            <option value="{{ $user->id }}" @if($planif->intervenant_id == $user->id) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Dates --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>Date réception :</label>
                        <input type="date" name="datereceptionechan" value="{{ $planif->datereceptionechan }}" class="w-full border rounded">
                    </div>
                    <div>
                        <label>Date prévue :</label>
                        <input type="datetime-local" name="dd_prevu" value="{{ $planif->dd_prevu }}" class="w-full border rounded">
                    </div>
                    <div>
                        <label>Date début :</label>
                        <input type="datetime-local" name="dd_p" value="{{ $planif->dd_p }}" class="w-full border rounded">
                    </div>
                    <div>
                        <label>Date fin :</label>
                        <input type="datetime-local" name="df_p" value="{{ $planif->df_p }}" class="w-full border rounded">
                    </div>
                </div>

                {{-- Rapport --}}
                <div>
                    <label>Rapport :</label>
                    <textarea name="Rapport_redige" class="w-full border rounded">{{ $planif->Rapport_redige }}</textarea>
                </div>

                {{-- Type de rapport --}}
                <div>
                    <label for="typerapport" class="block font-medium">Type de rapport :</label>
                    <select name="typerapport" id="typerapport" class="w-full border rounded">
                        <option value="intermediaire" @if($planif->typerapport == 'intermediaire') selected @endif>Intermédiaire</option>
                        <option value="finale" @if($planif->typerapport == 'finale') selected @endif>Finale</option>
                    </select>
                </div>

                {{-- Statut --}}
                <div>
                    <label for="statue" class="block font-medium">Statut :</label>
                    <select name="statue" id="statue" class="w-full border rounded">
                        <option value="en_attente" @if($planif->statue == 'en_attente') selected @endif>En attente</option>
                        <option value="en_cours" @if($planif->statue == 'en_cours') selected @endif>En cours</option>
                        <option value="termine" @if($planif->statue == 'termine') selected @endif>Terminé</option>
                        <option value="annule" @if($planif->statue == 'annule') selected @endif>Annulé</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour</button>
            </form>
        </div>
    </div>
</x-app-layout>
