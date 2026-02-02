{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center">
    <div class="w-full max-w-6xl">

        {{-- Background Card --}}
        <div class="relative overflow-hidden rounded-[2rem] border bg-white shadow-sm">
            {{-- Background image --}}
            <div class="absolute inset-0">
                {{-- ✅ put your image in: public/images/auth/perfume.jpg --}}
                <img src="{{ asset('images/perfume-bg1.jpg') }}" alt="Perfume" class="w-full h-full object-cover">
            </div>

            {{-- subtle dark overlay for contrast --}}
            <div class="absolute inset-0 bg-black/40"></div>

            <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-0">

                {{-- Left promo --}}
                <div class="p-10 lg:p-14 text-white">
                    <p class="text-xs tracking-[0.2em] uppercase text-white/80">ESSANTRA COLLECTION</p>
                    <h1 class="mt-3 text-4xl lg:text-5xl font-extrabold leading-tight">
                        Essantra <span class="text-white/90">Perfume Store</span>
                    </h1>
                    <p class="mt-4 text-white/80 max-w-lg">
                        Login to track your orders, manage your profile, and leave perfume reviews.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('shop.index') }}"
                           class="bg-white text-gray-900 font-semibold px-5 py-2.5 rounded-xl shadow hover:bg-gray-100 transition">
                            Visit Shop
                        </a>
                        <a href="{{ route('register') }}"
                           class="bg-white/10 border border-white/25 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-white/15 transition">
                            Create account
                        </a>
                    </div>

                    <div class="mt-10 flex flex-wrap gap-2 text-xs text-white/70">
                        <span class="px-3 py-1 rounded-full border border-white/20 bg-white/10">Long Lasting</span>
                        <span class="px-3 py-1 rounded-full border border-white/20 bg-white/10">Premium Quality</span>
                        <span class="px-3 py-1 rounded-full border border-white/20 bg-white/10">Secure Checkout</span>
                    </div>

                    <p class="mt-10 text-xs text-white/60">&copy; {{ date('Y') }} Essantra</p>
                </div>

                {{-- Right form (glass) --}}
                <div class="p-6 sm:p-10 lg:p-14 flex items-center justify-center">
                    <div class="w-full max-w-md">

                        {{-- ✅ Glass card --}}
                        <div class="relative overflow-hidden rounded-3xl">
                            <div class="absolute inset-0 bg-white/18 backdrop-blur-2xl"></div>
                            <div class="absolute inset-0 bg-black/25"></div>

                            <div class="relative p-8 sm:p-10">
                                <h2 class="text-3xl font-extrabold text-white">Welcome back</h2>
                                <p class="mt-1 text-white/80">Login to continue shopping.</p>

                                {{-- Errors --}}
                                @if ($errors->any())
                                    <div class="mt-5 rounded-xl border border-red-200/40 bg-red-500/15 text-red-100 px-4 py-3 text-sm">
                                        <ul class="list-disc ml-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                                    @csrf

                                    <div>
                                        <label class="text-sm font-semibold text-white/80">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                               class="mt-2 w-full rounded-xl px-4 py-3 bg-white/18 text-balck placeholder-white/60 border border-white/25 focus:outline-none focus:ring-2 focus:ring-white/50"
                                               placeholder="you@example.com">
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold text-white/80">Password</label>
                                        <input type="password" name="password" required
                                               class="mt-2 w-full rounded-xl px-4 py-3 bg-white/18 text-black placeholder-white/60 border border-white/25 focus:outline-none focus:ring-2 focus:ring-white/50"
                                               placeholder="••••••••">
                                    </div>

                                    <div class="flex items-center justify-between gap-3">
                                        <label class="inline-flex items-center gap-2 text-sm text-white/80">
                                            <input type="checkbox" name="remember"
                                                   class="rounded border-white/30 bg-white/10 text-white focus:ring-white/50">
                                            Remember me
                                        </label>

                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}"
                                               class="text-sm font-semibold text-white hover:underline">
                                                Forgot password?
                                            </a>
                                        @endif
                                    </div>

                                    <button type="submit"
                                            class="w-full bg-gray-900/70 hover:bg-gray-900 text-white font-semibold px-4 py-3 rounded-xl shadow transition border border-white/10">
                                        Login
                                    </button>

                                    <p class="text-sm text-white/80 text-center">
                                        Don’t have an account?
                                        <a href="{{ route('register') }}" class="font-semibold text-white underline underline-offset-4">
                                            Register
                                        </a>
                                    </p>
                                </form>
                            </div>
                        </div>
                        {{-- /glass card --}}

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
