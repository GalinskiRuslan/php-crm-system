<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Item_photo;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('item.index', compact('items'));
    }
    public function createNewItem(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'price' => 'double',
                'subcategory_id' => 'required|exists:categories,id',
                'brand_id' => 'exists:brands,id',
                'count' => 'integer'
            ]);
            $item = Item::create($validate);
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('public/items' . $item->id);
                    Item_photo::create(['item_id' => $item->id, 'path' => '/storage/' . str_replace('public/', '', $photoPath)]);
                }
            }
            return redirect()->back()->with('success', 'Item created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
