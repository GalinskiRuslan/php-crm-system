<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => '',
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/categories');
            $category = Category::create(['name' => $validated['name'], 'slug' => $validated['slug'], 'description' => $validated['description'], 'image' => '/storage/' . str_replace('public/', '', $path)]);
        } else {
            $category = Category::create(['name' => $validated['name'], 'slug' => $validated['slug'], 'description' => $validated['description'], 'image' => null]);
        }
        if ($request->hasFile('icon')) {
            $pathIcon = $request->file('icon')->store('public/categories/icons');
            $category->update(['icon' => '/storage/' . str_replace('public/', '', $pathIcon)]);
        }
        if ($category) {
            return redirect()->back()->with('success', 'Category created successfully');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }
    public function edit(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => '',
        ]);
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }
        $category->update($validated);
        if ($request->hasFile('image')) {
            Storage::delete("public" . str_replace('/storage', '', $category->image));
            $path = $request->file('image')->store('public/categories');
            $category->update(['image' => '/storage/' . str_replace('public/', '', $path)]);
        }
        if ($request->hasFile('icon')) {
            Storage::delete("public" . str_replace('/storage', '', $category->icon));
            $path = $request->file('icon')->store('public/categories/icons');
            $category->update(['icon' => '/storage/' . str_replace('public/', '', $path)]);
        }
        return redirect()->back()->with('success', 'Category updated successfully');
    }
    public function destroy(Request $request,)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $category = Category::find($validated['id']);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }
        try {
            $category->delete();

            Storage::delete("public" . str_replace('/storage', '', $category->image));
            return redirect()->back()->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
