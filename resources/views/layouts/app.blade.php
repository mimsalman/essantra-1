<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Essantra')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ Required for Jetstream / Livewire pages (ex: /user/profile) --}}
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Top Nav -->
    <nav class="bg-white border-b relative z-50">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-xl">Essantra</a>

            <div class="flex items-center gap-4">

                @auth

                    {{-- Home link (ONLY for users, NOT admin) --}}
                    @if(!auth()->user()->is_admin)
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 font-medium">
                            Home
                        </a>
                    @endif

                    {{-- Shop --}}
                    <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-gray-900 font-medium">
                        Shop
                    </a>

                    {{-- Dashboard link (ONLY for normal user) --}}
                    @if(!auth()->user()->is_admin)
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 font-medium">
                            Dashboard
                        </a>
                    @endif

                    {{-- Cart icon ONLY for users --}}
                    @if(!auth()->user()->is_admin)
                        <a href="{{ route('cart.index') }}"
                        class="relative inline-flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition"
                        title="Cart">

                            <!-- cart icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m14-9l2 9M10 22a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>

                            @if(collect(session('cart', []))->sum('qty') > 0)
                                <livewire:cart-counter />
                            @endif
                        </a>
                    @endif

                    {{-- Admin button --}}
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-4 py-2 rounded-xl bg-gray-900 text-white hover:bg-gray-800">
                            Admin
                        </a>
                    @endif

                    {{-- Profile picture icon (User -> Jetstream profile, Admin -> admin profile) --}}
                    @php
                        $user = auth()->user();
                        $photoUrl = $user->profile_photo_url ?? null; // Jetstream
                        $initial  = strtoupper(substr($user->name ?? 'U', 0, 1));

                        $profileIconRoute = $user->is_admin ? route('admin.profile') : url('/user/profile');
                    @endphp

                    <a href="{{ $profileIconRoute }}"
                       class="w-9 h-9 rounded-full bg-gray-100 border flex items-center justify-center overflow-hidden">
                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" class="w-full h-full object-cover" alt="Profile">
                        @else
                            <span class="text-sm font-bold text-gray-700">{{ $initial }}</span>
                        @endif
                    </a>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600 font-medium">
                            Logout
                        </button>
                    </form>

                @else
                    {{-- Guest Links --}}
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 font-medium">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-gray-900 hover:bg-black text-white px-3 py-2 rounded-md text-sm shadow">
                        Register
                    </a>
                @endauth

            </div>
        </div>
    </nav>


    <!-- Flash Message -->
    <div class="max-w-6xl mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mt-3">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mt-3">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Page Content -->
    <main class="max-w-6xl mx-auto px-4 py-6">
        {{-- ✅ Normal pages use @yield('content') --}}
        @hasSection('content')
            @yield('content')
        @else
            {{-- ✅ Jetstream / Livewire pages use $slot --}}
            {{ $slot ?? '' }}
        @endif
    </main>

    {{-- ✅ Required for Jetstream / Livewire pages --}}
    @livewireScripts
</body>
</html>