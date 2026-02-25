@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-purple-950 p-6 text-white">

    <!-- Bouton Ajouter Colocation -->
    <div class="flex justify-end mb-6">
        <a href="#"
           class="px-6 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 transition shadow-lg">
           + Ajouter une colocation
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">

        <!-- Solde -->
        <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl shadow-lg border border-purple-900">
            <h3 class="text-gray-400 text-sm">Mon Solde</h3>
            <p class="text-3xl font-bold text-green-400 mt-2">+ 1 250 DH</p>
        </div>

        <!-- Total Dépenses -->
        <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl shadow-lg border border-blue-900">
            <h3 class="text-gray-400 text-sm">Total Dépenses</h3>
            <p class="text-3xl font-bold text-red-400 mt-2">3 480 DH</p>
        </div>

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
                <div class="flex justify-between border-b border-gray-800 pb-2">
                    <span class="text-gray-300">Sara → Toi</span>
                    <span class="text-red-400 font-semibold">320 DH</span>
                </div>

                <div class="flex justify-between border-b border-gray-800 pb-2">
                    <span class="text-gray-300">Toi → Yassine</span>
                    <span class="text-blue-400 font-semibold">150 DH</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-300">Amine → Toi</span>
                    <span class="text-red-400 font-semibold">210 DH</span>
                </div>
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
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Dépenses (DH)',
                data: [800, 650, 900, 700, 430],
                backgroundColor: [
                    '#9333ea',
                    '#3b82f6',
                    '#9333ea',
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