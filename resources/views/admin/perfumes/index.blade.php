@extends('layouts.store')

@section('title', 'Admin - Perfumes')

@section('content')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-extrabold">Admin: Perfumes</h1>
        <p class="text-gray-600 mt-1">Manage your products and images.</p>
    </div>

    <a href="{{ route('admin.perfumes.create') }}"
       class="px-5 py-3 rounded-xl bg-rose-600 text-white font-semibold hover:bg-rose-700">
        + Add Perfume
    </a>
</div>

@if(session('success'))
    <div class="mt-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800">
        {{ session('success') }}
    </div>
@endif

<div class="mt-6 bg-white border rounded-2xl overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 text-sm text-gray-600">
            <tr>
                <th class="p-4">Image</th>
                <th class="p-4">Name</th>
                <th class="p-4">Brand</th>
                <th class="p-4">Price</th>
                <th class="p-4">Stock</th>
                <th class="p-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($perfumes as $p)
                <tr>
                    <td class="p-4">
                        <div class="h-12 w-16 rounded-lg bg-gray-100 overflow-hidden border">
                            @if($p->image_path)
                                <img src="{{ asset('storage/'.$p->image_path) }}" class="h-12 w-16 object-cover" alt="">
                            @endif
                        </div>
                    </td>
                    <td class="p-4 font-semibold">{{ $p->name }}</td>
                    <td class="p-4">{{ $p->brand }}</td>
                    <td class="p-4">Rs. {{ number_format($p->price,2) }}</td>
                    <td class="p-4">{{ $p->stock }}</td>
                    <td class="p-4">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.perfumes.edit', $p) }}"
                               class="px-3 py-2 rounded-lg border hover:bg-gray-50">Edit</a>

                            <form method="POST" action="{{ route('admin.perfumes.destroy', $p) }}"
                                  onsubmit="return confirm('Delete this perfume?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $perfumes->links() }}
</div>
@endsection
