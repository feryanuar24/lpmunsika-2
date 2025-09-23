@extends('layouts.admin.base')

@section('content')
    <div class="kt-container-fluid">
        <div class="kt-card">
            <div class="kt-card-header flex justify-between">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Detail Role
                </h1>
                <a class="kt-btn kt-btn-primary" href="{{ route('roles.index') }}">Kembali</a>
            </div>
            <div class="kt-card-content">
                <p>Nama: {{ $data['role']->name }}</p>
                <p>Nama Tampilan: {{ $data['role']->display_name }}</p>
                <p>Deskripsi: {{ $data['role']->description }}</p>
            </div>
        </div>
    </div>
@endsection
