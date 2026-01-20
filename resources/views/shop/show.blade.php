@extends('layouts.store')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-2">

    {{-- BACK LINK --}}
    <a href="{{ route('shop.index') }}" class="text-sm underline mb-6 inline-block">
        ← Back to shop
    </a>

    {{-- IMAGE + DETAILS (SIDE BY SIDE) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-12">

        {{-- IMAGE --}}
        <div class="w-full overflow-hidden rounded-2xl">
            <img 
                src="{{ asset('storage/'.$perfume->image_path) }}" 
                class="w-full h-full object-cover"
                alt="{{ $perfume->name }}"
            >
        </div>


        {{-- DETAILS --}}
        <div class="bg-white border rounded-3xl p-8">
            <div class="flex justify-between items-start gap-4">
                <div>
                    <h1 class="text-3xl font-bold">{{ $perfume->name }}</h1>
                    <p class="text-gray-600 mt-1">Brand: {{ $perfume->brand }}</p>
                </div>

                <div class="text-2xl font-bold">
                    Rs. {{ number_format($perfume->price, 2) }}
                </div>
            </div>

            {{-- RATING --}}
            <div class="flex items-center gap-2 mt-4">
                <div class="flex text-yellow-500 text-lg">
                    @for($i = 0; $i < round($avgRating); $i++) ★ @endfor
                    @for($i = round($avgRating); $i < 5; $i++)
                        <span class="text-gray-300">★</span>
                    @endfor
                </div>
                <span class="text-sm text-gray-600">
                    {{ $avgRating }} / 5 ({{ $reviewCount }} reviews)
                </span>
            </div>

            {{-- META --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                <div class="border rounded-xl p-4">
                    <p class="text-sm text-gray-500">Stock</p>
                    <p class="font-semibold">{{ $perfume->stock }}</p>
                </div>

                <div class="border rounded-xl p-4">
                    <p class="text-sm text-gray-500">Gender</p>
                    <p class="font-semibold capitalize">{{ $perfume->gender }}</p>
                </div>

                <div class="border rounded-xl p-4">
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-semibold text-green-600">Available</p>
                </div>
            </div>

            <p class="mt-6 text-gray-700">
                {{ $perfume->description }}
            </p>
        </div>
    </div>
    {{-- END IMAGE + DETAILS --}}

    {{-- REVIEW FORM (FULL WIDTH) --}}
    <div class="bg-gray-50 border rounded-3xl p-8 mb-6 mt-4 relative z-10">
        <h2 class="text-xl font-bold mb-6">Write a review</h2>

        @auth
            <form method="POST" action="{{ route('reviews.store', $perfume) }}" class="space-y-5">
                @csrf

                <div>
                    <label class="text-sm font-semibold">Rating</label>
                    <select name="rating" class="w-full border rounded-xl p-3">
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold">Title</label>
                    <input name="title" class="w-full border rounded-xl p-3">
                </div>

                <div>
                    <label class="text-sm font-semibold">Comment</label>
                    <textarea name="comment" rows="4" class="w-full border rounded-xl p-3"></textarea>
                </div>

                <button class="px-8 py-3 bg-black text-white rounded-xl font-semibold hover:bg-gray-800">
                    Submit review
                </button>

                @if(session('success'))
                    <p class="text-green-600 text-sm mt-2">{{ session('success') }}</p>
                @endif
            </form>
        @else
            <p>
                Please <a href="{{ route('login') }}" class="underline font-semibold">login</a> to write a review.
            </p>
        @endauth
    </div>

    {{-- REVIEWS LIST (FULL WIDTH) --}}
    <div class="space-y-6">
        <h2 class="text-xl font-bold">Customer reviews</h2>

        @forelse($perfume->reviews->sortByDesc('created_at') as $review)
            <div class="border rounded-2xl p-6">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <p class="font-semibold">{{ $review->user->name }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $review->created_at->format('d M Y') }}
                        </p>
                    </div>

                    <div class="flex text-yellow-500">
                        @for($i = 0; $i < $review->rating; $i++) ★ @endfor
                        @for($i = $review->rating; $i < 5; $i++)
                            <span class="text-gray-300">★</span>
                        @endfor
                    </div>
                </div>

                @if($review->title)
                    <p class="mt-3 font-semibold">{{ $review->title }}</p>
                @endif

                <p class="mt-2 text-gray-700">{{ $review->comment }}</p>
            </div>
        @empty
            <p class="text-gray-600">No reviews yet.</p>
        @endforelse
    </div>

</div>
@endsection
