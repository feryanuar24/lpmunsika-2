@extends('layouts.auth.base')

@section('content')
    <h1 class="font-semibold text-4xl mb-10">Form Perbaharui Kata Sandi</h1>

    <form action="{{ route('password.update') }}" class="space-y-5" method="POST">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label class="kt-label" for="email">Email</label>
            <input type="email" name="email" id="email" required class="kt-input w-[600px]"
                value="{{ old('email') }}" placeholder="Masukkan alamat email">
        </div>

        <div>
            <label class="kt-label" for="password">Kata Sandi Baru</label>
            <div class="relative max-w-72" data-kt-toggle-password="true">
                <input type="password" name="password" class="kt-input w-[600px] pe-10"
                    placeholder="Masukkan kata sandi baru" /><button
                    class="kt-btn kt-btn-icon kt-btn-ghost size-6 absolute end-2 top-1/2 -translate-y-1/2"
                    data-kt-toggle-password-trigger="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-eye kt-toggle-password-active:hidden" aria-hidden="true">
                        <path
                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                        </path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-eye-off hidden kt-toggle-password-active:block" aria-hidden="true">
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
            <label class="kt-label" for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
            <div class="relative max-w-72" data-kt-toggle-password="true">
                <input type="password" name="password_confirmation" class="kt-input w-[600px] pe-10"
                    placeholder="Masukkan konfirmasi kata sandi baru" /><button
                    class="kt-btn kt-btn-icon kt-btn-ghost size-6 absolute end-2 top-1/2 -translate-y-1/2"
                    data-kt-toggle-password-trigger="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-eye kt-toggle-password-active:hidden" aria-hidden="true">
                        <path
                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                        </path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-eye-off hidden kt-toggle-password-active:block" aria-hidden="true">
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

        <button type="button" class="kt-btn kt-btn-primary" data-kt-modal-toggle="#modal">Perbarui Kata Sandi</button>

        <div class="kt-modal z-40" data-kt-modal="true" id="modal">
            <div
                class="kt-modal-content max-w-md w-[600px] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                <div class="kt-modal-header">
                    <h3 class="kt-modal-title">Konfirmasi Perbarui Kata Sandi</h3>
                    <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#modal">
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
                            <p class="font-medium">Anda akan memperbarui kata sandi akun ini.</p>
                            <p class="text-sm text-muted">Pastikan kata sandi baru sudah benar dan Anda mengingatnya
                                sebelum melanjutkan.</p>
                        </div>
                    </div>
                </div>
                <div class="kt-modal-footer">
                    <div></div>
                    <div class="flex gap-4">
                        <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal">Batal</button>
                        <button class="kt-btn kt-btn-primary" type="submit">Ya, Perbarui</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
