@extends('layouts.app')

@section('title', 'Edit Colocation')

@section('content')
<div class="max-w-4xl mx-auto mt-12 px-6">
    <div class="bg-black/40 backdrop-blur-md p-8 rounded-2xl shadow-lg border border-white/10">
        
        <div class="mb-8 flex justify-between items-start">
            <div>
                <h2 class="text-3xl font-extrabold bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">
                    Edit Colocation
                </h2>
                <p class="text-gray-400 mt-2">Update the details of your shared space.</p>
            </div>
            <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs">
                <span class="w-2 h-2 rounded-full {{ $colocation->isActive ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-gray-500' }}"></span>
                <span class="text-gray-300 font-medium">{{ $colocation->isActive ? 'Active' : 'Inactive' }}</span>
            </div>
        </div>

        @if(session('error'))
            <div class="bg-rose-500/10 border border-rose-500/50 text-rose-500 px-4 py-3 rounded-xl mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('colocations.update', $colocation) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div>
                <label class="text-gray-300 font-medium block mb-2">Colocation Name</label>
                <input type="text" name="name" value="{{ old('name', $colocation->name) }}" required
                    class="w-full px-4 py-3 bg-gray-950 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-purple-500 focus:outline-none transition">
                @error('name') <span class="text-rose-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Address -->
            <div>
                <label class="text-gray-300 font-medium block mb-2">Address</label>
                <input type="text" name="address" value="{{ old('address', $colocation->address) }}"
                    class="w-full px-4 py-3 bg-gray-950 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                @error('address') <span class="text-rose-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Rules -->
            <div>
                <label class="text-gray-300 font-medium block mb-2">Internal Rules</label>
                <textarea name="rules" rows="4"
                    class="w-full px-4 py-3 bg-gray-950 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-purple-500 focus:outline-none transition">{{ old('rules', $colocation->rules) }}</textarea>
                @error('rules') <span class="text-rose-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Status Toggle (Simulated) -->
            <div class="flex items-center gap-3 py-2">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="isActive" value="1" @checked(old('isActive', $colocation->isActive)) class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-800 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
                <span class="text-gray-300 text-sm font-medium">This colocation is active</span>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit"
                    class="flex-1 px-8 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold transition duration-300 shadow-lg shadow-purple-900/20">
                    Save Changes
                </button>
                <a href="{{ route('colocations.index') }}"
                   class="px-8 py-3 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 transition duration-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
