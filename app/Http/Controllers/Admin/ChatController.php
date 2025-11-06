<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'message.required' => 'Pesan wajib diisi.',
            'message.string' => 'Pesan harus berupa teks.',
            'message.max' => 'Panjang pesan tidak boleh lebih dari :max karakter.',
        ];

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $validator->errors()->all()));
        }

        Chat::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil terkirim.');
    }
}
