<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');

        // Query the items table, excluding hidden items and filtering by search query if provided
        $items = Item::where('hidden', 0)
                    ->when($search, function ($query, $search) {
                        return $query->where(function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%')
                              ->orWhere('description', 'like', '%' . $search . '%');
                        });
                    })
                    ->get();

        return view('items.index', compact('items', 'search'));
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        // If the item is hidden, abort with a 404 error
        if ($item->hidden) {
            abort(404);
        }
        return view('items.show', compact('item'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        Log::info('Store method called'); // Log message to confirm method call

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Log::info('Validated Data:', $validatedData); // Log validated data

        // Handle the file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            Log::info('Image Path: ' . $imagePath); // Log image path
        }

        // Create the item
        $item = Item::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $imagePath,
            'hidden' => false, // By default, new items are not hidden
        ]);

        Log::info('Item Created:', $item->toArray()); // Log item creation

        if ($item) {
            return redirect()->route('items.index')->with('success', 'Item added successfully.');
        } else {
            return back()->withInput()->with('error', 'Failed to add the item.');
        }
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $item->image = $imagePath;
        }

        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->price = $request->input('price');
        $item->hidden = $request->input('hidden', false);

        $item->save();

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}
