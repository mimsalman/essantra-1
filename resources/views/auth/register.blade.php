
@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center">
    <div class="w-full max-w-6xl">

        <div class="relative overflow-hidden rounded-[2rem] border bg-white shadow-sm">
            <div class="absolute inset-0">
                {{-- bg image --}}
                <img src="{{ asset('images/perfume-bg1.jpg') }}" alt="Perfume" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-black/40"></div>

            <div class="relative grid grid-cols-1 lg:grid-cols-2">

                {{-- Left promo --}}
                <div class="p-10 lg:p-14 text-white">
                    <p class="text-xs tracking-[0.2em] uppercase text-white/80">ESSANTRA COLLECTION</p>
                    <h1 class="mt-3 text-4xl lg:text-5xl font-extrabold leading-tight">
                        Join <span class="text-white/90">PerfumeStore</span>
                    </h1>
                    <p class="mt-4 text-white/80 max-w-lg">
                        Create an account to place orders, track deliveries, and manage your reviews.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('shop.index') }}"
                           class="bg-white text-gray-900 font-semibold px-5 py-2.5 rounded-xl shadow hover:bg-gray-100 transition">
                            Browse Shop
                        </a>
                        <a href="{{ route('login') }}"
                           class="bg-white/10 border border-white/25 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-white/15 transition">
                            I have an account
                        </a>
                    </div>

                    <div class="mt-10 flex flex-wrap gap-2 text-xs text-white/70">
                        <span class="px-3 py-1 rounded-full border border-white/20 bg-white/10">Fast Checkout</span>
                        <span class="px-3 py-1 rounded-full border border-white/20 bg-white/10">Order Tracking</span>
                        <span class="px-3 py-1 rounded-full border border-white/20 bg-white/10">Member Offers</span>
                    </div>

                    <p class="mt-10 text-xs text-white/60">&copy; {{ date('Y') }} Essantra</p>
                </div>

                {{-- Right form (glass) --}}
                <div class="p-6 sm:p-10 lg:p-14 flex items-center justify-center">
                    <div class="w-full max-w-md">

                        <div class="relative overflow-hidden rounded-3xl">
                            <div class="absolute inset-0 bg-white/18 backdrop-blur-2xl"></div>
                            <div class="absolute inset-0 bg-black/25"></div>

                            <div class="relative p-8 sm:p-10">
                                <h2 class="text-3xl font-extrabold text-white">Create account</h2>
                                <p class="mt-1 text-white/80">Register to start shopping.</p>

                                @if ($errors->any())
                                    <div class="mt-5 rounded-xl border border-red-200/40 bg-red-500/15 text-red-100 px-4 py-3 text-sm">
                                        <ul class="list-disc ml-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
                                    @csrf

                                    <div>
                                        <label class="text-sm font-semibold text-white/80">Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                               class="mt-2 w-full rounded-xl px-4 py-3 bg-white/18 text-black placeholder-gray-500 border border-white/25 focus:outline-none focus:ring-2 focus:ring-white/50"
                                               placeholder="Your name">
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold text-white/80">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                               class="mt-2 w-full rounded-xl px-4 py-3 bg-white/18 text-black placeholder-gray-500 border border-white/25 focus:outline-none focus:ring-2 focus:ring-white/50"
                                               placeholder="you@example.com">
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold text-white/80">Password</label>
                                        <input type="password" name="password" required
                                               class="mt-2 w-full rounded-xl px-4 py-3 bg-white/18 text-black placeholder-gray-500 border border-white/25 focus:outline-none focus:ring-2 focus:ring-white/50"
                                               placeholder="••••••••">
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold text-white/80">Confirm Password</label>
                                        <input type="password" name="password_confirmation" required
                                               class="mt-2 w-full rounded-xl px-4 py-3 bg-white/18 text-black placeholder-gray-500 border border-white/25 focus:outline-none focus:ring-2 focus:ring-white/50"
                                               placeholder="••••••••">
                                    </div>

                                    <button type="submit"
                                            class="w-full bg-gray-900/70 hover:bg-gray-900 text-white font-semibold px-4 py-3 rounded-xl shadow transition border border-white/10">
                                        Register
                                    </button>

                                    <p class="text-sm text-white/80 text-center">
                                        Already have an account?
                                        <a href="{{ route('login') }}" class="font-semibold text-white underline underline-offset-4">
                                            Login
                                        </a>
                                    </p>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
