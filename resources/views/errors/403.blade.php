@extends('layouts.error.base')

@section('content')
    <div class="flex flex-col items-center justify-center text-center space-y-5 min-h-[600px]">
        <img src="{{ asset('assets/media/illustrations/5.svg') }}" alt="Access Denied" class="w-80">
        <h2 class="text-2xl font-semibold">Akses Ditolak</h2>
        <p class="text-gray-400 w-[600px]">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan
            kembali ke halaman utama atau hubungi administrator jika Anda membutuhkan akses.</p>
        <button class="kt-btn kt-btn-primary">
            <a href="/" class="text-white">Kembali ke Beranda</a>
        </button>
    </div>
@endsection
