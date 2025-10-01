@extends('layouts.public.base')

@section('content')
    <div class="kt-container-fixed">
        <div id="berita" class="space-y-5">
            @include('partials.landing.pinned')
            {{-- @include('partials.landing.berita') --}}
        </div>
        <div id="buletin">
            {{-- @include('partials.landing.buletin') --}}
        </div>
        <div id="karyaMahasiswa">
            {{-- @include('partials.landing.resensi-buku')
            @include('partials.landing.review-film')
            @include('partials.landing.opini')
            @include('partials.landing.esai')
            @include('partials.landing.artikel')
            @include('partials.landing.puisi')
            @include('partials.landing.cerpen') --}}
        </div>
    </div>
@endsection
