<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name', 'Essantra'))</title>

    {{-- Tailwind via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">
    {{-- Top Bar --}}
    <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-lg tracking-tight">
                Essantra
            </a>

            <nav class="flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('shop.index') }}" class="hover:text-rose-600">Shop</a>

                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-rose-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-rose-600">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-3 py-2 rounded-md bg-rose-600 text-white hover:bg-rose-700">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    {{-- Page Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-sm text-gray-500">
            © {{ date('Y') }} Essantra. All rights reserved.
        </div>
    </footer>
</body>
</html>
