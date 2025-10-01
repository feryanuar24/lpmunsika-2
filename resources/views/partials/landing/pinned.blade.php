<div>
    <h2 class="text-3xl font-semibold mb-8 text-gray-800">Berita Disematkan</h2>
    <div class="grid grid-cols-2 gap-6">
        @foreach ($data['pinnedArticles'] as $index => $article)
            <a href="{{ route('articles.show', $article->slug) }}"
                class="bg-white rounded-xl shadow-md overflow-hidden {{ $index === 0 ? 'col-span-2' : '' }}">

                <div>
                    @if ($article->thumbnail_url)
                        <img src="{{ $article->thumbnail_url }}" alt="Thumbnail Artikel {{ $article->title }}"
                            class="w-full h-48 object-cover transform group-hover:scale-105 transition duration-500" />
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
                </div>

                <div class="p-5 relative">
                    <h3 class="text-xl font-semibold text-gray-900 group-hover:text-blue-600 line-clamp-2">
                        {{ $article->title }}
                    </h3>

                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach ($article->tags as $tag)
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                {{ $tag->name ?? $tag }}
                            </span>
                        @endforeach
                    </div>

                    <p class="mt-3 text-sm text-gray-600 line-clamp-3">
                        {{ Str::limit(strip_tags($article->content), 120, '...') }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>
