@extends('layouts.app')

@section('title', 'Manage ' . $colocation->name)

@section('content')
<div class="max-w-6xl mx-auto mt-12 px-6 pb-12" x-data="{ editingCategory: null, categoryName: '' }">
    <!-- Header -->
    <div class="mb-12">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('colocations.index') }}" class="text-blue-400 hover:text-blue-300 transition flex items-center gap-1 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Colocations
            </a>
        </div>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                    {{ $colocation->name }}
                </h1>
                <p class="text-gray-400 mt-2">Configuration and management for your shared living space.</p>
            </div>
            
            {{-- Quick Actions --}}
            <div class="flex items-center gap-3">
                @if(auth()->user()->ownsColocation($colocation))
                    <form action="{{ route('colocations.destroy', $colocation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to end this colocation? This will delete all data.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/20 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            End Colocation
                        </button>
                    </form>
                @else
                    <form action="{{ route('colocation.quitter') }}" method="POST" onsubmit="return confirm('Are you sure you want to leave?')">
                        @csrf
                        <button type="submit" class="bg-orange-500/10 hover:bg-orange-500 text-orange-500 hover:text-white border border-orange-500/20 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Leave Colocation
                        </button>
                    </form>
                @endif
                
                <div class="bg-emerald-600/10 border border-emerald-500/20 p-4 rounded-2xl flex items-center gap-4">
                    <div class="h-10 w-10 rounded-full bg-emerald-500/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest">Quick Tip</p>
                        <p class="text-xs text-gray-300">Keep expenses updated for fair settlements.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Add Expense Section (Primary Management Tool) --}}
            <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl border border-white/10 shadow-xl overflow-hidden relative">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="h-8 w-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </span>
                    Record New Expense
                </h2>
                
                <form method="POST" action="{{ route('colocations.expenses.store', $colocation->id) }}">
                    @csrf
                    <div class="space-y-6 mb-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-widest">Amount (MAD)</label>
                                <input type="number" step="0.01" name="amount" placeholder="0.00" 
                                       class="w-full bg-black/40 border border-white/10 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm text-gray-200 px-4 py-3.5 outline-none transition" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-widest">Category</label>
                                <select name="category_id" required
                                        class="w-full bg-black/40 border border-white/10 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm text-gray-200 px-4 py-3.5 outline-none appearance-none transition">
                                    <option value="" disabled selected>Select Category...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-widest">Description</label>
                            <input type="text" name="description" placeholder="What's this for? (e.g. Electricity, Pizza...)" 
                                   class="w-full bg-black/40 border border-white/10 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm text-gray-200 px-4 py-3.5 outline-none transition" required>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl transition duration-300 shadow-lg shadow-emerald-900/40 flex items-center justify-center gap-2">
                            <span>Save Expense</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Membres Section --}}
            <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl border border-white/10 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Members
                    </h2>
                    <span class="text-xs font-bold px-2 py-1 bg-blue-500/10 text-blue-400 rounded-lg border border-blue-500/20">
                        {{ $colocation->members->count() }} Total
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-gray-500 border-b border-white/5 uppercase text-xs tracking-wider">
                                <th class="text-left pb-4 font-semibold">Name</th>
                                <th class="text-center pb-4 font-semibold">Role</th>
                                <th class="text-center pb-4 font-semibold">Reputation</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($colocation->members as $member)
                                <tr class="group hover:bg-white/5 transition duration-200">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white uppercase">
                                                {{ substr($member->name, 0, 2) }}
                                            </div>
                                            <span class="text-gray-200 font-medium">{{ $member->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center">
                                        @if($member->pivot->type === 'owner')
                                            <span class="px-2 py-1 bg-amber-500/10 text-amber-500 rounded text-[10px] font-bold uppercase border border-amber-500/20">Owner</span>
                                        @else
                                            <span class="px-2 py-1 bg-blue-500/10 text-blue-400 rounded text-[10px] font-bold uppercase border border-blue-500/20">Member</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-center">
                                        <div class="flex items-center justify-center gap-1 text-emerald-400 font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $member->reputation }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Category Management (Owner Only) --}}
            @if(auth()->user()->ownsColocation($colocation))
                <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl border border-white/10 shadow-xl">
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Manage Categories
                    </h2>
                    
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-xs text-gray-500 mb-3 font-semibold uppercase tracking-wider">Existing Categories</p>
                            <div class="flex flex-wrap gap-2">
                                @forelse($categories as $category)
                                    <div class="flex items-center gap-2 px-3 py-1.5 bg-white/5 text-gray-300 rounded-lg text-xs border border-white/10 hover:border-purple-500/50 transition">
                                        <span>{{ $category->name }}</span>
                                        <div class="flex items-center gap-1.5 ml-1 border-l border-white/10 pl-1.5">
                                            <button @click="editingCategory = {{ $category->id }}; categoryName = '{{ $category->name }}'" class="text-gray-500 hover:text-blue-400 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </button>
                                            <form method="POST" action="{{ route('categories.destroy', $category->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-500 hover:text-red-400 transition" onclick="return confirm('Silently delete this category?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 italic">No categories created yet.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                            {{-- Add Form --}}
                            <div x-show="!editingCategory">
                                <p class="text-xs text-gray-500 mb-4 font-semibold uppercase tracking-wider">Add New Category</p>
                                <form method="POST" action="{{ route('categories.store') }}">
                                    @csrf
                                    <div class="space-y-3">
                                        <input type="text" name="name" placeholder="e.g. Electricity, Groceries..." 
                                               class="w-full bg-black/40 border border-white/10 rounded-lg focus:ring-purple-500 focus:border-purple-500 text-sm text-gray-200 px-3 py-2 outline-none" 
                                               required>
                                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded-lg transition duration-300 shadow-lg shadow-purple-900/20">
                                            Create Category
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Edit Form (Conditional) --}}
                            <div x-show="editingCategory" x-cloak>
                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-xs text-blue-400 font-semibold uppercase tracking-wider">Edit Category</p>
                                    <button @click="editingCategory = null" class="text-xs text-gray-500 hover:text-white">Cancel</button>
                                </div>
                                <form :action="'/categories/' + editingCategory" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-3">
                                        <input type="text" name="name" x-model="categoryName"
                                               class="w-full bg-black/40 border border-white/10 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-200 px-3 py-2 outline-none" 
                                               required>
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition duration-300 shadow-lg shadow-blue-900/20">
                                            Update Category
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Expense History Section --}}
            <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl border border-white/10 shadow-xl mt-8">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Recent Expenses
                </h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-gray-500 uppercase text-xs tracking-wider border-b border-white/5">
                            <tr>
                                <th class="text-left pb-4 font-semibold">Description</th>
                                <th class="text-left pb-4 font-semibold">Category</th>
                                <th class="text-left pb-4 font-semibold">Member</th>
                                <th class="text-right pb-4 font-semibold">Amount</th>
                                <th class="text-right pb-4 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($colocation->expenses->sortByDesc('created_at') as $expense)
                                <tr class="group hover:bg-white/5 transition duration-200">
                                    <td class="py-4">
                                        <div class="font-medium text-gray-200">{{ $expense->description }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $expense->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="py-4">
                                        <span class="px-2 py-1 bg-white/5 text-gray-400 rounded text-[10px] border border-white/10">
                                            {{ $expense->category->name }}
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="h-6 w-6 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center text-[10px] font-bold">
                                                {{ substr($expense->user->name, 0, 1) }}
                                            </div>
                                            <span class="text-gray-400 text-xs">{{ $expense->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-right">
                                        <span class="text-white font-bold">{{ number_format($expense->amount, 2) }}</span>
                                        <span class="text-[10px] text-gray-500 ml-1">MAD</span>
                                    </td>
                                    <td class="py-4 text-right">
                                        @if(auth()->id() === $expense->user_id || auth()->user()->ownsColocation($colocation))
                                            <form method="POST" action="{{ route('expenses.destroy', $expense->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-600 hover:text-red-400 transition" onclick="return confirm('Delete this expense?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-gray-500 italic">No expenses recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            
            {{-- Settlements Section --}}
            <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl border border-white/10 shadow-xl">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Settlements
                </h2>

                <div class="space-y-4">
                    @forelse($settlements as $settlement)
                        <div class="p-4 rounded-xl bg-white/5 border border-white/10 hover:border-emerald-500/30 transition duration-300">
                            <div class="flex justify-between items-start mb-3">
                                <div class="space-y-1">
                                    <p class="text-sm font-medium text-gray-200">
                                        <span class="text-red-400 font-bold">{{ $settlement['from'] }}</span>
                                        <span class="text-gray-500">owes</span>
                                    </p>
                                    <p class="text-sm font-medium text-gray-200">
                                        <span class="text-emerald-400 font-bold">{{ $settlement['to'] }}</span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-white">{{ number_format($settlement['amount'], 2) }}</p>
                                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">MAD</p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('settlements.pay', $settlement['id'] ?? $loop->index) }}">
                                @csrf
                                <button class="w-full bg-emerald-600/20 hover:bg-emerald-600 text-emerald-400 hover:text-white border border-emerald-600/30 font-bold py-2 rounded-lg text-sm transition duration-300">
                                    Mark as Paid
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="py-8 text-center bg-black/20 rounded-xl border border-dashed border-white/5">
                            <p class="text-gray-500 text-sm">Everything is settled! 🎉</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Invitation Form (Sidebar) --}}
            @if(auth()->user()->ownsColocation($colocation))
                <div class="bg-gradient-to-br from-blue-600/20 to-purple-600/20 backdrop-blur-md p-6 rounded-2xl border border-blue-500/20 shadow-xl">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Invite Roommate
                    </h2>
                    <p class="text-xs text-gray-400 mb-6">Send an invitation link to a potential new member.</p>
                    
                    <form method="POST" action="{{ route('colocation.invite') }}">
                        @csrf
                        <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs text-blue-300 font-bold mb-2 block uppercase tracking-widest">Available People</label>
                                <select name="email" required
                                        class="w-full bg-black/40 border-white/10 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-200 px-3 py-2.5 outline-none appearance-none">
                                    <option value="" disabled selected>Select a person to invite...</option>
                                    @foreach($availableUsers as $user)
                                        <option value="{{ $user->email }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex items-center gap-2 text-[10px] text-gray-500 italic px-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Only showing people not currently in any colocation.
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition duration-300 shadow-lg shadow-blue-900/20 flex items-center justify-center gap-2">
                                <span>Send Invitation</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection