<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;



use Illuminate\Support\Facades\Storage;

class SliderAdminController extends Controller
{
    public function index()
    {
        $page_title = "Slider";
        $slider = Slider::select('id_slider', 'judul_slider', 'nomor_urut_slider', 'foto_slider', 'is_visible')
            ->orderBy('nomor_urut_slider', 'asc')
            ->get();

        return view('admin.pages.slider.index', [
            'page_title' => $page_title,
            'slider' => $slider,
        ]);
    }

    public function moveUp(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:slider,id_slider',
        ]);

        $sliderId = $request->input('id');
        $slider = Slider::findOrFail($sliderId);

        $previousSlider = Slider::where('nomor_urut_slider', '<', $slider->nomor_urut_slider)
            ->orderBy('nomor_urut_slider', 'desc')
            ->first();

        if ($previousSlider) {
            $previousSliderTemp = $previousSlider->nomor_urut_slider;
            $previousSlider->update(['nomor_urut_slider' => 0]);

            $sliderTemp = $slider->nomor_urut_slider;
            $slider->update(['nomor_urut_slider' => $previousSliderTemp]);

            $previousSlider->update(['nomor_urut_slider' => $sliderTemp]);
        }

        return response()->json(['success' => true]);
    }

    public function moveDown(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:slider,id_slider',
        ]);

        $sliderId = $request->input('id');
        $slider = Slider::findOrFail($sliderId);

        $nextSlider = Slider::where('nomor_urut_slider', '>', $slider->nomor_urut_slider)
            ->orderBy('nomor_urut_slider', 'asc')
            ->first();

        if ($nextSlider) {
            $previousSliderTemp = $nextSlider->nomor_urut_slider;
            $nextSlider->update(['nomor_urut_slider' => 0]);

            $sliderTemp = $slider->nomor_urut_slider;
            $slider->update(['nomor_urut_slider' => $previousSliderTemp]);

            $nextSlider->update(['nomor_urut_slider' => $sliderTemp]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        if (Storage::exists('public/' . $slider->foto_slider)) {
            Storage::delete('public/' . $slider->foto_slider);
        }

        $slider->delete();

        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil dihapus.');
    }

    public function create()
    {
        $page_title = "Tambah Slider";

        return view('admin.pages.slider.create', [
            'page_title' => $page_title,
        ]);
    }


    public function filepond(Request $request)
    {
        $request->validate([
            'foto_slider' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file = $request->file('foto_slider');
        $fileName = now()->format('YmdHis') . '-' . Str::random(4) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('slider/temp', $fileName, 'public');

        return response()->json([
            'fileUrl' => Storage::url($path),
        ]);
    }

    public function filepondRevert(Request $request)
    {

        // $request->validate([
        //     'fileUrl' => 'required|url',
        // ]);

        $path = str_replace(url('storage'), 'public', $request->fileUrl);
        Log::info($path);

        if (Storage::exists($path)) {
            Storage::delete($path);
            return response()->json(['message' => 'File deleted successfully.']);
        }

        return response()->json(['message' => 'File not found.'], 404);
    }
}
