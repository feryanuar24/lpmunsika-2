<div>
    <div class="grid grid-cols-2 gap-6">
        @foreach ($data['puisi'] as $article)
            <a href="{{ route('detail', $article->slug) }}"
                class="bg-white rounded-xl shadow-md overflow-hidden">

                <div>
                    @if ($article->thumbnail_url)
                        <img src="{{ $article->thumbnail_url }}" alt="Thumbnail Artikel {{ $article->title }}"
                            class="w-full h-48 object-cover" loading="lazy"
                            decoding="async" />
                    @endif
                </div>

                <div class="p-5 space-y-3">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ $article->title }}
                    </h3>

                    <div class="text-sm font-medium text-gray-500">
                        {{ $article->category->name }}
                    </div>

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
