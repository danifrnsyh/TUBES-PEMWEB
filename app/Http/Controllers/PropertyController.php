<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tampilkan semua property (untuk pembeli - browse)
    public function index()
    {
        $properties = Property::where('status', 'available')->paginate(12);
        return view('properties.index', compact('properties'));
    }

    // Tampilkan detail property
    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    // Hanya seller bisa akses - form create
    public function create()
    {
        $this->authorize('isSeller');
        return view('properties.create');
    }

    // Store property baru
    public function store(Request $request)
    {
        $this->authorize('isSeller');
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'type' => 'required|string',
            'area' => 'required|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['seller_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('properties', 'public');
            $validated['image'] = $path;
        }

        Property::create($validated);

        return redirect()->route('seller.properties')->with('success', 'Property berhasil ditambahkan!');
    }

    // Edit property
    public function edit(Property $property)
    {
        $this->authorize('update', $property);
        return view('properties.edit', compact('property'));
    }

    // Update property
    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'type' => 'required|string',
            'area' => 'required|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,sold,inactive',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('properties', 'public');
            $validated['image'] = $path;
        }

        $property->update($validated);

        return redirect()->route('seller.properties')->with('success', 'Property berhasil diubah!');
    }

    // Delete property
    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        $property->delete();

        return redirect()->route('seller.properties')->with('success', 'Property berhasil dihapus!');
    }
}
