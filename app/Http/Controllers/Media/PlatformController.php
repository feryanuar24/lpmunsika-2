<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'platforms' => Platform::all(),
        ];

        return view('pages.platforms.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama platform wajib diisi.',
            'name.string' => 'Nama platform harus berupa teks.',
            'name.max' => 'Nama platform maksimal :max karakter.',
            'name.unique' => 'Nama platform sudah digunakan.',
            'url.required' => 'URL wajib diisi.',
            'url.url' => 'Format URL tidak valid.',
            'url.max' => 'URL maksimal :max karakter.',
            'url.unique' => 'URL sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:platforms,name'],
            'url' => ['required', 'url', 'max:255', 'unique:platforms,url'],
            'description' => ['nullable', 'string'],
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        Platform::create($validator->validated());

        return redirect()
            ->route('platforms.index')
            ->with('success', 'Platform berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Platform $platform)
    {
        $data = [
            'platform' => $platform,
        ];

        return view('pages.platforms.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Platform $platform)
    {
        $data = [
            'platform' => $platform,
        ];

        return view('pages.platforms.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Platform $platform)
    {
        $messages = [
            'name.required' => 'Nama platform wajib diisi.',
            'name.string' => 'Nama platform harus berupa teks.',
            'name.max' => 'Nama platform maksimal :max karakter.',
            'name.unique' => 'Nama platform sudah digunakan.',
            'url.required' => 'URL wajib diisi.',
            'url.url' => 'Format URL tidak valid.',
            'url.max' => 'URL maksimal :max karakter.',
            'url.unique' => 'URL sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:platforms,name,' . $platform->id],
            'url' => ['required', 'url', 'max:255', 'unique:platforms,url,' . $platform->id],
            'description' => ['nullable', 'string'],
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        $platform->update($validator->validated());

        return redirect()
            ->route('platforms.index')
            ->with('success', 'Platform berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();

        return redirect()
            ->route('platforms.index')
            ->with('success', 'Platform berhasil dihapus.');
    }
}
