@extends('layouts.app')

@section('title', 'Expenses')

@section('content')

<div class="bg-[#1A1D27] rounded-xl border border-[#2A2D3A] p-6">

    <table class="w-full text-sm">
        <thead class="text-slate-500 border-b border-[#2A2D3A]">
            <tr>
                <th class="text-left py-3">Title</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Category</th>
                <th>Payer</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
                <tr class="border-b border-[#2A2D3A] hover:bg-white/5">
                    <td class="py-3 text-slate-200">{{ $expense->title }}</td>
                    <td>{{ $expense->amount }} MAD</td>
                    <td>{{ $expense->date }}</td>
                    <td>{{ $expense->category->name }}</td>
                    <td>{{ $expense->payer->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection