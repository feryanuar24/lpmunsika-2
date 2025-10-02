@extends('layouts.admin.base')

@section('content')
    <div class="kt-container-fluid">
        <div class="kt-card">
            <div class="kt-card-header flex justify-between">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Detail Penyematan
                </h1>
                <a class="kt-btn kt-btn-primary" href="{{ route('embeds.index') }}">Kembali</a>
            </div>
            <div class="kt-card-content">
                <p>Judul : {{ $data['embed']->title }}</p>
                <p>Deskripsi: {{ $data['embed']->description }}</p>
                <p>Platform : {{ $data['embed']->platform->name }}</p>
                {!! $data['embed']->embed_code !!}
            </div>
        </div>
    </div>
@endsection
