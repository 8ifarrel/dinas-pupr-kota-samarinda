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
        $request->validate([
            'foto_slider' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file = $request->file('foto_slider');
        $fileName = now()->format('YmdHis') . '-' . Str::random(4) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('temp', $fileName, 'public');

        return response()->json([
            'fileUrl' => Storage::url($path),
        ]);
    }

    public function revert(Request $request)
    {
        $request->validate([
            'fileUrl' => 'required|string',
        ]);

        $path = str_replace('/storage/', '', subject: $request->fileUrl);

        Log::info('Revert method called');
        Log::info('File URL: ' . $request->fileUrl);
        Log::info('Path: ' . $path);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['message' => 'File deleted successfully.']);
        }

        return response()->json(['message' => 'File not found.'], 404);
    }
}
