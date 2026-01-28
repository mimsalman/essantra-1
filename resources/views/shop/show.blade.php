@extends('layouts.app')

@section('title', $perfume->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    <!-- LEFT: Image + TAGS + ACTION BUTTONS -->
    <div class="lg:col-span-7">
        <div class="bg-white border rounded-2xl overflow-hidden shadow-sm">
            <div class="aspect-[4/3] bg-gray-50 flex items-center justify-center">
                @if($perfume->image)
                    <img src="{{ asset('storage/'.$perfume->image) }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="text-gray-400 text-sm">No Image</div>
                @endif
            </div>

            <!-- Tags -->
            <div class="p-4 border-t bg-white">
                <div class="flex flex-wrap gap-2">
                    @if($perfume->category)
                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                            {{ $perfume->category }}
                        </span>
                    @endif

                    @if($perfume->brand)
                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                            {{ $perfume->brand }}
                        </span>
                    @endif

                    @if($perfume->is_featured)
                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-yellow-100 text-yellow-800">
                            Featured
                        </span>
                    @endif
                </div>

                <!-- ✅ ACTION BUTTONS MOVED HERE (blue marked area) -->
                @if(auth()->check() && !auth()->user()->is_admin)
                    <div class="mt-6 flex flex-wrap gap-3">
                        <!-- Add to Cart -->
                        <form method="POST" action="{{ route('cart.add', $perfume) }}">
                            @csrf
                            <input type="hidden" name="qty" value="1">
                            <button class="bg-gray-900 hover:bg-black text-white font-semibold px-5 py-2.5 rounded-xl shadow transition">
                                Add to Cart
                            </button>
                        </form>

                        <!-- Buy Now -->
                        <form method="POST" action="{{ route('cart.buyNow', $perfume) }}">
                            @csrf
                            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow transition">
                                Buy Now
                            </button>
                        </form>

                        <a href="{{ route('cart.index') }}"
                        class="border border-gray-300 hover:bg-gray-50 text-gray-800 font-semibold px-5 py-2.5 rounded-xl">
                            View Cart
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- RIGHT: Details + Review form -->
    <div class="lg:col-span-5 space-y-6">

        <!-- Product Details -->
        <div class="bg-white border rounded-2xl p-6 shadow-sm">
            <h1 class="text-3xl font-bold tracking-tight">{{ $perfume->name }}</h1>
            <p class="text-gray-600 mt-1">
                {{ $perfume->brand }}
                @if($perfume->category) • {{ $perfume->category }} @endif
            </p>

            <div class="mt-4 flex items-end justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500">Price</p>
                    <p class="text-2xl font-bold">LKR {{ number_format($perfume->price, 2) }}</p>
                </div>

                <div class="text-right">
                    <p class="text-sm text-gray-500">Availability</p>
                    @if($perfume->stock > 0)
                        <p class="text-sm font-semibold text-green-600">In Stock ({{ $perfume->stock }})</p>
                    @else
                        <p class="text-sm font-semibold text-red-600">Out of Stock</p>
                    @endif
                </div>
            </div>

            @if($avgRating)
                <div class="mt-4 flex items-center gap-2">
                    <div class="flex items-center text-yellow-500">
                        @php $stars = floor($avgRating); @endphp
                        @for($i=1; $i<=5; $i++)
                            <span class="{{ $i <= $stars ? '' : 'text-gray-300' }}">★</span>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-700">
                        <span class="font-semibold">{{ $avgRating }}</span>/5 average
                    </p>
                </div>
            @endif
        </div>

        @if($perfume->description)
            <div class="bg-white border rounded-2xl p-6 shadow-sm">
                <h2 class="font-semibold text-lg">Description</h2>
                <p class="text-gray-700 mt-2 leading-relaxed">{{ $perfume->description }}</p>
            </div>
        @endif

        @if(auth()->check() && !auth()->user()->is_admin)
            <!-- Review Form -->
            <div class="bg-white border rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-lg">Leave a Review</h2>
                    <span class="text-xs text-gray-500">1–5 rating</span>
                </div>

                <form method="POST" action="{{ route('reviews.store', $perfume) }}" class="mt-4 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium mb-1">Rating</label>
                        <select name="rating" class="border rounded-lg px-3 py-2 w-full">
                            @for($i=5; $i>=1; $i--)
                                <option value="{{ $i }}">{{ $i }} Star{{ $i>1?'s':'' }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Comment (optional)</label>
                        <textarea name="comment" rows="3"
                                class="border rounded-lg px-3 py-2 w-full"
                                placeholder="Write something about the perfume..."></textarea>
                    </div>

                    <button class="bg-gray-900 hover:bg-black text-white font-semibold px-5 py-2.5 rounded-lg shadow">
                        Submit Review
                    </button>
                </form>
            </div>
        @endif


    </div>
</div>

<!-- Reviews -->
<div class="mt-10">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Reviews</h2>
        <p class="text-sm text-gray-500">
            {{ $perfume->reviews->count() }} total
        </p>
    </div>

    @if($perfume->reviews->count() === 0)
        <div class="bg-white border rounded-2xl p-8 text-center text-gray-600 shadow-sm">
            No reviews yet. Be the first to review!
        </div>
    @else
        <div class="space-y-4">
            @foreach($perfume->reviews as $review)
                <div class="bg-white border rounded-2xl p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-semibold">{{ $review->user->name ?? 'User' }}</p>

                            <div class="flex items-center gap-2 mt-1">
                                <div class="text-yellow-500">
                                    @for($i=1; $i<=5; $i++)
                                        <span class="{{ $i <= $review->rating ? '' : 'text-gray-300' }}">★</span>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500">
                                    {{ $review->created_at?->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                        @auth
                            @if($review->user_id === auth()->id())
                                <form method="POST" action="{{ route('reviews.destroy', $review) }}"
                                      onsubmit="return confirm('Delete your review?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-sm text-red-600 hover:underline font-medium">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    @if($review->comment)
                        <p class="mt-3 text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                    @else
                        <p class="mt-3 text-gray-400 text-sm italic">No comment provided.</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
