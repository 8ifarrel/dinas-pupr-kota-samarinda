<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
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

        if (Storage::disk('public')->exists($slider->foto_slider)) {
            Storage::disk('public')->delete($slider->foto_slider);
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

    public function store(Request $request)
    {
        $request->validate([
            'judul_slider' => 'required|string|max:255',
            'is_visible' => 'required|boolean',
            'foto_slider' => 'required|string',
        ]);

        $slider = new Slider();
        $slider->judul_slider = $request->input('judul_slider');
        $slider->is_visible = $request->input('is_visible');
        $slider->nomor_urut_slider = Slider::max('nomor_urut_slider') + 1;

        $fotoSliderData = json_decode($request->input('foto_slider'), true);
        if (isset($fotoSliderData['fileUrl'])) {
            $tempFilePath = str_replace('/storage/', '', $fotoSliderData['fileUrl']);
            $newFileName = 'Slider/' . $slider->nomor_urut_slider . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
            Storage::disk('public')->move($tempFilePath, $newFileName);
            $slider->foto_slider = $newFileName;
        }

        $slider->save();

        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $page_title = "Edit Slider";
        $slider = Slider::findOrFail($id);

        return view('admin.pages.slider.edit', [
            'page_title' => $page_title,
            'slider' => $slider,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_slider' => 'required|string|max:255',
            'is_visible' => 'required|boolean',
            'foto_slider' => 'nullable|string',
        ]);

        $slider = Slider::findOrFail($id);
        $slider->judul_slider = $request->input('judul_slider');
        $slider->is_visible = $request->input('is_visible');

        if ($request->has('foto_slider')) {
            $fotoSliderData = json_decode($request->input('foto_slider'), true);
            if (isset($fotoSliderData['fileUrl'])) {
                $tempFilePath = str_replace('/storage/', '', $fotoSliderData['fileUrl']);
                $newFileName = 'Slider/' . $slider->nomor_urut_slider . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
                Storage::disk('public')->move($tempFilePath, $newFileName);
                $slider->foto_slider = $newFileName;
            }
        }

        $slider->save();

        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil diperbarui.');
    }
}
