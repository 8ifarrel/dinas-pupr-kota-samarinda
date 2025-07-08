<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FilePondController extends Controller
{
    public function process(Request $request)
    {
        $fileInputName = array_key_first($request->file());
        $request->validate([
            $fileInputName => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file = $request->file($fileInputName);
        $fileName = now()->format('YmdHis') . '-' . Str::random(4) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('temp', $fileName, 'public');

        return response()->json([
            'fileUrl' => Storage::url($path),
        ], 200, ['Content-Type' => 'application/json']);
    }

    public function revert(Request $request)
    {
        $request->validate([
            'fileUrl' => 'required|string',
        ]);

        $path = str_replace('/storage/', '', $request->fileUrl);

        // Log::info('Revert method called');
        // Log::info('File URL: ' . $request->fileUrl);
        // Log::info('Path: ' . $path);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['message' => 'File deleted successfully.']);
        }

        return response()->json(['message' => 'File not found.'], 404);
    }
}
