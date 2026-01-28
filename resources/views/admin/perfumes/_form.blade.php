@php
    $isEdit = isset($perfume);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium mb-1">Name *</label>
        <input name="name" value="{{ old('name', $perfume->name ?? '') }}"
               class="border rounded px-3 py-2 w-full" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Brand</label>
        <input name="brand" value="{{ old('brand', $perfume->brand ?? '') }}"
               class="border rounded px-3 py-2 w-full">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Category</label>
        <input name="category" value="{{ old('category', $perfume->category ?? '') }}"
               class="border rounded px-3 py-2 w-full">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Price (LKR) *</label>
        <input type="number" step="0.01" name="price"
               value="{{ old('price', $perfume->price ?? '') }}"
               class="border rounded px-3 py-2 w-full" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Stock *</label>
        <input type="number" name="stock"
               value="{{ old('stock', $perfume->stock ?? 0) }}"
               class="border rounded px-3 py-2 w-full" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Image</label>
        <input type="file" name="image" class="border rounded px-3 py-2 w-full">

        @if($isEdit && $perfume->image)
            <p class="text-xs text-gray-600 mt-2">Current image:</p>
            <img src="{{ asset('storage/'.$perfume->image) }}" class="w-24 h-24 object-cover rounded mt-1">
        @endif
    </div>

    <div class="lg:col-span-2">
        <label class="block text-sm font-medium mb-1">Description</label>
        <textarea name="description" rows="4"
                  class="border rounded px-3 py-2 w-full">{{ old('description', $perfume->description ?? '') }}</textarea>
    </div>

    <div class="lg:col-span-2 flex items-center gap-2">
        <input type="checkbox" name="is_featured" value="1"
               {{ old('is_featured', $perfume->is_featured ?? false) ? 'checked' : '' }}>
        <label class="text-sm">Mark as Featured</label>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit"
            class="inline-flex items-center justify-center
                bg-blue-600 hover:bg-blue-700
                text-white font-semibold
                px-6 py-3 rounded-md
                shadow-md transition">
        {{ $isEdit ? 'Update Perfume' : 'Add Perfume' }}
    </button>


    <a href="{{ route('admin.perfumes.index') }}"
    class="inline-flex items-center justify-center
            border border-gray-400
            text-gray-700 hover:bg-gray-100
            px-6 py-3 rounded-md">
        Cancel
    </a>

</div>
