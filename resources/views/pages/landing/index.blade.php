@extends('layouts.public.base')

@section('content')
    <div class="kt-container-fixed space-y-5">
        <div id="berita" class="space-y-5">
            @include('partials.landing.pinned')
            @include('partials.landing.berita')
        </div>
        <div id="buletin">
            @include('partials.landing.buletin')
        </div>
        <div id="karyaMahasiswa" class="space-y-5">
            <h2 class="text-3xl font-semibold mb-8 text-mono border-b-2 pb-2 w-full lg:w-80">Karya Mahasiswa</h2>
            @include('partials.landing.resensi-buku')
            @include('partials.landing.review-film')
            @include('partials.landing.opini')
            @include('partials.landing.esai')
            @include('partials.landing.artikel')
            @include('partials.landing.puisi')
            @include('partials.landing.cerpen')
        </div>
        <div id="gayaMahasiswa">
            @include('partials.landing.gaya-mahasiswa')
        </div>
    </div>
@endsection
