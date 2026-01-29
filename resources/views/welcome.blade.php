@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- HERO -->
<section class="relative border rounded-2xl shadow-sm overflow-hidden">

    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/perfume-bg2.jpg') }}"
             class="w-full h-full object-cover"
             alt="Perfume Background">
    </div>

    <!-- Dark overlay for readability -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-black/10"></div>

    <!-- Content -->
    <div class="relative p-8 lg:p-10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

            <!-- LEFT CONTENT -->
            <div class="max-w-2xl text-white">
                <p class="text-sm font-semibold text-white/70 tracking-wide uppercase">
                    Essantra Collection
                </p>

                <h1 class="mt-2 text-4xl font-extrabold tracking-tight">
                    Essantra Perfume Store
                </h1>

                <p class="mt-3 text-white/80 leading-relaxed">
                    Discover premium fragrances, explore trending scents, and share your experience with reviews.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('shop.index') }}"
                       class="bg-white text-gray-900 hover:bg-gray-100 font-semibold px-5 py-3 rounded-xl shadow">
                        Visit Shop
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="bg-white/10 border border-white/20 hover:bg-white/15 text-white font-semibold px-5 py-3 rounded-xl">
                            User Dashboard
                        </a>

                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-xl shadow">
                                Admin Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="bg-white/10 border border-white/20 hover:bg-white/15 text-white font-semibold px-5 py-3 rounded-xl">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                           class="bg-white text-gray-900 hover:bg-gray-100 font-semibold px-5 py-3 rounded-xl shadow">
                            Register
                        </a>
                    @endauth
                </div>
            </div>

            <!-- RIGHT QUICK LINKS -->
            <div class="w-full lg:w-[420px]">
                <div class="bg-white/10 border border-white/20 backdrop-blur-xl rounded-2xl p-6 shadow-lg">
                    <p class="font-semibold text-white mb-3">Quick Links</p>

                    <div class="space-y-2">
                        <a href="{{ route('shop.index') }}"
                           class="block text-white/90 hover:text-white underline">
                            Browse all perfumes
                        </a>

                        <a href="{{ route('register') }}"
                           class="block text-white/90 hover:text-white underline">
                            Create an account
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>



<!-- FEATURED -->
<section class="mt-10">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold">Featured Perfumes</h2>
        <a href="{{ route('shop.index') }}" class="text-sm font-medium underline text-gray-700 hover:text-gray-900">
            View all
        </a>
    </div>

    @if(isset($featured) && $featured->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featured as $perfume)
                <a href="{{ route('shop.show', $perfume) }}"
                   class="group bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">

                    <div class="relative bg-gray-50 aspect-[4/3] overflow-hidden">
                        @if($perfume->image)
                            <img src="{{ asset('storage/'.$perfume->image) }}"
                                 class="w-full h-full object-cover group-hover:scale-[1.03] transition duration-300" />
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                                No Image
                            </div>
                        @endif

                        <div class="absolute top-3 left-3">
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-yellow-100 text-yellow-800">
                                Featured
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="text-lg font-bold group-hover:underline">
                            {{ $perfume->name }}
                        </h3>

                        <p class="text-sm text-gray-600 mt-1">
                            {{ $perfume->brand ?? '—' }}
                            @if($perfume->category) • {{ $perfume->category }} @endif
                        </p>

                        <div class="mt-4 flex items-center justify-between">
                            <p class="font-bold">LKR {{ number_format($perfume->price, 2) }}</p>

                            @if($perfume->stock > 0)
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-100 text-green-700">
                                    In Stock
                                </span>
                            @else
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-red-100 text-red-700">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white border rounded-2xl p-8 text-center text-gray-600 shadow-sm">
            No featured perfumes yet. Admin can mark perfumes as “Featured”.
        </div>
    @endif
</section>

@endsection
