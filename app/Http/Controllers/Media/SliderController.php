<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'sliders' => Slider::all(),
        ];

        return view('pages.sliders.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Catch validation exceptions so we can return with both
        // validation errors and a flash error message.
        try {
            $messages = [
                'name.required' => 'Nama wajib diisi.',
                'name.string' => 'Nama harus berupa teks.',
                'name.max' => 'Nama maksimal :max karakter.',
                'name.unique' => 'Nama sudah digunakan.',

                'banner.required' => 'Banner wajib diunggah.',
                'banner.image' => 'File banner harus berupa gambar.',
                'banner.max' => 'Banner maksimal :max kilobita.',

                'description.string' => 'Deskripsi harus berupa teks.',
            ];

            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:sliders,name'],
                'banner' => ['required', 'image', 'max:5120'],
                'description' => ['nullable', 'string'],
            ], $messages);
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        try {
            $data = $request->except('banner');

            if ($request->hasFile('banner')) {
                $slider = Storage::put('sliders', $request->file('banner'));
                $data['banner'] = $slider;
            }

            Slider::create($data);

            return redirect()
                ->route('sliders.index')
                ->with('success', 'Slider berhasil dibuat.');
        } catch (\Throwable $th) {
            Log::error('Error creating slider: ' . $th->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan server');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        $data = [
            'slider' => $slider,
        ];

        return view('pages.sliders.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        $data = [
            'slider' => $slider,
        ];

        return view('pages.sliders.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        try {
            $messages = [
                'name.required' => 'Nama wajib diisi.',
                'name.string' => 'Nama harus berupa teks.',
                'name.max' => 'Nama maksimal :max karakter.',
                'name.unique' => 'Nama sudah digunakan.',

                'banner.image' => 'File banner harus berupa gambar.',
                'banner.max' => 'Banner maksimal :max kilobita.',

                'description.string' => 'Deskripsi harus berupa teks.',
            ];

            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:sliders,name,' . $slider->id],
                'banner' => ['nullable', 'image', 'max:5120'],
                'description' => ['nullable', 'string'],
            ], $messages);
        } catch (ValidationException $e) {
            Log::warning('Validation error updating slider: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi.');
        }

        try {
            $data = $request->except(['banner']);

            if ($request->hasFile('banner')) {
                if ($slider->banner) {
                    Storage::delete($slider->banner);
                }
                $data['banner'] = Storage::put('sliders', $request->file('banner'));
            }

            $slider->update($data);

            return redirect()
                ->route('sliders.index')
                ->with('success', 'Slider berhasil diperbarui.');
        } catch (\Throwable $th) {
            Log::error('Error updating slider: ' . $th->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan server');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();

        Storage::delete($slider->banner);

        return redirect()
            ->route('sliders.index')
            ->with('success', 'Slider berhasil dihapus.');
    }
}
