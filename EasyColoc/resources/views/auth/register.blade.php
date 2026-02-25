@extends('layouts.app')

@section('content')
    <div class="flex flex-col justify-center items-center py-12 px-6">
        <h2 class="text-4xl font-extrabold mb-8 bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">
            Join EasyColoc
        </h2>

        <div class="w-full max-w-md bg-black/40 backdrop-blur-md p-8 rounded-2xl shadow-lg">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label class="text-gray-300">Name</label>
                    <input type="text" name="name" required
                        class="w-full mt-2 px-4 py-2 bg-gray-900 border border-purple-800 rounded-lg
                               text-white focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <!-- Email -->
                <div>
                    <label class="text-gray-300">Email</label>
                    <input type="email" name="email" required
                        class="w-full mt-2 px-4 py-2 bg-gray-900 border border-purple-800 rounded-lg
                               text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Password -->
                <div>
                    <label class="text-gray-300">Password</label>
                    <input type="password" name="password" required
                        class="w-full mt-2 px-4 py-2 bg-gray-900 border border-purple-800 rounded-lg
                               text-white focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="text-gray-300">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full mt-2 px-4 py-2 bg-gray-900 border border-purple-800 rounded-lg
                               text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full px-8 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 
                           transition duration-300 shadow-lg">
                    Register
                </button>

                <!-- Login link -->
                <p class="text-center text-gray-400 text-sm">
                    Already have an account?
                    <a href="{{ route('login') }}" 
                       class="text-blue-400 hover:text-purple-400 transition">
                        Login
                    </a>
                </p>
            </form>
        </div>
    </div>
@endsection