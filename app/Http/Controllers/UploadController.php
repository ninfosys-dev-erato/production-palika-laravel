<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $path = $file->store(config('main.path'), getStorageDisk('public'));
            $url = Storage::url($path);

            return response()->json([
                'url' => $url,
            ]);
        }

        return response()->json([
            'error' => 'No file uploaded.'
        ], 400);
    }
}
