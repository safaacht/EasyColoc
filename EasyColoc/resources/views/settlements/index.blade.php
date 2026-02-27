@extends('layouts.app')

@section('title', 'Settlements')

@section('content')

<div class="bg-[#1A1D27] rounded-xl border border-[#2A2D3A] p-6 max-w-4xl mx-auto mt-8">
    <div class="flex justify-between items-center mb-8 border-b border-[#2A2D3A] pb-4">
        <h1 class="text-2xl font-bold text-slate-100">Settlements for {{ $colocation->name }}</h1>
    </div>

    @if($settlements->isEmpty())
        <div class="text-center py-12">
            <div class="text-slate-400 mb-4">
                <svg class="mx-auto h-12 w-12 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-slate-400">All settled up! No outstanding payments.</p>
        </div>
    @else
        <div class="grid gap-6">
            @foreach($settlements as $settlement)
                <div class="bg-[#232734] rounded-lg border border-[#2A2D3A] p-5 hover:border-blue-500/30 transition-colors">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col">
                                <span class="text-sm text-slate-400 uppercase tracking-wider mb-1">Payer</span>
                                <span class="text-slate-100 font-medium">{{ $settlement->payer->name }}</span>
                            </div>
                            <div class="text-slate-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-slate-400 uppercase tracking-wider mb-1">Receiver</span>
                                <span class="text-slate-100 font-medium">{{ $settlement->receiver->name }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="text-right">
                                <span class="text-sm text-slate-400 block mb-1">Amount</span>
                                <span class="text-2xl font-bold text-blue-400">{{ number_format($settlement->amount, 2) }} <span class="text-sm font-normal text-slate-500">MAD</span></span>
                            </div>

                            @if(!$settlement->payed)
                                <form method="POST" action="{{ route('settlements.pay', $settlement->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-medium transition-colors shadow-lg shadow-blue-500/20">
                                        Mark as Paid
                                    </button>
                                </form>
                            @else
                                <span class="bg-emerald-500/10 text-emerald-500 px-4 py-2 rounded-lg font-medium border border-emerald-500/20">
                                    Paid
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection