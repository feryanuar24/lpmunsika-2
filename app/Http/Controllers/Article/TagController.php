<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'tags' => Tag::all()
        ];

        return view('pages.tags.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags,name'],
            'description' => ['nullable', 'string', 'max:255']
        ]);

        $request->merge([
            'slug' => Str::slug($request->name),
        ]);

        Tag::create($request->all());

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $data = [
            'tag' => $tag,
        ];

        return view('pages.tags.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        $data = [
            'tag' => $tag,
        ];

        return view('pages.tags.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags,name,' . $tag->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $request->merge([
            'slug' => Str::slug($request->name),
        ]);

        $tag->update($request->all());

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag berhasil diperbaharui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag berhasil dihapus.');
    }
}
