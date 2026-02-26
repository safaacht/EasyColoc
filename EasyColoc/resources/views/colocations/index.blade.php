@extends('layouts.app')

@section('title', 'My Colocations')

@section('content')
<div class="max-w-6xl mx-auto mt-12 px-6">
    <!-- Header Section -->
    <div class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-4xl font-extrabold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                My Colocations
            </h2>
            <p class="text-gray-400 mt-2">Manage your shared living spaces and expenses.</p>
        </div>
        <a href="{{ route('colocations.create') }}" 
           class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold transition duration-300 shadow-lg shadow-purple-900/20 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            New Colocation
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-500 px-4 py-3 rounded-xl mb-8">
            {{ session('success') }}
        </div>
    @endif

    <!-- Colocation Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($colocations as $colocation)
            <div class="group relative bg-black/40 backdrop-blur-md p-6 rounded-2xl border border-white/10 hover:border-purple-500/50 transition-all duration-300 shadow-xl">
                <!-- Status Badge -->
                <div class="absolute top-4 right-4">
                    @if($colocation->isActive)
                        <span class="px-2 py-1 text-xs font-bold bg-emerald-500/10 text-emerald-400 rounded-lg border border-emerald-500/20">Active</span>
                    @else
                        <span class="px-2 py-1 text-xs font-bold bg-gray-500/10 text-gray-400 rounded-lg border border-gray-500/20">Inactive</span>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors">
                        {{ $colocation->name }}
                    </h3>
                    @if($colocation->address)
                        <p class="text-gray-400 text-sm mt-1 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $colocation->address }}
                        </p>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3 mt-auto">
                    <a href="{{ route('colocations.show', $colocation) }}" 
                       class="flex-1 text-center py-2 rounded-lg bg-white/5 hover:bg-blue-600 transition duration-300 text-sm font-semibold">
                        Manage
                    </a>
                    <a href="{{ route('colocations.edit', $colocation) }}" 
                       class="p-2 rounded-lg bg-white/5 hover:bg-purple-600 transition duration-300 text-gray-400 hover:text-white"
                       title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                    </a>
                    <form action="{{ route('colocations.destroy', $colocation) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this colocation?');"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="p-2 rounded-lg bg-white/5 hover:bg-rose-600 transition duration-300 text-gray-400 hover:text-white"
                                title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-black/20 rounded-3xl border border-dashed border-white/10">
                <div class="mb-4 flex justify-center">
                    <div class="p-4 rounded-full bg-purple-500/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-200">No Colocations Yet</h3>
                <p class="text-gray-400 mt-2 max-w-sm mx-auto">Create your first colocation to start managing shared expenses with your roommates.</p>
                <a href="{{ route('colocations.create') }}" 
                   class="inline-block mt-8 px-8 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold transition duration-300">
                    Get Started
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection