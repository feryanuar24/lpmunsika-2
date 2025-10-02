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
                    Form Edit Penyematan
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-outline" href="{{ route('embeds.index') }}">
                    Kembali
                </a>
            </div>
        </div>
    </div>
    <!-- End of Container -->
    <!-- Container -->
    <div class="kt-container-fixed">
        <form action="{{ route('embeds.update', $data['embed']->id) }}" method="POST" class="kt-card p-5 space-y-5">
            @method('PATCH')

            @csrf

            <div>
                <label for="platform_id" class="kt-label">Platform</label>
                <span class="text-destructive">*</span>
                <select name="platform_id" class="kt-select" data-kt-select="true"
                    data-kt-select-placeholder="Pilih platform"
                    data-kt-select-config='{
                        "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                    }'>
                    @foreach ($data['platforms'] as $platform)
                        <option value="{{ $platform->id }}"
                            {{ old('platform_id', $data['article']->platform->id) == $platform->id ? 'selected' : '' }}>
                            {{ $platform->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="title" class="kt-label">Judul</label>
                <span class="text-destructive">*</span>
                <input type="text" name="title" class="kt-input w-full"
                    value="{{ old('title', $data['embed']->title) }}" placeholder="Masukkan judul" />
            </div>

            <div>
                <label for="embed_code" class="kt-label">Kode</label>
                <span class="text-destructive">*</span>
                <textarea type="text" name="embed_code" class="kt-textarea w-full" placeholder="Masukkan kode penyematan">{{ old('embed_code', $data['embed']->embed_code) }}</textarea>
            </div>

            <div>
                <label for="description" class="kt-label">Deskripsi</label>
                <textarea name="description" class="kt-textarea w-full" rows="4" placeholder="Masukkan deskripsi">{{ old('description', $data['embed']->description) }}</textarea>
            </div>

            <button type="button" class="kt-btn kt-btn-primary mt-5" data-kt-modal-toggle="#modal">Edit
                Penyematan</button>

            <div class="kt-modal z-40" data-kt-modal="true" id="modal">
                <div
                    class="kt-modal-content max-w-md w-[600px] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                    <div class="kt-modal-header">
                        <h3 class="kt-modal-title">Konfirmasi Edit</h3>
                        <button type="button" class="kt-modal-close" aria-label="Close modal"
                            data-kt-modal-dismiss="#modal">
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
                                <p class="font-medium">Anda mengedit penyematan dengan data ini.</p>
                                <p class="text-sm text-muted">Pastikan data sudah benar sebelum
                                    melanjutkan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="kt-modal-footer">
                        <div></div>
                        <div class="flex gap-4">
                            <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal">Tidak, Kembali</button>
                            <button class="kt-btn kt-btn-primary" type="submit">Ya, Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End of Container -->
@endsection
