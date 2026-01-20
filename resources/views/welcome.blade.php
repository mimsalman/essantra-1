@extends('layouts.store')

@section('title', 'Home')

@section('content')
    <section class="grid lg:grid-cols-2 gap-10 items-center">
        <div>
            <p class="text-sm font-semibold tracking-widest text-rose-600">PREMIUM PERFUME STORE</p>
            <h1 class="mt-3 text-4xl sm:text-5xl font-bold tracking-tight">
                Find your signature scent
            </h1>
            <p class="mt-4 text-gray-600 leading-relaxed">
                Explore luxury fragrances from top brands. Long-lasting scents, authentic products, and secure checkout.
            </p>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('shop.index') }}"
                   class="px-5 py-3 rounded-lg bg-rose-600 text-white font-semibold hover:bg-rose-700">
                    Shop Perfumes
                </a>
                <a href="#best-sellers"
                   class="px-5 py-3 rounded-lg border bg-white font-semibold hover:bg-gray-50">
                    Best Sellers
                </a>
            </div>

            <div class="mt-8 grid sm:grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-white border">
                    <p class="font-semibold">Authentic</p>
                    <p class="text-sm text-gray-600">100% genuine</p>
                </div>
                <div class="p-4 rounded-xl bg-white border">
                    <p class="font-semibold">Fast Delivery</p>
                    <p class="text-sm text-gray-600">Islandwide</p>
                </div>
                <div class="p-4 rounded-xl bg-white border">
                    <p class="font-semibold">Secure</p>
                    <p class="text-sm text-gray-600">Safe payments</p>
                </div>
            </div>
        </div>

        {{-- Hero image block (placeholder) --}}
        <div class="relative">
            <div class="rounded-3xl bg-gradient-to-br from-rose-100 via-white to-amber-100 border p-10">
                <div class="aspect-[4/3] rounded-2xl bg-white border flex items-center justify-center text-gray-500">
                    Hero Image (add later)
                </div>
                <p class="mt-4 text-sm text-gray-600">
                    Tip: later we’ll replace this with real product images from DB.
                </p>
            </div>
        </div>
    </section>

    <section id="best-sellers" class="mt-14">
        <div class="flex items-end justify-between">
            <div>
                <h2 class="text-2xl font-bold">Best Sellers</h2>
                <p class="text-gray-600">Our most popular picks this week.</p>
            </div>
            <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-rose-600 hover:text-rose-700">
                View all →
            </a>
        </div>

        {{-- Static cards for now (DB in Day 4) --}}
        <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featured as $perfume)
                <div class="bg-white border rounded-xl p-4">
                    <img src="{{ asset('storage/' . $perfume->image_path) }}"
                        class="h-48 w-full object-cover rounded-lg">

                    <h3 class="mt-3 font-bold">{{ $perfume->name }}</h3>
                    <p class="text-sm text-gray-500">{{ ucfirst($perfume->gender) }}</p>
                    <p class="mt-1 font-semibold">Rs. {{ number_format($perfume->price,2) }}</p>

                    <a href="{{ route('shop.show', $perfume) }}"
                    class="inline-block mt-3 text-sm font-semibold underline">
                        View →
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endsection
