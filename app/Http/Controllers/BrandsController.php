<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brands::all();
        return view('brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $brand = Brands::create(['name' => $request->name]);
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('public/brands');
                $brand->update(['img' => '/storage/' . str_replace('public/', '', $path)]);
            }
            if ($request->hasFile('logo')) {
                $pathIcon = $request->file('logo')->store('public/brands/logo');
                $brand->update(['logo' => '/storage/' . str_replace('public/', '', $pathIcon)]);
            }
            return redirect()->back()->with(['success' => 'Brand created successfully']);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        $brand = Brands::find($validated['id']);
        if (!$brand) {
            return redirect()->back()->with(['error' => 'Brand not found']);
        }
        try {
            $brand->delete();
            Storage::delete("public" . str_replace('/storage', '', $brand->image));
            Storage::delete("public" . str_replace('/storage', '', $brand->logo));
            return redirect()->back()->with('success', 'Brand deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $brand = Brands::find($id);
        if (!$brand) {
            return redirect()->back()->withErrors(['error' => 'Brand not found']);
        }
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $brand = Brands::find($id);
        if (!$brand) {
            return redirect()->back()->withErrors(['error' => 'Brand not found']);
        }
        $brand->update($validated);
        if ($request->hasFile('image')) {
            try {
                Storage::delete("public" . str_replace('/storage', '', $brand->image));
            } catch (\Throwable $th) {

                return redirect()->back()->withErrors(['error' => $th->getMessage()]);
            }

            $path = $request->file('image')->store('public/brands');
            $brand->update(['img' => '/storage/' . str_replace('public/', '', $path)]);
        }
        if ($request->hasFile('logo')) {
            Storage::delete("public" . str_replace('/storage', '', $brand->logo));
            $pathIcon = $request->file('logo')->store('public/brands/logo');
            $brand->update(['logo' => '/storage/' . str_replace('public/', '', $pathIcon)]);
        }
        return redirect()->back()->with(['success' => 'Brand updated successfully']);
    }
}
