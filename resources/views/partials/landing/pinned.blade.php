<div>
    <h2 class="text-3xl font-semibold mb-8 text-mono border-b-2 pb-2 w-full lg:w-80">Sorotan</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach ($data['pinnedArticles'] as $index => $article)
            <a href="{{ route('detail', $article->slug) }}"
                class="kt-card overflow-hidden {{ $index === 0 ? 'col-span-1 lg:col-span-2' : '' }}">

                <div>
                    @if ($article->thumbnail_url)
                        <img src="{{ $article->thumbnail_url }}" alt="Thumbnail Artikel {{ $article->title }}"
                            class="w-full {{ $index === 0 ? 'h-full' : 'h-48' }} object-cover" loading="lazy"
                            decoding="async" />
                    @endif
                </div>

                <div class="p-5 space-y-3">
                    <h3 class="text-xl font-semibold text-mono">
                        {{ $article->title }}
                    </h3>

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
