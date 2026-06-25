<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Traçabilité</p>
                <h2 class="font-medium text-base text-gray-800 leading-tight">Audit des actions</h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filtres --}}
            <div class="flex flex-wrap items-center gap-2 mb-5">
                @php
                    $method = request('method');
                @endphp

                <a href="{{ route('logs.index') }}"
                   class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-md border transition-colors
                          {{ !$method ? 'bg-gray-100 text-gray-700 border-gray-200' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    Tous
                </a>

                <a href="{{ route('logs.index', ['method' => 'POST']) }}"
                   class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-md border transition-colors
                          {{ $method === 'POST' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Créations
                </a>

                <a href="{{ route('logs.index', ['method' => 'PUT']) }}"
                   class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-md border transition-colors
                          {{ $method === 'PUT' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                    </svg>
                    Modifications
                </a>

                <a href="{{ route('logs.index', ['method' => 'DELETE']) }}"
                   class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-md border transition-colors
                          {{ $method === 'DELETE' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    Suppressions
                </a>
            </div>

            {{-- Tableau --}}
            <div class="border border-gray-100 rounded-xl overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 w-44">Date</th>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 w-40">Utilisateur</th>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-500">Action</th>
                            <th class="text-right px-5 py-3 text-xs font-medium text-gray-500 w-20"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($logs as $log)
                            @php
                                $method = $log->method ?? '';
                                $badgeClass = match($method) {
                                    'POST'   => 'bg-green-50 text-green-700',
                                    'PUT'    => 'bg-blue-50 text-blue-700',
                                    'DELETE' => 'bg-red-50 text-red-700',
                                    default  => 'bg-gray-100 text-gray-600',
                                };
                                $userName = $log->user?->name ?? 'Invité';
                                $initials = collect(explode(' ', $userName))
                                    ->map(fn($w) => strtoupper($w[0] ?? ''))
                                    ->take(2)->implode('');
                            @endphp
                            <tr class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-5 py-3.5 text-gray-500 tabular-nums whitespace-nowrap text-xs">
                                    {{ $log->created_at->format('d/m/Y H:i:s') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-500 shrink-0">
                                            {{ $initials ?: '?' }}
                                        </div>
                                        <span class="{{ $log->user ? 'font-medium text-gray-800' : 'text-gray-400 italic' }} text-xs">
                                            {{ $userName }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-md {{ $badgeClass }}">
                                        {{ $log->readable_action }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <form action="{{ route('logs.destroy', $log->id) }}" method="POST"
                                          onsubmit="return confirm('Supprimer cet enregistrement d\'audit ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 text-xs text-red-500 hover:text-red-700 border border-red-200 hover:border-red-300 hover:bg-red-50 px-2.5 py-1 rounded-md transition-colors"
                                                aria-label="Supprimer cet audit">
                                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="bg-gray-50 border-t border-gray-100 px-5 py-3 flex items-center justify-between">
                    <p class="text-xs text-gray-400">{{ $logs->total() }} entrée(s)</p>
                    <div>{{ $logs->links() }}</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>