@extends('layouts.public.base')

@section('content')
    <div class="kt-container-fixed py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-semibold text-gray-900 mb-2 border-b-4 border-primary-600 inline-block pb-2">
                <i class="ki-filled ki-book text-primary-600 mr-3"></i>
                Semua Resensi Buku
            </h1>
            <p class="text-gray-600 mt-4">Kumpulan resensi buku pilihan dari mahasiswa UNSIKA</p>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-2 gap-6">
            @forelse ($data['articles'] as $article)
                <article class="kt-card kt-card-bordered hover:shadow-lg transition-shadow duration-300 overflow-hidden">
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
                            <h2 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2 hover:text-primary-600 transition-colors">
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
                                        <span class="kt-badge kt-badge-outline kt-badge-xs">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Content Excerpt -->
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4 leading-relaxed">
                                {{ Str::limit(strip_tags($article->content), 120, '...') }}
                            </p>

                            <!-- Article Meta -->
                            <div class="flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3">
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
                    <i class="ki-filled ki-file-search text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Artikel</h3>
                    <p class="text-gray-500">Artikel akan muncul di sini setelah dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($data['articles']->hasPages())
            <div class="mt-7">
                <!-- Pagination Info -->
                <div class="text-center text-sm text-gray-600 mb-4">
                    Menampilkan {{ $data['articles']->firstItem() }} - {{ $data['articles']->lastItem() }}
                    dari {{ $data['articles']->total() }} artikel
                </div>
                <!-- Pagination Links -->
                <div class="flex justify-center">
                    {{ $data['articles']->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
