@extends('layouts.app')
@section('content')

    <!-- Hero Section -->
    <div class="flex flex-col justify-center items-center text-center px-6 mt-24">
        <h2 class="text-5xl font-extrabold mb-6 bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">
            Welcome to EasyColoc
        </h2>

        <p class="text-gray-300 max-w-2xl mb-10 text-lg">
            Find the perfect home, connect with compatible roommates, and start a new chapter with confidence.
            Your future home starts here.
        </p>

        <div class="space-x-4">
            <a href="{{ route('login') }}"
               class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 transition duration-300 shadow-lg">
               Get Started
            </a>

            <a href="#"
               class="px-8 py-3 rounded-xl border border-purple-500 hover:bg-purple-700 hover:border-purple-700 transition duration-300">
               Learn More
            </a>
        </div>
    </div>

@endsection