<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
        ]);

        // Handle the uploaded file
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images', $filename);

            // Save file info to database
            $image = Image::create([
                'filename' => $filename,
                'mime_type' => $file->getClientMimeType(),
                'image' => $path,
            ]);

            return response()->json(['success' => 'Image uploaded successfully', 'image' => $image], 201);
        }

        return response()->json(['error' => 'No image uploaded'], 400);
    }

    public function show($name)
    {
        $image = Image::where('filename', $name)->firstOrFail();

        if ($image->mime_type === 'application/pdf') {
            return Response::download(storage_path('app/' . $image->image), $image->filename);
        } else {
            return Response::file(storage_path('app/' . $image->image));
        }
    }
    public function index()
    {
        $images = Image::all();

        return response()->json(['images' => $images], 200);
    }
}
