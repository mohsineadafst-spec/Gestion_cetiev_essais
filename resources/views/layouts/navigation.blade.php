<nav x-data="{ open: false }"
    class="bg-white/90 backdrop-blur-lg border-b border-gray-200 shadow-sm sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Left Side -->
            <div class="flex items-center gap-10">

                <!-- Logo -->
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center shadow-md">
                        <x-application-logo class="block h-6 w-auto fill-current text-white" />
                    </div>

                   
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden sm:flex items-center gap-3">

    {{-- Dashboard --}}
    <a href="{{ route('dashboard.index') }}"
       class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition duration-200
       {{ request()->routeIs('dashboard.index')
           ? 'bg-indigo-100 text-indigo-700'
           : 'text-gray-600 hover:bg-gray-100 hover:text-indigo-600' }}">
        {{-- Icône tableau de bord --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12h18M3 6h18M3 18h18"/>
        </svg>
        <span>Tableau de bord</span>
    </a>

    {{-- Chat --}}
    <a href="{{ route('chat.index') }}"
       class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition duration-200
       {{ request()->routeIs('chat.*')
           ? 'bg-indigo-100 text-indigo-700'
           : 'text-gray-600 hover:bg-gray-100 hover:text-indigo-600' }}">
        {{-- Icône chat --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-4 4z"/>
        </svg>
        <span>Messages</span>
    </a>

</div>

            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center gap-4">

                <!-- User Dropdown -->
                <x-dropdown align="right" width="56">

                    <x-slot name="trigger">
                        <button
                            class="flex items-center gap-3 px-4 py-2 rounded-2xl border border-gray-200 bg-white hover:bg-gray-50 shadow-sm transition">

                            <!-- Avatar -->
                            <div
                                class="w-9 h-9 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-semibold uppercase">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>

                            <!-- User Info -->
                            <div class="text-left hidden md:block">
                                <div class="text-sm font-semibold text-gray-800">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>

                            <!-- Arrow -->
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                             {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('chat.index')">
                             {{ __('Chat') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                                 {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>

                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">

                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open"
        x-transition
        class="sm:hidden border-t border-gray-100 bg-white">

        <div class="px-4 py-4 space-y-2">

            <a href="{{ route('dashboard.index') }}"
                class="block px-4 py-3 rounded-xl text-sm font-medium transition
                {{ request()->routeIs('dashboard.index')
                    ? 'bg-indigo-100 text-indigo-700'
                    : 'text-gray-700 hover:bg-gray-100' }}">
                Dashboard
            </a>

            <a href="{{ route('chat.index') }}"
                class="block px-4 py-3 rounded-xl text-sm font-medium transition
                {{ request()->routeIs('chat.*')
                    ? 'bg-indigo-100 text-indigo-700'
                    : 'text-gray-700 hover:bg-gray-100' }}">
                Chat
            </a>

        </div>

        <!-- Mobile User Info -->
        <div class="border-t border-gray-100 px-4 py-4">

            <div class="flex items-center gap-3 mb-4">

                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-semibold uppercase">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>

                <div>
                    <div class="font-semibold text-gray-800">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

            </div>

            <div class="space-y-2">

                <x-responsive-nav-link :href="route('profile.edit')">
                    👤 {{ __('Profile') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('chat.index')">
                    💬 {{ __('Chat') }}
                </x-responsive-nav-link>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                        🚪 {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

            </div>
        </div>
    </div>
</nav>