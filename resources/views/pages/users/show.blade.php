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
                    Detail Pengguna
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-outline" href="{{ route('users.index') }}">
                    Kembali
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

                <div>
                    <label class="kt-label">Role</label>
                    <div class="mt-1 flex flex-wrap gap-2">
                        @foreach ($data['user']->roles as $role)
                            <span
                                class="kt-badge kt-badge-inline kt-badge-light-primary">{{ $role->name }}</span>
                        @endforeach
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <!-- End of Container -->
@endsection
