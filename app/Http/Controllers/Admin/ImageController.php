<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ImageController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,webp,avif'],
        ]);

        $file = $request->file('image');
        $filename = time().'_'.bin2hex(random_bytes(8)).'.'.$file->getClientOriginalExtension();

        $path = $file->storeAs('public/images/articles', $filename);

        try {
            $img = Image::make(Storage::path($path));
            if ($img->width() > 1920) {
                $img->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save(Storage::path($path));
            }
        } catch (\Exception $e) {
            // File stored even if resize fails
        }

        return response()->json([
            'url' => Storage::url($path),
            'path' => $path,
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->validate(['path' => ['required', 'string']]);

        $path = str_replace('/storage/', 'public/', $request->input('path'));

        $realPath = realpath(storage_path('app/'.$path));

        if (! $realPath || ! str_starts_with($realPath, realpath(storage_path('app/public/images')))) {
            return response()->json(['ok' => false], 400);
        }

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        return response()->json(['ok' => true]);
    }
}
