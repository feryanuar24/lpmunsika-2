<div class="kt-container-fixed space-y-5">
    <div>
        <h2 class="text-3xl font-semibold mb-8 text-mono border-b-2 pb-2 w-full lg:w-80">LPM Channel</h2>
        <div class="space-y-5">
            @foreach ($youtube as $embed)
                <div class="kt-card overflow-hidden">
                    <div
                        class="w-full [&_iframe]:w-full [&_iframe]:max-w-full [&_iframe]:h-auto [&_iframe]:aspect-video">
                        {!! $embed->embed_code !!}
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div>
        <h2 class="text-3xl font-semibold mb-8 text-mono border-b-2 pb-2 w-full lg:w-80">Podcast NOL SKS</h2>
        <div class="space-y-5">
            @foreach ($spotify as $embed)
                <div class="kt-card overflow-hidden">
                    <div
                        class="w-full [&_iframe]:w-full [&_iframe]:max-w-full [&_iframe]:h-auto [&_iframe]:aspect-video">
                        {!! $embed->embed_code !!}
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div>
        <h2 class="text-3xl font-semibold mb-8 text-mono border-b-2 pb-2 w-full lg:w-80">Categories</h2>
        <div class="flex flex-wrap gap-2">
            @foreach ($categories as $category)
                <a href="{{ route($category->slug) }}"
                    class="kt-badge badge-outline badge-sm">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>

    <div>
        <h2 class="text-3xl font-semibold mb-8 text-mono border-b-2 pb-2 w-full lg:w-80">Tags</h2>
        <div class="flex flex-wrap gap-2">
            @foreach ($tags as $tag)
                <a href="{{ route('tag', $tag->slug) }}"
                    class="kt-badge badge-outline badge-sm">{{ $tag->name }}</a>
            @endforeach
        </div>
    </div>
</div>
