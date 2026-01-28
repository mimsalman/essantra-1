<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Essantra') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900">

    <header class="border-b">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-xl">Essantra</a>

            <nav class="flex items-center gap-3">
                <a href="{{ route('shop.index') }}" class="text-sm hover:underline">Shop</a>

                @guest
                    <a href="{{ route('login') }}" class="text-sm hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="text-sm hover:underline">Register</a>
                @endguest

                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm hover:underline">Dashboard</a>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.perfumes.index') }}" class="text-sm hover:underline">Admin</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="px-3 py-1.5 rounded-md border border-red-300 text-red-600 hover:bg-red-50 text-sm">
                            Logout
                        </button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <footer class="border-t">
        <div class="max-w-6xl mx-auto px-4 py-4 text-sm text-gray-500">
            © {{ date('Y') }} {{ config('app.name', 'Essantra') }}
        </div>
    </footer>

</body>
</html>
