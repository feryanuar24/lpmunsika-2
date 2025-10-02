@extends('layouts.admin.base')

@section('content')
    <div class="kt-container-fluid">
        <div class="kt-card">
            <div class="kt-card-header flex justify-between">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Detail Platform
                </h1>
                <a class="kt-btn kt-btn-primary" href="{{ route('platforms.index') }}">Kembali</a>
            </div>
            <div class="kt-card-content">
                <p>Nama: {{ $data['platform']->name }}</p>
                <p>Slug: <a href="{{ $data['platform']->url }}" class="kt-link">{{ $data['platform']->url }}</a></p>
                <p>Deskripsi: {{ $data['platform']->description }}</p>
            </div>
        </div>
    </div>
@endsection
