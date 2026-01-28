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
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'brand' => ['nullable','string','max:255'],
            'category' => ['nullable','string','max:255'],
            'price' => ['required','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'description' => ['nullable','string'],
            'is_featured' => ['nullable','boolean'],
            'image' => ['nullable','image','max:2048'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('perfumes', 'public');
        }

        Perfume::create($data);

        return redirect()->route('admin.perfumes.index')->with('success', 'Perfume created successfully.');
    }

    public function show(Perfume $perfume)
    {
        return view('admin.perfumes.show', compact('perfume'));
    }

    public function edit(Perfume $perfume)
    {
        return view('admin.perfumes.edit', compact('perfume'));
    }

    public function update(Request $request, Perfume $perfume)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'brand' => ['nullable','string','max:255'],
            'category' => ['nullable','string','max:255'],
            'price' => ['required','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'description' => ['nullable','string'],
            'is_featured' => ['nullable','boolean'],
            'image' => ['nullable','image','max:2048'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($perfume->image) {
                Storage::disk('public')->delete($perfume->image);
            }
            $data['image'] = $request->file('image')->store('perfumes', 'public');
        }

        $perfume->update($data);

        return redirect()->route('admin.perfumes.index')->with('success', 'Perfume updated successfully.');
    }

    public function destroy(Perfume $perfume)
    {
        if ($perfume->image) {
            Storage::disk('public')->delete($perfume->image);
        }

        $perfume->delete();

        return redirect()->route('admin.perfumes.index')->with('success', 'Perfume deleted successfully.');
    }
}
