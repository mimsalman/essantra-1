@extends('layouts.app')

@section('title', 'View Perfume')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">{{ $perfume->name }}</h1>

    <div class="flex gap-2">
        <a href="{{ route('admin.perfumes.edit', $perfume) }}" class="border px-4 py-2 rounded">Edit</a>
        <a href="{{ route('admin.perfumes.index') }}" class="border px-4 py-2 rounded">Back</a>
    </div>
</div>

<div class="bg-white border rounded-lg p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center h-80">
        @if($perfume->image)
            <img src="{{ asset('storage/'.$perfume->image) }}" class="w-full h-80 object-cover">
        @else
            <span class="text-gray-400">No Image</span>
        @endif
    </div>

    <div class="space-y-2">
        <p><b>Brand:</b> {{ $perfume->brand ?? '-' }}</p>
        <p><b>Category:</b> {{ $perfume->category ?? '-' }}</p>
        <p><b>Price:</b> LKR {{ number_format($perfume->price, 2) }}</p>
        <p><b>Stock:</b> {{ $perfume->stock }}</p>
        <p><b>Featured:</b> {{ $perfume->is_featured ? 'Yes' : 'No' }}</p>

        @if($perfume->description)
            <div class="mt-4">
                <p class="font-semibold">Description</p>
                <p class="text-gray-700">{{ $perfume->description }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
