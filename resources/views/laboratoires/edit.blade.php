<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le laboratoire : ') }} {{ $laboratoire->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('laboratoires.update', $laboratoire) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nom du laboratoire -->
                        <div class="mb-6">
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom du laboratoire *
                            </label>
                            <input type="text" id="nom" name="nom" value="{{ old('nom', $laboratoire->nom) }}" 
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('nom') border-red-500 @enderror"
                                   required>
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email principal -->
                        <div class="mb-6">
                            <label for="email_principal" class="block text-sm font-medium text-gray-700 mb-2">
                                Email principal
                            </label>
                            <input type="email" id="email_principal" name="email_principal" value="{{ old('email_principal', $laboratoire->email_principal) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email_principal') border-red-500 @enderror">
                            @error('email_principal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Téléphone -->
                        <div class="mb-6">
                            <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                                Téléphone
                            </label>
                            <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', $laboratoire->telephone) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('telephone') border-red-500 @enderror">
                            @error('telephone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Responsable -->
                        <div class="mb-6">
                            <label for="responsable_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Responsable
                            </label>
                            <select id="responsable_id" name="responsable_id"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('responsable_id') border-red-500 @enderror">
                                <option value="">-- Aucun responsable --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('responsable_id', $laboratoire->responsable_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->username }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('responsable_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                       {{ old('is_active', $laboratoire->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="ml-2 text-sm text-gray-700">
                                    Laboratoire actif
                                </label>
                            </div>
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">
                                <strong>Créé le :</strong> {{ $laboratoire->created_at->format('d/m/Y à H:i') }}<br>
                                <strong>Modifié le :</strong> {{ $laboratoire->updated_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>

                        <!-- Boutons -->
                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('laboratoires.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                Annuler
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
