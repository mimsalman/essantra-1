@extends('layouts.app')

@section('title', 'Admin - Perfumes')

@section('content')
<!-- BG image-->
    <div class="fixed inset-0 -z-10">
        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('images/perfume-bg3.jpg') }}');">
        </div>

        <!-- overlay contrast-->
        <!--<div class="absolute inset-0 bg-white/20"></div>-->
    </div>

    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-white">Admin: Perfumes</h1>

        <a href="{{ route('admin.perfumes.create') }}"
        class="bg-gray-900 hover:bg-black text-white font-semibold px-5 py-2.5 rounded-xl shadow transition">
            + Add Perfume
        </a>
    </div>
    <div>
    @include('admin.partials.tabs')
    </div>

<div class="bg-white border rounded-lg overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left p-3">Image</th>
                <th class="text-left p-3">Name</th>
                <th class="text-left p-3">Brand</th>
                <th class="text-left p-3">Price</th>
                <th class="text-left p-3">Stock</th>
                <th class="text-left p-3">Featured</th>
                <th class="text-right p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perfumes as $perfume)
                <tr class="border-b">
                    <td class="p-3">
                        <div class="w-14 h-14 bg-gray-100 rounded overflow-hidden flex items-center justify-center">
                            @if($perfume->image)
                                <img src="{{ asset('storage/'.$perfume->image) }}" class="w-14 h-14 object-cover">
                            @else
                                <span class="text-xs text-gray-400">No</span>
                            @endif
                        </div>
                    </td>
                    <td class="p-3 font-medium">{{ $perfume->name }}</td>
                    <td class="p-3 text-gray-600">{{ $perfume->brand ?? '-' }}</td>
                    <td class="p-3 font-semibold">LKR {{ number_format($perfume->price, 2) }}</td>
                    <td class="p-3">{{ $perfume->stock }}</td>
                    <td class="p-3">
                        @if($perfume->is_featured)
                            <span class="text-green-700 bg-green-100 px-2 py-1 rounded text-xs">Yes</span>
                        @else
                            <span class="text-gray-700 bg-gray-100 px-2 py-1 rounded text-xs">No</span>
                        @endif
                    </td>
                    <td class="p-3 text-right space-x-2">
                        <a href="{{ route('admin.perfumes.show', $perfume) }}" class="underline">View</a>
                        <a href="{{ route('admin.perfumes.edit', $perfume) }}" class="underline">Edit</a>

                        <form class="inline" method="POST" action="{{ route('admin.perfumes.destroy', $perfume) }}"
                              onsubmit="return confirm('Delete this perfume?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-6 text-center text-gray-600" colspan="7">
                        No perfumes yet. Click “Add Perfume”.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $perfumes->links() }}
</div>
@endsection
