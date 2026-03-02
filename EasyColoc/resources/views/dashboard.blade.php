@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-purple-950 p-6 text-white">

    <!-- Bouton Ajouter Colocation -->
    @if(!auth()->user()->ownsAnyColocation())
    <div class="flex justify-end mb-6">
        <a href="{{ route('colocations.create')}}"
           class="px-6 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 transition shadow-lg">
           + Ajouter une colocation
        </a>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">

        <!-- Solde -->
        <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl shadow-lg border {{ $myBalance >= 0 ? 'border-green-900' : 'border-red-900' }}">
            <h3 class="text-gray-400 text-sm">Mon Solde</h3>
            <p class="text-3xl font-bold {{ $myBalance >= 0 ? 'text-green-400' : 'text-red-400' }} mt-2">
                {{ $myBalance >= 0 ? '+' : '' }} {{ number_format($myBalance, 2) }} DH
            </p>
        </div>

        <!-- Total Dépenses -->
        <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl shadow-lg border border-blue-900">
            <h3 class="text-gray-400 text-sm">Total Dépenses Colocation</h3>
            <p class="text-3xl font-bold text-blue-400 mt-2">{{ number_format($totalExpenses, 2) }} DH</p>
        </div>


    @if($colocation && !auth()->user()->ownsAnyColocation())
        <div class="mt-8">
            <form method="POST" action="{{ route('colocation.quitter') }}" onsubmit="return confirm('Are you sure you want to leave?')">
                @csrf
                <button type="submit" class="w-full py-4 bg-orange-600/20 hover:bg-orange-600 text-orange-400 hover:text-white border border-orange-600/30 rounded-2xl transition duration-300 font-bold flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Quitter la colocation
                </button>
            </form>
        </div>
    @endif

    @if(auth()->user()->ownsAnyColocation())
        @php $ownedColo = auth()->user()->colocations()->wherePivot('type', 'owner')->first(); @endphp
        @if($ownedColo && $ownedColo->isActive)
            <div class="mt-8 bg-red-600/10 border border-red-500/20 p-6 rounded-2xl">
                <h3 class="text-lg font-semibold text-red-400 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 17c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Owner Actions
                </h3>
                <form method="POST" action="{{ route('colocations.destroy', $ownedColo->id) }}" onsubmit="return confirm('Are you sure? This will end the colocation activities.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl transition duration-300 font-bold shadow-lg shadow-red-900/40">
                        End Colocation
                    </button>
                </form>
            </div>
        @endif
    @endif


    </div>

    <!-- Middle Section -->
    <div class="grid md:grid-cols-2 gap-8">

        <!-- Bar Chart -->
        <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl shadow-lg border border-purple-900">
            <h3 class="text-blue-400 mb-4 font-semibold">Dépenses par mois</h3>
            <canvas id="expensesChart"></canvas>
        </div>

        <!-- Qui doit quoi -->
        <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl shadow-lg border border-purple-900">
            <h3 class="text-purple-400 mb-4 font-semibold">Qui doit quoi ?</h3>

            <div class="space-y-4">
                @forelse($mySettlements as $settlement)
                    <div class="flex justify-between border-b border-gray-800 pb-2">
                        <span class="text-gray-300">
                            @if($settlement->payer_id == auth()->id())
                                Toi → {{ $settlement->receiver->name }}
                            @else
                                {{ $settlement->payer->name }} → Toi
                            @endif
                        </span>
                        <span class="{{ $settlement->payer_id == auth()->id() ? 'text-red-400' : 'text-green-400' }} font-semibold">
                            {{ number_format($settlement->amount, 2) }} DH
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm italic">Aucun règlement en attente.</p>
                @endforelse
            </div>

        </div>

    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('expensesChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['M-4', 'M-3', 'M-2', 'Last Month', 'This Month'],
            datasets: [{
                label: 'Dépenses (DH)',
                data: @json($monthlyExpenses),
                backgroundColor: [
                    '#3b82f6',
                    '#3b82f6',
                    '#3b82f6',
                    '#3b82f6',
                    '#9333ea'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: { color: 'white' }
                }
            },
            scales: {
                x: { ticks: { color: 'white' } },
                y: { ticks: { color: 'white' } }
            }
        }
    });
</script>

@endsection