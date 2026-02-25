<aside class="fixed left-0 top-0 h-screen w-64 bg-[#13151F] border-r border-[#2A2D3A] flex flex-col">
    <div class="h-16 flex items-center px-6 border-b border-[#2A2D3A]">
        <span class="text-xl font-bold text-purple-400">
            ColocApp
        </span>
    </div>

    <nav class="flex-1 py-6 px-3 space-y-2">
        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded-lg text-slate-400 hover:bg-white/5 {{ request()->routeIs('dashboard') ? 'bg-white/5 text-white' : '' }}">
            Dashboard
        </a>

        @if(auth()->check() && auth()->user()->activeColocation)
            <a href="{{ route('colocations.show', auth()->user()->activeColocation->id) }}"
               class="block px-3 py-2 rounded-lg text-slate-400 hover:bg-white/5 {{ request()->routeIs('colocations.show') ? 'bg-white/5 text-white' : '' }}">
                Roommates
            </a>

            <a href="{{ route('expenses.index') }}"
               class="block px-3 py-2 rounded-lg text-slate-400 hover:bg-white/5 {{ request()->routeIs('expenses.index') ? 'bg-white/5 text-white' : '' }}">
                Expenses
            </a>

            <a href="{{ route('settlements.index') }}"
               class="block px-3 py-2 rounded-lg text-slate-400 hover:bg-white/5 {{ request()->routeIs('settlements.index') ? 'bg-white/5 text-white' : '' }}">
                Settlements
            </a>
        @else
            <div class="px-3 py-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">No Colocation</p>
                <a href="{{ route('colocations.create') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg bg-gradient-to-r from-purple-600 to-blue-600 text-white hover:opacity-90 transition">
                    <span>Create One</span>
                </a>
            </div>
        @endif

        @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}"
               class="block px-3 py-2 rounded-lg text-purple-400 hover:bg-white/5">
                Admin Panel
            </a>
        @endif
    </nav>

    <div class="p-4 border-t border-[#2A2D3A]">
        <p class="text-sm font-medium text-slate-200">
            {{ auth()->user()->name }}
        </p>
        <p class="text-xs text-slate-500">
            {{ auth()->user()->email }}
        </p>
    </div>
</aside>
