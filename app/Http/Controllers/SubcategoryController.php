<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = DB::table('subcategories')->join('categories', 'subcategories.category_id', '=', 'categories.id')->select('subcategories.*', 'categories.name as category_name')->get();
        $categories =  Category::all();
        return view('subcategories.index', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => '',
            'category_id' => 'required|exists:categories,id',
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/subcategories');
            $subcategory = Subcategory::create(['name' => $validate['name'], 'slug' => $validate['slug'], 'description' => $validate['description'], 'category_id' => $validate['category_id'], 'image' => '/storage/' . str_replace('public/', '', $path)]);
        } else {
            $subcategory = Subcategory::create(['name' => $validate['name'], 'slug' => $validate['slug'], 'description' => $validate['description'], 'category_id' => $validate['category_id'], 'image' => null]);
        }
        if ($request->hasFile('icon')) {
            $pathIcon = $request->file('icon')->store('public/subcategories/icons');
            $subcategory->update(['icon' => '/storage/' . str_replace('public/', '', $pathIcon)]);
        }
        if ($subcategory) {
            return redirect()->back()->with('success', 'Subcategory created successfully');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }
    public function destroy(Request $request)
    {
        $subcategory = Subcategory::findOrFail($request->id);
        if ($subcategory) {
            $subcategory->delete();
            Storage::delete('public' . str_replace('/storage', '', $subcategory->image));
        } else {
            return redirect()->back()->with('error', 'Subcategory not found');
        }
        return redirect()->back()->with('success', 'Subcategory deleted successfully');
    }
    public function edit($id)
    {
        $subcategory = Subcategory::find($id);
        if (!$subcategory) {
            return redirect()->back()->with('error', 'Subcategory not found');
        }
        return view('subcategories.edit', compact('subcategory'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => '',
        ]);
        $subcategory = Subcategory::find($id);
        if (!$subcategory) {
            return redirect()->back()->with('error', 'Subcategory not found');
        }
        $subcategory->update($validated);
        if ($request->hasFile('image')) {
            Storage::delete("public" . str_replace('/storage', '', $subcategory->image));
            $path = $request->file('image')->store('public/subcategories');
            $subcategory->update(['image' => '/storage/' . str_replace('public/', '', $path)]);
        }
        return redirect()->back()->with('success', 'Subcategory updated successfully');
    }
}
