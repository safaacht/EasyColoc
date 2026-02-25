<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-black via-gray-900 to-purple-950 min-h-screen text-white">

    @include('layouts.header')
    
    <main class="container mx-auto mt-8">
        @yield('content')
    </main>
 
</body>
</html>