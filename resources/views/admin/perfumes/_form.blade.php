@csrf

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-semibold">Name</label>
        <input name="name" value="{{ old('name', $perfume->name ?? '') }}"
               class="mt-1 w-full border rounded-xl px-4 py-2" required>
    </div>

    <div>
        <label class="text-sm font-semibold">Brand</label>
        <input name="brand" value="{{ old('brand', $perfume->brand ?? '') }}"
               class="mt-1 w-full border rounded-xl px-4 py-2" required>
    </div>

    <div>
    <label class="text-sm font-semibold">Gender</label>
    <select name="gender" class="mt-1 w-full border rounded-xl px-4 py-2">
        @php $g = old('gender', $perfume->gender ?? 'unisex'); @endphp
        <option value="men" @selected($g==='men')>Men</option>
        <option value="women" @selected($g==='women')>Women</option>
        <option value="unisex" @selected($g==='unisex')>Unisex</option>
    </select>
    </div>

    <div class="flex items-center gap-2 mt-6">
        <input type="checkbox" name="is_featured" value="1"
            @checked(old('is_featured', $perfume->is_featured ?? false))>
        <label class="text-sm font-semibold">Mark as Featured</label>
    </div>


    <div>
        <label class="text-sm font-semibold">Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $perfume->price ?? '') }}"
               class="mt-1 w-full border rounded-xl px-4 py-2" required>
    </div>

    <div>
        <label class="text-sm font-semibold">Stock</label>
        <input type="number" name="stock" value="{{ old('stock', $perfume->stock ?? 0) }}"
               class="mt-1 w-full border rounded-xl px-4 py-2" required>
    </div>
</div>

<div class="mt-4">
    <label class="text-sm font-semibold">Description</label>
    <textarea name="description" rows="4"
              class="mt-1 w-full border rounded-xl px-4 py-2">{{ old('description', $perfume->description ?? '') }}</textarea>
</div>

<div class="mt-4">
    <label class="text-sm font-semibold">Image</label>
    <input type="file" name="image" class="mt-1 w-full">

    @if(!empty($perfume?->image_path))
        <img src="{{ asset('storage/'.$perfume->image_path) }}"
             class="mt-3 h-28 rounded-xl object-cover border" alt="">
    @endif
</div>

@if($errors->any())
    <div class="mt-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800">
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif
