@extends('layouts.app')

@section('title', 'Settlements')

@section('content')

<div class="bg-[#1A1D27] rounded-xl border border-[#2A2D3A] p-6">

    @foreach($settlements as $settlement)

        <div class="mb-6">

            <div class="flex justify-between mb-2">
                <span class="text-slate-300">
                    {{ $settlement['from'] }} → {{ $settlement['to'] }}
                </span>

                <span class="font-bold text-slate-100">
                    {{ $settlement['amount'] }} MAD
                </span>
            </div>

            <div class="h-2 bg-[#2A2D3A] rounded-full mb-3">
                <div class="h-2 bg-blue-500 rounded-full"
                     style="width: {{ $settlement['percentage'] }}%">
                </div>
            </div>

            <form method="POST" action="{{ route('settlements.pay', $settlement['id']) }}">
                @csrf
                <button class="text-xs text-blue-400 border border-blue-500/30 rounded-md px-3 py-1 hover:bg-blue-500/10">
                    Settle Up
                </button>
            </form>

        </div>

    @endforeach

</div>

@endsection