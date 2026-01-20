<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Essantra') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-xl">Essantra</a>

            <div class="flex items-center gap-4">
                <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-black">Shop</a>

                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-black">Dashboard</a>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('admin.perfumes.index') }}" class="hover:text-rose-600">Admin</a>
                    @endif

                @endauth

                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg bg-black text-white hover:bg-gray-800">Login</a>
                @endguest
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t bg-white">
        <div class="max-w-7xl mx-auto px-4 py-6 text-sm text-gray-500">
            © {{ date('Y') }} Essantra. All rights reserved.
        </div>
    </footer>
</body>
</html>
