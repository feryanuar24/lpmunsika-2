@extends('layouts.public.base')

@section('content')
    <div class="kt-container-fixed py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-semibold text-mon mb-2 border-b-4 inline-block pb-2">
                <i class="ki-filled ki-search-list text-mono mr-3"></i>
                Hasil Pencarian
            </h1>
            @if($data['query'])
                <p class="text-mono mt-4">
                    Menampilkan hasil pencarian untuk: <span class="font-semibold">"{{ $data['query'] }}"</span>
                </p>
                <p class="text-mono text-sm mt-2">
                    Ditemukan {{ $data['articles']->total() }} artikel
                </p>
            @else
                <p class="text-mono mt-4">Silakan masukkan kata kunci untuk mencari artikel</p>
            @endif
        </div>

        <!-- Search Form -->
        <div class="mb-8">
            <form action="{{ route('search') }}" method="GET" class="flex gap-3">
                <div class="flex-1">
                    <input type="text"
                           name="q"
                           value="{{ $data['query'] }}"
                           placeholder="Cari artikel, kategori, tag, atau penulis..."
                           class="kt-input w-full"
                           autofocus>
                </div>
                <button type="submit" class="kt-btn kt-btn-mono">
                    <i class="ki-filled ki-magnifier mr-2"></i>
                </button>
            </form>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-col-1 lg:grid-cols-2 gap-6">
            @forelse ($data['articles'] as $article)
                <article class="kt-card overflow-hidden">
                    <a href="{{ route('detail', $article->slug) }}" class="block">
                        <!-- Article Image -->
                        @if ($article->thumbnail_url)
                            <div class="kt-card-media">
                                <img src="{{ $article->thumbnail_url }}"
                                     alt="Thumbnail Artikel {{ $article->title }}"
                                     class="w-full h-48 object-cover"
                                     loading="lazy"
                                     decoding="async">
                            </div>
                        @endif

                        <!-- Article Content -->
                        <div class="kt-card-body p-5">
                            <!-- Title -->
                            <h2 class="text-xl font-semibold text-mono mb-3 line-clamp-2 hover:text-primary-600 transition-colors">
                                {{ $article->title }}
                            </h2>

                            <!-- Category -->
                            @if ($article->category)
                                <div class="mb-3">
                                    <span class="kt-badge kt-badge-primary kt-badge-sm">
                                        <i class="ki-filled ki-category text-xs mr-1"></i>
                                        {{ $article->category->name }}
                                    </span>
                                </div>
                            @endif

                            <!-- Tags -->
                            @if ($article->tags->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach ($article->tags as $tag)
                                        <span class="kt-badge kt-badge-secondary kt-badge-xs">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Content Excerpt -->
                            <p class="text-mono text-sm line-clamp-3 mb-4 leading-relaxed">
                                {{ Str::limit(strip_tags($article->content), 120, '...') }}
                            </p>

                            <!-- Article Meta -->
                            <div class="flex items-center justify-between text-xs text-mono border-t border-mono pt-3">
                                <div class="flex items-center gap-2">
                                    <i class="ki-filled ki-profile-circle"></i>
                                    <span>{{ $article->user->name }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ki-filled ki-calendar"></i>
                                    <span>{{ $article->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <!-- Empty State -->
                <div class="col-span-full text-center py-16">
                    <i class="ki-filled ki-file-search text-6xl text-mono mb-4"></i>
                    <h3 class="text-xl font-semibold text-mono mb-2">Tidak Ada Hasil</h3>
                    @if($data['query'])
                        <p class="text-mono">Tidak ditemukan artikel untuk kata kunci "{{ $data['query'] }}"</p>
                        <p class="text-mono text-sm mt-2">Coba gunakan kata kunci yang berbeda</p>
                    @else
                        <p class="text-mono">Silakan masukkan kata kunci pencarian</p>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($data['articles']->hasPages())
            <div class="mt-7">
                <!-- Pagination Info -->
                <div class="text-center text-sm text-mono mb-4">
                    Menampilkan {{ $data['articles']->firstItem() }} - {{ $data['articles']->lastItem() }}
                    dari {{ $data['articles']->total() }} artikel
                </div>
                <!-- Pagination Links -->
                <div class="flex justify-center">
                    {{ $data['articles']->appends(['q' => $data['query']])->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
