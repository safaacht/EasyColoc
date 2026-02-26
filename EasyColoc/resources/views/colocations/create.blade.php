@extends('layouts.app')

@section('title', 'Create Colocation')

@section('content')
<div class="max-w-4xl mx-auto mt-12 px-6">
    <div class="bg-black/40 backdrop-blur-md p-8 rounded-2xl shadow-lg border border-white/10">
        
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">
                Create a New Colocation
            </h2>
            <p class="text-gray-400 mt-2">Start your journey and invite your roommates.</p>
        </div>

        @if(session('error'))
            <div class="bg-rose-500/10 border border-rose-500/50 text-rose-500 px-4 py-3 rounded-xl mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('colocations.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label class="text-gray-300 font-medium block mb-2">Colocation Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    placeholder="e.g., The Chill House"
                    class="w-full px-4 py-3 bg-gray-950 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-purple-500 focus:outline-none transition">
                @error('name') <span class="text-rose-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Address -->
            <div>
                <label class="text-gray-300 font-medium block mb-2">Address</label>
                <input type="text" name="address" value="{{ old('address') }}"
                    placeholder="e.g., 123 Street Name, City"
                    class="w-full px-4 py-3 bg-gray-950 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                @error('address') <span class="text-rose-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Rules -->
            <div>
                <label class="text-gray-300 font-medium block mb-2">Internal Rules</label>
                <textarea name="rules" rows="4"
                    placeholder="Define the house rules..."
                    class="w-full px-4 py-3 bg-gray-950 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-purple-500 focus:outline-none transition">{{ old('rules') }}</textarea>
                @error('rules') <span class="text-rose-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit"
                    class="flex-1 px-8 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold transition duration-300 shadow-lg shadow-purple-900/20">
                    Create Colocation
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
