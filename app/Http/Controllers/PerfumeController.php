<?php

namespace App\Http\Controllers;

use App\Models\Perfume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerfumeController extends Controller
{
    public function index()
    {
        $perfumes = Perfume::latest()->paginate(10);
        return view('admin.perfumes.index', compact('perfumes'));
    }

    public function create()
    {
        return view('admin.perfumes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'brand' => ['required','string','max:255'],
            'price' => ['required','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'description' => ['nullable','string'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'gender' => ['required','in:men,women,unisex'],
            'is_featured' => ['nullable','boolean'],

        ]);

        $validated['is_featured'] = $request->boolean('is_featured');


        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('perfumes', 'public');
            $validated['image_path'] = $path;
        }

        Perfume::create($validated);

        return redirect()->route('admin.perfumes.index')->with('success', 'Perfume created successfully!');
    }

    public function edit(Perfume $perfume)
    {
        return view('admin.perfumes.edit', compact('perfume'));
    }

    public function update(Request $request, Perfume $perfume)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'brand' => ['required','string','max:255'],
            'gender' => ['required','in:men,women,unisex'],
            'price' => ['required','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'description' => ['nullable','string'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'is_featured' => ['nullable','boolean'],
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($perfume->image_path) {
                Storage::disk('public')->delete($perfume->image_path);
            }
            $path = $request->file('image')->store('perfumes', 'public');
            $validated['image_path'] = $path;
        }

        $perfume->update($validated);

        return redirect()->route('admin.perfumes.index')->with('success', 'Perfume updated successfully!');
    }

    public function destroy(Perfume $perfume)
    {
        if ($perfume->image_path) {
            Storage::disk('public')->delete($perfume->image_path);
        }

        $perfume->delete();

        return redirect()->route('admin.perfumes.index')->with('success', 'Perfume deleted successfully!');
    }
}
