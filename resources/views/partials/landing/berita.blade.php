<div>
    <h2 class="text-3xl font-semibold mb-8 text-gray-800">Berita Terbaru</h2>
    <div class="grid grid-cols-2 gap-6">
        @foreach ($data['berita'] as $index => $article)
            <a href="{{ route('articles.show', $article->slug) }}"
                class="bg-white rounded-xl shadow-md overflow-hidden {{ $index === 0 ? 'col-span-2' : '' }}">

                <div>
                    @if ($article->thumbnail_url)
                        <img src="{{ $article->thumbnail_url }}" alt="Thumbnail Artikel {{ $article->title }}"
                            class="w-full {{ $index === 0 ? 'h-full' : 'h-48' }} object-cover" loading="lazy"
                            decoding="async" />
                    @endif
                </div>

                <div class="p-5 space-y-3">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ $article->title }}
                    </h3>

                    <div class="flex gap-2">
                        @foreach ($article->tags as $tag)
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                {{ $tag->name ?? $tag }}
                            </span>
                        @endforeach
                    </div>

                    <p class="text-sm text-gray-600">
                        {{ Str::limit(strip_tags($article->content), 120, '...') }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>
