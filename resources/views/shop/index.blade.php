@extends('layouts.store')

@section('title', 'Shop')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">Shop Perfumes</h1>
            <p class="text-gray-600 mt-1">Browse our latest collection.</p>
        </div>

        <form method="GET" action="{{ route('shop.index') }}" class="w-full md:w-auto">
            <div class="flex gap-2">
                <input
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search by name or brand..."
                    class="w-full md:w-96 px-4 py-2 rounded-xl border bg-white focus:outline-none focus:ring-2 focus:ring-rose-200"
                />
                <div class="flex gap-2 mt-4">
                    <a href="{{ route('shop.index') }}"
                    class="px-4 py-2 rounded-full border {{ request('gender') ? '' : 'bg-black text-white' }}">
                        All
                    </a>

                    <a href="{{ route('shop.index', ['gender' => 'men']) }}"
                    class="px-4 py-2 rounded-full border {{ request('gender')==='men' ? 'bg-black text-white' : '' }}">
                        Men
                    </a>

                    <a href="{{ route('shop.index', ['gender' => 'women']) }}"
                    class="px-4 py-2 rounded-full border {{ request('gender')==='women' ? 'bg-black text-white' : '' }}">
                        Women
                    </a>

                    <a href="{{ route('shop.index', ['gender' => 'unisex']) }}"
                    class="px-4 py-2 rounded-full border {{ request('gender')==='unisex' ? 'bg-black text-white' : '' }}">
                        Unisex
                    </a>
                </div>


                <button class="px-5 py-2 rounded-xl bg-black text-white font-semibold hover:bg-gray-900">
                    Search
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($perfumes as $p)
            <div class="bg-white border rounded-3xl overflow-hidden hover:shadow-md transition">
                {{-- Image --}}
                <div class="aspect-[4/3] bg-gray-100">
                    @if($p->image_path)
                        <img src="{{ asset('storage/'.$p->image_path) }}"
                             class="w-full h-full object-cover" alt="{{ $p->name }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            No Image
                        </div>
                    @endif
                </div>

                <div class="p-5">
                    <p class="text-xs font-semibold text-gray-500">{{ $p->brand }}</p>
                    <h3 class="mt-1 font-bold text-lg">{{ $p->name }}</h3>

                    <div class="mt-4 flex items-center justify-between">
                        <span class="font-extrabold text-lg">Rs. {{ number_format($p->price, 2) }}</span>
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 border">
                            Stock: {{ $p->stock }}
                        </span>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('shop.show', $p) }}"
                           class="flex-1 text-center px-4 py-2 rounded-xl border font-semibold hover:bg-gray-50">
                            View
                        </a>

                        <button type="button"
                                class="flex-1 px-4 py-2 rounded-xl bg-rose-600 text-white font-semibold hover:bg-rose-700">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-600">No perfumes found.</p>
        @endforelse
    </div>

    <div class="pt-4">
        {{ $perfumes->links() }}
    </div>
</div>
@endsection
