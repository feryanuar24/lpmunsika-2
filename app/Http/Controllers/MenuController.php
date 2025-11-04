<?php

namespace App\Http\Controllers;

use App\Models\Embed;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
    }

    /**
     * Search menus.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $data = [
            'query' => $query,
            'menus' => Menu::where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
                ->latest()
                ->paginate(12),
            'youtube' => Embed::where('platform_id', 1)
                ->latest()
                ->limit(3)
                ->get(),
            'spotify' => Embed::where('platform_id', 2)
                ->latest()
                ->limit(3)
                ->get(),
        ];

        return view('pages.menus.search', compact('data'));
    }
}
