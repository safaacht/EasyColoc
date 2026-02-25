@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="grid grid-cols-3 gap-6 mb-8">

    <div class="bg-[#1A1D27] p-6 rounded-xl border border-[#2A2D3A]">
        <p class="text-sm text-slate-500">Users</p>
        <h3 class="text-2xl font-bold text-slate-100">
            {{ $usersCount }}
        </h3>
    </div>

    <div class="bg-[#1A1D27] p-6 rounded-xl border border-[#2A2D3A]">
        <p class="text-sm text-slate-500">Colocations</p>
        <h3 class="text-2xl font-bold text-slate-100">
            {{ $colocationsCount }}
        </h3>
    </div>

    <div class="bg-[#1A1D27] p-6 rounded-xl border border-[#2A2D3A]">
        <p class="text-sm text-slate-500">Expenses</p>
        <h3 class="text-2xl font-bold text-slate-100">
            {{ $expensesCount }}
        </h3>
    </div>

</div>

@endsection