@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">{{ $colocation->name }}</h1>

{{-- Membres --}}
<div class="bg-white p-6 rounded-xl shadow mb-6">
    <h2 class="font-semibold mb-4">Membres</h2>

    <table class="w-full">
        <thead>
        <tr class="border-b">
            <th class="text-left py-2">Nom</th>
            <th>Rôle</th>
            <th>Réputation</th>
        </tr>
        </thead>
        <tbody>
        @foreach($colocation->members as $member)
            <tr class="border-b">
                <td class="py-2">{{ $member->name }}</td>
                <td class="text-center">
                    @if($member->pivot->role === 'owner')
                        <span class="text-blue-500 font-semibold">Owner</span>
                    @else
                        Member
                    @endif
                </td>
                <td class="text-center">
                    {{ $member->reputation }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- Qui doit à qui --}}
<div class="bg-white p-6 rounded-xl shadow">
    <h2 class="font-semibold mb-4">Qui doit à qui</h2>

    @foreach($settlements as $settlement)
        <div class="flex justify-between items-center border-b py-2">
            <span>
                {{ $settlement['from'] }} doit {{ $settlement['amount'] }} MAD à {{ $settlement['to'] }}
            </span>

            <form method="POST" action="{{ route('settlements.pay', $settlement['id']) }}">
                @csrf
                <button class="bg-green-500 text-white px-4 py-1 rounded">
                    Marquer payé
                </button>
            </form>
        </div>
    @endforeach
</div>

@endsection