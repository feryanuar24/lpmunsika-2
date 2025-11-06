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
                    Form Perbaharui Profil
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-outline" href="{{ route('profile') }}">
                    Kembali
                </a>
            </div>
        </div>
    </div>
    <!-- End of Container -->
    <!-- Container -->
    <div class="kt-container-fixed">
        <form action="{{ route('profile') }}" method="POST" class="kt-card p-5 space-y-5">
            @method('PATCH')

            @csrf

            <div>
                <label for="name" class="kt-label">Nama</label>
                <span class="text-destructive">*</span>
                <input type="text" name="name" class="kt-input w-full" value="{{ old('name', $data['user']->name) }}"
                    placeholder="Masukkan nama" />
            </div>

            <div>
                <label for="email" class="kt-label">Email</label>
                <span class="text-destructive">*</span>
                <input type="email" name="email" id="email" required class="kt-input w-full"
                    value="{{ old('email', $data['user']->email) }}" placeholder="Masukkan alamat email" />
            </div>

            <div>
                <label class="kt-label" for="password">Kata Sandi</label>
                <span class="text-muted-foreground kt-label">(Biarkan kosong jika tidak ingin mengubah kata sandi)</span>
                <div class="relative max-w-72" data-kt-toggle-password="true">
                    <input type="text" name="password" class="kt-input w-full pe-10"
                        placeholder="Masukkan kata sandi baru" /><button
                        class="kt-btn kt-btn-icon kt-btn-ghost size-6 absolute end-2 top-1/2 -translate-y-1/2"
                        data-kt-toggle-password-trigger="true" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-eye kt-toggle-password-active:hidden"
                            aria-hidden="true">
                            <path
                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                            </path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-eye-off hidden kt-toggle-password-active:block"
                            aria-hidden="true">
                            <path
                                d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49">
                            </path>
                            <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"></path>
                            <path
                                d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143">
                            </path>
                            <path d="m2 2 20 20"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div>
                <label class="kt-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                <div class="relative max-w-72" data-kt-toggle-password="true">
                    <input type="text" name="password_confirmation" class="kt-input w-full pe-10"
                        placeholder="Masukkan konfirmasi kata sandi baru" /><button
                        class="kt-btn kt-btn-icon kt-btn-ghost size-6 absolute end-2 top-1/2 -translate-y-1/2"
                        data-kt-toggle-password-trigger="true" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-eye kt-toggle-password-active:hidden"
                            aria-hidden="true">
                            <path
                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                            </path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-eye-off hidden kt-toggle-password-active:block"
                            aria-hidden="true">
                            <path
                                d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49">
                            </path>
                            <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"></path>
                            <path
                                d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143">
                            </path>
                            <path d="m2 2 20 20"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="button" class="kt-btn kt-btn-primary mt-5" data-kt-modal-toggle="#modal-edit-profile">Perbaharui
                Profil</button>

            <div class="kt-modal z-40" data-kt-modal="true" id="modal-edit-profile">
                <div
                    class="kt-modal-content max-w-md w-[90%] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                    <div class="kt-modal-header">
                        <h3 class="kt-modal-title">Konfirmasi Perbaharui</h3>
                        <button type="button" class="kt-modal-close" aria-label="Close modal"
                            data-kt-modal-dismiss="#modal-edit-profile">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                                <path d="M18 6 6 18"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="kt-modal-body">
                        <div class="flex items-center gap-4">
                            <i class="ki-filled ki-lock text-4xl text-blue-600"></i>
                            <div>
                                <p class="font-medium">Anda memperbaharui menggunakan data ini.</p>
                                <p class="text-sm text-muted">Pastikan data sudah benar sebelum
                                    melanjutkan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="kt-modal-footer">
                        <div></div>
                        <div class="flex gap-4">
                            <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal-edit-profile" type="button">Tidak, Kembali</button>
                            <button class="kt-btn kt-btn-primary" type="submit">Ya, Perbaharui</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End of Container -->
@endsection
