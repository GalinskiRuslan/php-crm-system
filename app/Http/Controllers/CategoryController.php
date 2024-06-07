<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
        if ($category) {
            return redirect()->back()->with('success', 'Category created successfully');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $category = Category::find($validated['id']);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }
        // dd(Storage::allFiles('public/categories'),  "public" . str_replace('/storage', '', $category->image), $category->image);
        $category->delete();

        Storage::delete("public" . str_replace('/storage', '', $category->image));
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
