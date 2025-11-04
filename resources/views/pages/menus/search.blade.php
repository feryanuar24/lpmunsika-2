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
                    Hasil Pencarian Menu
                </h1>
                @if (request('q'))
                    <p class="text-sm text-muted">Kata kunci: "{{ request('q') }}"</p>
                @endif
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-secondary" href="{{ route('dashboard') }}">
                    <i class="ki-filled ki-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
    <!-- End of Container -->
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="grid w-full space-y-5">
            <!-- Search Form -->
            <div class="kt-card">
                <div class="kt-card-body">
                    <form action="{{ route('menus.search') }}" method="GET" class="flex gap-2">
                        <div class="w-full">
                            <input type="text" name="q" value="{{ request('q') }}" class="kt-input"
                                placeholder="Cari menu..." required>
                        </div>
                        <button type="submit" class="kt-btn kt-btn-primary">
                            <i class="ki-filled ki-magnifier"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Results -->
            @if (isset($data['menus']) && $data['menus']->count() > 0)
                <div class="kt-card">
                    <div class="kt-card-table" data-kt-datatable="true" data-kt-datatable-page-size="10"
                        data-kt-datatable-state-save="false">
                        <div class="kt-table-wrapper kt-scrollable">
                            <table class="kt-table" data-kt-datatable-table="true">
                                <thead>
                                    <tr>
                                        <th scope="col" data-kt-datatable-column="name">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Nama</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" data-kt-datatable-column="url">
                                            <span class="kt-table-col"><span class="kt-table-col-label">URL</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" data-kt-datatable-column="icon">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Icon</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" data-kt-datatable-column="parent">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Parent</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-10" data-kt-datatable-column="actions">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data['menus'] as $menu)
                                        <tr>
                                            <td>
                                                <div class="flex flex-col">
                                                    <span class="font-medium">{{ $menu->name }}</span>
                                                    @if ($menu->description)
                                                        <span
                                                            class="text-xs text-muted">{{ Str::limit($menu->description, 50) }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if ($menu->url)
                                                    <span class="kt-badge kt-badge-outline">{{ $menu->url }}</span>
                                                @else
                                                    <span class="text-muted text-sm">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($menu->icon)
                                                    <i class="{{ $menu->icon }} ki-filled text-lg"></i>
                                                @else
                                                    <span class="text-muted text-sm">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($menu->parent)
                                                    <span class="text-sm">{{ $menu->parent->name }}</span>
                                                @else
                                                    <span class="kt-badge kt-badge-primary kt-badge-sm">Root</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($menu->url)
                                                    <a href="{{ $menu->url }}">
                                                        <i class="ki-filled ki-paper-plane"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted text-sm">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--begin:pagination-->
                        <div class="kt-datatable-toolbar">
                            <div class="kt-datatable-length">
                                Tampil<select class="kt-select kt-select-sm w-16" name="perpage"
                                    data-kt-datatable-size="true"></select>per halaman
                            </div>
                            <div class="kt-datatable-info">
                                <span data-kt-datatable-info="true"></span>
                                <div class="kt-datatable-pagination" data-kt-datatable-pagination="true"></div>
                            </div>
                        </div>
                        <!--end:pagination-->
                    </div>
                </div>
            @else
                <div class="kt-card">
                    <div class="kt-card-body">
                        <div class="flex flex-col items-center justify-center py-12 gap-4">
                            <i class="ki-filled ki-search-list text-6xl text-muted"></i>
                            <div class="text-center">
                                <h3 class="text-lg font-medium">Tidak Ada Hasil</h3>
                                <p class="text-sm text-muted mt-2">
                                    @if (request('q'))
                                        Tidak ditemukan menu dengan kata kunci "{{ request('q') }}"
                                    @else
                                        Masukkan kata kunci untuk mencari menu
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('menus.index') }}" class="kt-btn kt-btn-primary mt-4">
                                Lihat Semua Menu
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- End of Container -->
@endsection
