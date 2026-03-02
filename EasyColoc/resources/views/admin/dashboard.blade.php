@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="max-w-7xl mx-auto px-6 animate-fade-in">
    <!-- Page Header -->
    <div class="mb-10">
        <h2 class="text-4xl font-extrabold bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">
            Admin Performance Center
        </h2>
        <p class="text-slate-500 mt-2">Oversee community health and platform activity.</p>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-slate-900 shadow-2xl p-6 rounded-2xl border border-slate-800 transition transform hover:-translate-y-1">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Total Residents</p>
            <h3 class="text-3xl font-bold text-white">{{ $stats['total_users'] }}</h3>
        </div>

        <div class="bg-slate-900 shadow-2xl p-6 rounded-2xl border border-slate-800 transition transform hover:-translate-y-1">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Active Colocations</p>
            <h3 class="text-3xl font-bold text-indigo-400">{{ $stats['total_colocations'] }}</h3>
        </div>

        <div class="bg-slate-900 shadow-2xl p-6 rounded-2xl border border-rose-900/40 transition transform hover:-translate-y-1">
            <p class="text-xs font-bold text-rose-500 uppercase tracking-widest mb-1">Banned Entities</p>
            <h3 class="text-3xl font-bold text-rose-400">{{ $stats['total_banned'] }}</h3>
        </div>

        <div class="bg-slate-900 shadow-2xl p-6 rounded-2xl border border-slate-800 transition transform hover:-translate-y-1">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Pending Requests</p>
            <h3 class="text-3xl font-bold text-slate-300">{{ $stats['total_invitations'] }}</h3>
        </div>
    </div>

    <!-- User Management Table -->
    <div class="bg-slate-900 rounded-2xl border border-slate-800 shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-slate-800 flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">Member Directory</h3>
            <a href="{{ route('admin.export') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition shadow-lg shadow-indigo-900/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export to Excel
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-950/50">
                    <tr class="text-slate-500 text-xs uppercase tracking-widest">
                        <th class="px-6 py-4 font-bold">Identity</th>
                        <th class="px-6 py-4 font-bold">Role</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-right">Intervention</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach($users as $user)
                        <tr class="group hover:bg-slate-800/30 transition duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold uppercase shadow-lg shadow-indigo-900/20">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-200 group-hover:text-blue-400 transition-colors">{{ $user->name }}</p>
                                        <p class="text-[10px] text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-slate-800 text-slate-400 rounded-md text-[10px] uppercase font-bold tracking-tighter">{{ $user->role }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_banned)
                                    <span class="px-2 py-1 bg-rose-500/10 text-rose-500 rounded-md text-[10px] uppercase font-bold border border-rose-500/20">Banned</span>
                                @else
                                    <span class="px-2 py-1 bg-emerald-500/10 text-emerald-500 rounded-md text-[10px] uppercase font-bold border border-emerald-500/20">Active</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($user->id !== auth()->id())
                                    @if($user->is_banned)
                                        <form action="{{ route('admin.unban', $user->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-lg shadow-emerald-900/20">Release</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.ban', $user->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-lg shadow-rose-900/20">Restrict</button>
                                        </form>
                                    @endif
                                @else
                                    <span class="text-slate-600 text-[10px] uppercase font-bold">Admin Self</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="p-6 border-t border-slate-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

@endsection