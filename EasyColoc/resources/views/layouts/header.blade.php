<nav class="sticky top-0 flex justify-between items-center px-10 py-6 bg-black/40 backdrop-blur-md shadow-lg w-full z-50">
    <a href="/" class="text-2xl font-bold text-blue-400">EasyColoc</a>

    <div class="space-x-6 flex items-center">
        @auth
            @if(in_array(Auth::user()->role, ['owner', 'membregenerale', 'admin']))
                <a href="{{ route('colocations.index') }}" 
                   class="px-5 py-2 rounded-lg bg-blue-600/20 hover:bg-blue-600 text-blue-400 hover:text-white transition duration-300 border border-blue-500/20">
                   Colocations
                </a>

                <a href="{{ route('dashboard') }}" 
                   class="px-5 py-2 rounded-lg bg-indigo-600/20 hover:bg-indigo-600 text-indigo-400 hover:text-white transition duration-300 border border-indigo-500/20">
                   Dashboard
                </a>
            @endif
            
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="px-5 py-2 rounded-lg bg-rose-600/20 hover:bg-rose-600 text-rose-400 hover:text-white transition duration-300 border border-rose-500/20">
                    Admin Panel
                </a>
            @endif

            <!-- Profile dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10 transition duration-300">
                    
                    {{-- Avatar initiale --}}
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-600 flex items-center justify-center text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <span class="text-sm text-gray-200">{{ auth()->user()->name }}</span>

                    {{-- Chevron --}}
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div x-show="open" x-cloak
                     @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 rounded-xl bg-gray-900 border border-white/10 shadow-xl overflow-hidden">
                    
                    <div class="px-4 py-3 border-b border-white/10">
                        <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>

                    <a href="{{ route('profile.show') }}"
                       class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        My profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-rose-400 hover:bg-white/10 transition text-left">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        @else
            <a href="{{ route('login') }}" class="hover:text-purple-400 transition">Login</a>
            <a href="{{ route('register') }}" class="px-5 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 transition duration-300">Register</a>
        @endauth
    </div>
</nav>