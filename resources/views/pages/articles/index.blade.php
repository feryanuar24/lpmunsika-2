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
                    Data Artikel
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <!-- Search Form -->
                <form method="GET" action="{{ route('articles.index') }}" class="flex items-center gap-2">
                    <input type="hidden" name="sort" value="{{ $data['sort'] }}">
                    <input type="hidden" name="direction" value="{{ $data['direction'] }}">
                    <input type="hidden" name="per_page" value="{{ $data['per_page'] }}">
                    <input type="text" name="search" value="{{ $data['search'] }}" placeholder="Cari artikel..."
                        class="kt-input w-64">
                    <button type="submit" class="kt-btn kt-btn-outline">
                        <i class="ki-filled ki-magnifier"></i>
                        Cari
                    </button>
                    @if ($data['search'])
                        <a href="{{ route('articles.index') }}" class="kt-btn kt-btn-secondary">
                            <i class="ki-filled ki-cross"></i>
                            Reset
                        </a>
                    @endif
                </form>
                <a class="kt-btn kt-btn-primary" href="{{ route('articles.create') }}">
                    Tambah
                </a>
            </div>
        </div>
    </div>
    <!-- End of Container -->
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="grid w-full space-y-5">
            <div class="kt-card">
                <!-- Per Page Selection -->
                <div class="p-4 border-b">
                    <form method="GET" action="{{ route('articles.index') }}" class="flex items-center gap-2">
                        <input type="hidden" name="search" value="{{ $data['search'] }}">
                        <input type="hidden" name="sort" value="{{ $data['sort'] }}">
                        <input type="hidden" name="direction" value="{{ $data['direction'] }}">
                        <label class="text-sm">Tampilkan:</label>
                        <select name="per_page" onchange="this.form.submit()" class="kt-select kt-select-sm w-20">
                            <option value="10" {{ $data['per_page'] == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $data['per_page'] == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $data['per_page'] == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $data['per_page'] == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span class="text-sm">data per halaman</span>
                    </form>
                </div>

                <div class="kt-table-wrapper kt-scrollable">
                    <table class="kt-table">
                        <thead>
                            <tr>
                                <th scope="col" class="w-20">
                                    <a href="{{ route('articles.index', array_merge(request()->query(), ['sort' => 'title', 'direction' => $data['sort'] == 'title' && $data['direction'] == 'asc' ? 'desc' : 'asc'])) }}"
                                        class="kt-table-col">
                                        <span class="kt-table-col-label">Judul</span>
                                        @if ($data['sort'] == 'title')
                                            <span
                                                class="kt-table-col-sort {{ $data['direction'] == 'asc' ? 'asc' : 'desc' }}"></span>
                                        @else
                                            <span class="kt-table-col-sort"></span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="w-20">
                                    <a href="{{ route('articles.index', array_merge(request()->query(), ['sort' => 'user', 'direction' => $data['sort'] == 'user' && $data['direction'] == 'asc' ? 'desc' : 'asc'])) }}"
                                        class="kt-table-col">
                                        <span class="kt-table-col-label">Penulis</span>
                                        @if ($data['sort'] == 'user')
                                            <span
                                                class="kt-table-col-sort {{ $data['direction'] == 'asc' ? 'asc' : 'desc' }}"></span>
                                        @else
                                            <span class="kt-table-col-sort"></span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="w-20">
                                    <a href="{{ route('articles.index', array_merge(request()->query(), ['sort' => 'category', 'direction' => $data['sort'] == 'category' && $data['direction'] == 'asc' ? 'desc' : 'asc'])) }}"
                                        class="kt-table-col">
                                        <span class="kt-table-col-label">Kategori</span>
                                        @if ($data['sort'] == 'category')
                                            <span
                                                class="kt-table-col-sort {{ $data['direction'] == 'asc' ? 'asc' : 'desc' }}"></span>
                                        @else
                                            <span class="kt-table-col-sort"></span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="w-20">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Tag</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-20">
                                    <a href="{{ route('articles.index', array_merge(request()->query(), ['sort' => 'is_active', 'direction' => $data['sort'] == 'is_active' && $data['direction'] == 'asc' ? 'desc' : 'asc'])) }}"
                                        class="kt-table-col">
                                        <span class="kt-table-col-label">Aktif</span>
                                        @if ($data['sort'] == 'is_active')
                                            <span
                                                class="kt-table-col-sort {{ $data['direction'] == 'asc' ? 'asc' : 'desc' }}"></span>
                                        @else
                                            <span class="kt-table-col-sort"></span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="w-20">
                                    <a href="{{ route('articles.index', array_merge(request()->query(), ['sort' => 'is_pinned', 'direction' => $data['sort'] == 'is_pinned' && $data['direction'] == 'asc' ? 'desc' : 'asc'])) }}"
                                        class="kt-table-col">
                                        <span class="kt-table-col-label">Disematkan</span>
                                        @if ($data['sort'] == 'is_pinned')
                                            <span
                                                class="kt-table-col-sort {{ $data['direction'] == 'asc' ? 'asc' : 'desc' }}"></span>
                                        @else
                                            <span class="kt-table-col-sort"></span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="w-20">
                                    <a href="{{ route('articles.index', array_merge(request()->query(), ['sort' => 'views', 'direction' => $data['sort'] == 'views' && $data['direction'] == 'asc' ? 'desc' : 'asc'])) }}"
                                        class="kt-table-col">
                                        <span class="kt-table-col-label">Dilihat</span>
                                        @if ($data['sort'] == 'views')
                                            <span
                                                class="kt-table-col-sort {{ $data['direction'] == 'asc' ? 'asc' : 'desc' }}"></span>
                                        @else
                                            <span class="kt-table-col-sort"></span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="w-10">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data['articles'] as $article)
                                <tr>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->user->name }}</td>
                                    <td>
                                        <span class="kt-badge kt-badge-primary">{{ $article->category->name }}</span>
                                    </td>
                                    <td>
                                        @foreach ($article->tags as $tag)
                                            <span class="kt-badge kt-badge-secondary">{{ $tag->name ?? $tag }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span
                                            class="kt-badge {{ $article->is_active ? 'kt-badge-success' : 'kt-badge-destructive' }}">
                                            {{ $article->is_active ? 'Ya' : 'Tidak' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="kt-badge {{ $article->is_pinned ? 'kt-badge-success' : 'kt-badge-destructive' }}">
                                            {{ $article->is_pinned ? 'Ya' : 'Tidak' }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($article->views) }}</td>
                                    <td>
                                        <div class="flex justify-start gap-2">
                                            <a href="{{ route('articles.show', $article->id) }}"
                                                class="kt-btn kt-btn-icon kt-btn-outline size-6">
                                                <i class="ki-filled ki-eye"></i>
                                            </a>
                                            <a href="{{ route('articles.edit', $article->id) }}"
                                                class="kt-btn kt-btn-icon kt-btn-outline size-6">
                                                <i class="ki-filled ki-pencil"></i>
                                            </a>
                                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST"
                                                style="display: inline;">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" data-kt-modal-toggle="#modal-delete-article-{{ $article->id }}"
                                                    class="kt-btn kt-btn-icon kt-btn-outline size-6">
                                                    <i class="ki-filled ki-trash"></i>
                                                </button>
                                                <div class="kt-modal z-40" data-kt-modal="true"
                                                    id="modal-delete-article-{{ $article->id }}">
                                                    <div
                                                        class="kt-modal-content max-w-md w-[90%] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                                                        <div class="kt-modal-header">
                                                            <h3 class="kt-modal-title">Konfirmasi Hapus</h3>
                                                            <button type="button" class="kt-modal-close"
                                                                aria-label="Close modal"
                                                                data-kt-modal-dismiss="#modal-delete-article-{{ $article->id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="lucide lucide-x" aria-hidden="true">
                                                                    <path d="M18 6 6 18"></path>
                                                                    <path d="m6 6 12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="kt-modal-body">
                                                            <div class="flex items-center gap-4">
                                                                <i class="ki-filled ki-lock text-4xl text-blue-600"></i>
                                                                <div>
                                                                    <p class="font-medium">Anda menghapus artikel:
                                                                        <strong>{{ $article->title }}</strong></p>
                                                                    <p class="text-sm text-muted">Pastikan data sudah
                                                                        dicadangkan sebelum melanjutkan.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="kt-modal-footer">
                                                            <div></div>
                                                            <div class="flex gap-4">
                                                                <button class="kt-btn kt-btn-secondary"
                                                                    data-kt-modal-dismiss="#modal-delete-article-{{ $article->id }}" type="button">Tidak,
                                                                    Kembali</button>
                                                                <button class="kt-btn kt-btn-primary" type="submit">Ya,
                                                                    Hapus</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-8">
                                        <div class="flex flex-col items-center gap-3">
                                            <i class="ki-filled ki-file-doc text-4xl text-gray-400"></i>
                                            <div>
                                                <p class="font-medium text-gray-600">Tidak ada artikel ditemukan</p>
                                                @if ($data['search'])
                                                    <p class="text-sm text-gray-500">
                                                        Pencarian untuk "{{ $data['search'] }}" tidak menghasilkan data
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Custom Pagination -->
                @if ($data['articles']->hasPages())
                    <div class="p-4 border-t">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                Menampilkan {{ $data['articles']->firstItem() }} sampai
                                {{ $data['articles']->lastItem() }}
                                dari {{ $data['articles']->total() }} data
                            </div>
                            <div class="flex items-center gap-2">
                                {{-- Previous Page Link --}}
                                @if ($data['articles']->onFirstPage())
                                    <span class="kt-btn kt-btn-sm kt-btn-disabled">« Sebelumnya</span>
                                @else
                                    <a href="{{ $data['articles']->previousPageUrl() }}"
                                        class="kt-btn kt-btn-sm kt-btn-outline">« Sebelumnya</a>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($data['articles']->getUrlRange(1, $data['articles']->lastPage()) as $page => $url)
                                    @if ($page == $data['articles']->currentPage())
                                        <span class="kt-btn kt-btn-sm kt-btn-primary">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline">{{ $page }}</a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($data['articles']->hasMorePages())
                                    <a href="{{ $data['articles']->nextPageUrl() }}"
                                        class="kt-btn kt-btn-sm kt-btn-outline">Berikutnya »</a>
                                @else
                                    <span class="kt-btn kt-btn-sm kt-btn-disabled">Berikutnya »</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- End of Container -->
@endsection
