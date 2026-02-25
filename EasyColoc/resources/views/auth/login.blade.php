@extends('layouts.app')
@section('content')


    <div class="flex flex-col justify-center items-center py-12 px-6">

        <h2 class="text-4xl font-extrabold mb-8 bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">
            Login to EasyColoc
        </h2>

        <div class="w-full max-w-md bg-black/40 backdrop-blur-md p-8 rounded-2xl shadow-lg">

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="text-gray-300">Email</label>
                    <input type="email" name="email" required autofocus
                        class="w-full mt-2 px-4 py-2 bg-gray-900 border border-purple-800 rounded-lg
                               text-white focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <!-- Password -->
                <div>
                    <label class="text-gray-300">Password</label>
                    <input type="password" name="password" required
                        class="w-full mt-2 px-4 py-2 bg-gray-900 border border-purple-800 rounded-lg
                               text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Remember -->
                <div class="flex items-center justify-between text-sm text-gray-400">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2 accent-purple-600">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="hover:text-purple-400 transition">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 
                           transition duration-300 shadow-lg">
                    Login
                </button>

                <!-- Register link -->
                <p class="text-center text-gray-400 text-sm">
                    Don’t have an account?
                    <a href="{{ route('register') }}" 
                       class="text-purple-400 hover:text-blue-400 transition">
                        Register
                    </a>
                </p>

            </form>

        </div>
    </div>
@endsection