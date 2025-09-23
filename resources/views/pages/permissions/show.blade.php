@extends('layouts.admin.base')

@section('content')
    <div class="kt-container-fluid">
        <div class="kt-card">
            <div class="kt-card-header flex justify-between">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Detail Permission
                </h1>
                <a class="kt-btn kt-btn-primary" href="{{ route('permissions.index') }}">Kembali</a>
            </div>
            <div class="kt-card-content">
                <p>Nama: {{ $data['permission']->name }}</p>
                <p>Nama Tampilan: {{ $data['permission']->display_name }}</p>
                <p>Deskripsi: {{ $data['permission']->description }}</p>
            </div>
        </div>
    </div>
@endsection
