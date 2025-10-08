<div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach ($data['cerpen'] as $article)
            <a href="{{ route('detail', $article->slug) }}"
                class="kt-card overflow-hidden">

                <div>
                    @if ($article->thumbnail_url)
                        <img src="{{ $article->thumbnail_url }}" alt="Thumbnail Artikel {{ $article->title }}"
                            class="w-full h-48 object-cover" loading="lazy"
                            decoding="async" />
                    @endif
                </div>

                <div class="p-5 space-y-3">
                    <h3 class="text-xl font-semibold text-mono">
                        {{ $article->title }}
                    </h3>

                    <div class="text-sm font-medium text-mono">
                        {{ $article->category->name }}
                    </div>

                    <div class="flex gap-2">
                        @foreach ($article->tags as $tag)
                            <span class="kt-badge kt-badge-outline kt-badge-secondary rounded-full">
                                {{ $tag->name ?? $tag }}
                            </span>
                        @endforeach
                    </div>

                    <p class="text-sm text-mono">
                        {{ Str::limit(strip_tags($article->content), 120, '...') }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>
