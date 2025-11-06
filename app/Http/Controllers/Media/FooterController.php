<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'footers' => Footer::all(),
        ];

        return view('pages.footers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.footers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama footer wajib diisi.',
            'name.string' => 'Nama footer harus berupa teks.',
            'name.max' => 'Nama footer maksimal :max karakter.',
            'name.unique' => 'Nama footer sudah digunakan.',
            'url.required' => 'URL wajib diisi.',
            'url.string' => 'URL harus berupa teks.',
            'url.max' => 'URL maksimal :max karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:footers,name'],
            'url' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        Footer::create($validator->validated());

        return redirect()
            ->route('footers.index')
            ->with('success', 'Footer berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Footer $footer)
    {
        $data = [
            'footer' => $footer,
        ];

        return view('pages.footers.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Footer $footer)
    {
        $data = [
            'footer' => $footer,
        ];

        return view('pages.footers.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Footer $footer)
    {
        $messages = [
            'name.required' => 'Nama footer wajib diisi.',
            'name.string' => 'Nama footer harus berupa teks.',
            'name.max' => 'Nama footer maksimal :max karakter.',
            'name.unique' => 'Nama footer sudah digunakan.',
            'url.required' => 'URL wajib diisi.',
            'url.string' => 'URL harus berupa teks.',
            'url.max' => 'URL maksimal :max karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:footers,name,' . $footer->id],
            'url' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        $footer->update($validator->validated());

        return redirect()
            ->route('footers.index')
            ->with('success', 'Footer berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Footer $footer)
    {
        $footer->delete();

        return redirect()
            ->route('footers.index')
            ->with('success', 'Footer berhasil dihapus.');
    }
}
