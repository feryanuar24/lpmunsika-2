@extends('layouts.admin.base')

@section('content')
    <div class="kt-container-fluid">
        <div class="kt-card">
            <div class="kt-card-header flex justify-between">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Detail Footer
                </h1>
                <a class="kt-btn kt-btn-primary" href="{{ route('categories.index') }}">Kembali</a>
            </div>
            <div class="kt-card-content">
                <p>Nama: {{ $data['footer']->name }}</p>
                <p>Slug: {{ $data['footer']->url }}</p>
                <p>Deskripsi: {{ $data['footer']->description }}</p>
            </div>
        </div>
    </div>
@endsection
