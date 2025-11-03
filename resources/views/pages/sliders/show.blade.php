@extends('layouts.admin.base')

@section('content')
    <div class="kt-container-fluid">
        <div class="kt-card">
            <div class="kt-card-header flex justify-between">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Detail Slider
                </h1>
                <a class="kt-btn kt-btn-primary" href="{{ route('sliders.index') }}">Kembali</a>
            </div>
            <div class="kt-card-content">
                <p>Nama: {{ $data['slider']->name }}</p>
                <p>Deskripsi: {{ $data['slider']->description }}</p>
                <img src="{{ $data['slider']->url }}" alt="{{ $data['slider']->name }}" class="mt-4 max-w-full h-auto">
            </div>
        </div>
    </div>
@endsection
