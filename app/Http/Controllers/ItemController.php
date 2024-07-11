<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Item;
use App\Models\Item_photo;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('item_photos')->with('subcategory')->get();
        $subcategories = Subcategory::all();
        $brands = Brands::all();
        return view('item.index', compact('items', 'subcategories', 'brands'));
    }
    public function createNewItem(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'price' => 'required',
                'subcategory_id' => 'required|exists:subcategories,id',
                'brand_id' => 'nullable|exists:brands,id',
                'count' => 'integer'
            ]);
            $item = Item::create($validate);

            if ($request->hasFile('photos')) {

                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('public/items' . $item->id);
                    $photo_item = Item_photo::create(['item_id' => $item->id, 'path' => '/storage/' . str_replace('public/', '', $photoPath)]);
                }
            }
            return redirect()->back()->with('success', 'Item created successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function moderateItem($id)
    {
        try {
            $item = Item::find($id);
            if ($item->status == "active") {
                $item->update(['status' => "disabled"]);
                return redirect()->back()->with('success', 'Item disabled successfully');
            }
            if ($item->count > 0) {
                $item->update(['status' => "active"]);
            } else {
                $item->update(['status' => "out_of_stock"]);
            }
            return redirect()->back()->with('success', 'Item approved successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function deleteItem(Request $request)
    {
        try {
            $item = Item::find($request->id);
            $photos = Item_photo::where('item_id', $request->id)->get();

            foreach ($photos as $photo) {
                Storage::delete("public" . str_replace('/storage', '', $photo->path));
            }

            $item->delete();
            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
