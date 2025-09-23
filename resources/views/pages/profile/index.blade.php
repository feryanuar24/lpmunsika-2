@extends('layouts.admin.base')

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed" id="contentContainer">
    </div>
    <!-- End of Container -->
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Profil Saya
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <form action="{{ route('profile') }}" method="POST">
                    @method('DELETE')

                    @csrf

                    <button type="button" class="kt-btn kt-btn-outline" data-kt-modal-toggle="#modal-delete">Hapus</button>

                    <div class="kt-modal z-40" data-kt-modal="true" id="modal-delete">
                        <div
                            class="kt-modal-content max-w-md w-[600px] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                            <div class="kt-modal-header">
                                <h3 class="kt-modal-title">Konfirmasi Hapus</h3>
                                <button type="button" class="kt-modal-close" aria-label="Close modal"
                                    data-kt-modal-dismiss="#modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"
                                        aria-hidden="true">
                                        <path d="M18 6 6 18"></path>
                                        <path d="m6 6 12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="kt-modal-body">
                                <div class="flex items-center gap-4">
                                    <i class="ki-filled ki-lock text-4xl text-blue-600"></i>
                                    <div>
                                        <p class="font-medium">Anda menghapus akun ini.</p>
                                        <p class="text-sm text-muted">Pastikan data sudah dicadangkan sebelum
                                            melanjutkan.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-modal-footer">
                                <div></div>
                                <div class="flex gap-4">
                                    <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal">Tidak,
                                        Kembali</button>
                                    <button class="kt-btn kt-btn-primary" type="submit">Ya, Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <a class="kt-btn kt-btn-primary" href="{{ route('profile.edit') }}">
                    Edit
                </a>
            </div>
        </div>
    </div>
    <!-- End of Container -->
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="kt-card p-5">
            <div class="flex items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div
                        class="w-20 h-20 rounded-full bg-muted flex items-center justify-center text-2xl font-semibold text-primary">
                        {{ strtoupper(substr($data['user']->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">{{ $data['user']->name }}</h2>
                        <p class="text-sm text-muted">{{ $data['user']->email }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="kt-label">Nama</label>
                    <p class="mt-1 text-base">{{ $data['user']->name }}</p>
                </div>

                <div>
                    <label class="kt-label">Email</label>
                    <p class="mt-1 text-base">{{ $data['user']->email }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Container -->
@endsection
