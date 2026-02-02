<div>
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold">Shop</h1>

        <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
            <input
                type="text"
                wire:model.live="q"
                placeholder="Search perfumes..."
                class="border rounded px-3 py-2 w-full sm:w-64"
            />

            <select wire:model.live="inStock" class="border rounded px-3 py-2">
                <option value="all">All</option>
                <option value="yes">In Stock</option>
                <option value="no">Out of Stock</option>
            </select>

            <div class="flex gap-2">
                <input type="number" wire:model.live="minPrice" class="border rounded px-3 py-2 w-28" placeholder="Min" />
                <input type="number" wire:model.live="maxPrice" class="border rounded px-3 py-2 w-28" placeholder="Max" />
            </div>
        </div>
    </div>

    @if($perfumes->count() === 0)
        <div class="bg-white border rounded p-6 text-center">
            No perfumes found.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($perfumes as $perfume)
                <a href="{{ route('shop.show', $perfume) }}" class="bg-white border rounded-lg overflow-hidden hover:shadow">
                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                        @if($perfume->image)
                            <img src="{{ asset('storage/'.$perfume->image) }}" class="h-48 w-full object-cover" />
                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif
                    </div>

                    <div class="p-4">
                        <h2 class="font-semibold text-lg">{{ $perfume->name }}</h2>
                        <p class="text-sm text-gray-600">
                            {{ $perfume->brand }}
                            @if($perfume->category) • {{ $perfume->category }} @endif
                        </p>

                        @php
                            $avg = (float) ($perfume->reviews_avg_rating ?? 0);
                            $full = floor($avg);
                            $half = ($avg - $full) >= 0.5;
                        @endphp

                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= $full)
                                        <span class="text-yellow-500">★</span>
                                    @elseif($half && $i == $full + 1)
                                        <span class="text-yellow-500">⯪</span>
                                    @else
                                        <span class="text-gray-300">★</span>
                                    @endif
                                @endfor
                            </div>

                            <span class="text-xs text-gray-500">
                                {{ number_format($avg, 1) }} ({{ $perfume->reviews_count ?? 0 }})
                            </span>
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            <span class="font-bold">LKR {{ number_format($perfume->price, 2) }}</span>
                            <span class="text-sm {{ $perfume->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $perfume->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $perfumes->links() }}
        </div>
    @endif
</div>