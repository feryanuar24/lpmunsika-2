<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    /**
     * Serve private thumbnail file from local disk.
     */
    public function show($path)
    {
        Log::info("Serving file: {$path}");
        if (!Storage::exists($path)) {
            abort(404);
        }
        $file = Storage::get($path);
        $mime = Storage::mimeType($path);
        return response($file, 200)->header('Content-Type', $mime);
    }
}
