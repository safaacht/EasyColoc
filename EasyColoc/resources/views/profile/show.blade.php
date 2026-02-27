
@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-purple-950 p-6 text-white">

    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">
            Mon Profil
        </h2>
        <p class="text-gray-400 mt-2">Gérer vos informations personnelles et paramètres.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8">

        <!-- Profile Information -->
        <div class="bg-black/40 backdrop-blur-md p-8 rounded-2xl shadow-lg border border-purple-900">

            <h3 class="text-xl font-semibold text-purple-400 mb-6">
                Informations personnelles
            </h3>

            <form method="POST" action="#">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="text-gray-300">Nom</label>
                    <input type="text" value="{{ auth()->user()->name }}"
                        class="w-full mt-2 px-4 py-2 bg-gray-900 border border-purple-800 rounded-lg
                               text-white focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <div class="mb-6">
                    <label class="text-gray-300">Email</label>
                    <input type="email" value="{{ auth()->user()->email }}"
                        class="w-full mt-2 px-4 py-2 bg-gray-900 border border-purple-800 rounded-lg
                               text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <button type="submit"
                    class="px-6 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 transition shadow-lg">
                    Mettre à jour
                </button>
            </form>

        </div>


        <!-- Update Password -->
        <div class="bg-black/40 backdrop-blur-md p-8 rounded-2xl shadow-lg border border-blue-900">
            <div class="mb-4">
            <label class="text-gray-300 block">Reputation</label>
        
            <div class="w-full mt-2 px-4 py-2 bg-gray-900 border border-purple-800 rounded-lg text-purple-400 font-semibold">
                {{ auth()->user()->reputation ?? 0 }} ⭐
            </div>
            </div>

                
            </form>

        </div>

    </div>


    <!-- Delete Account -->
    <div class="mt-10 bg-black/40 backdrop-blur-md p-8 rounded-2xl shadow-lg border border-red-900">

        <h3 class="text-xl font-semibold text-red-400 mb-4">
            Supprimer le compte
        </h3>

        <p class="text-gray-400 mb-6">
            Cette action est irréversible. Toutes vos données seront supprimées définitivement.
        </p>

        <button
            class="px-6 py-2 rounded-xl bg-red-600 hover:bg-red-700 transition shadow-lg">
            Supprimer mon compte
        </button>

    </div>

</div>

@endsection