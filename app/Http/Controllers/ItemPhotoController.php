<?php

namespace App\Http\Controllers;

use App\Models\Item_photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemPhotoController extends Controller
{
    public function deletePhoto(Request $request)
    {
        try {

            $photo =  Item_photo::find($request->id);
            Storage::delete('public' . str_replace('/storage', '', $photo->path));
            $photo->delete();
            return redirect()->back()->with('success', 'Photo deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
