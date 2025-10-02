<div class="kt-container-fixed space-y-5">
    <div>
        <h2 class="text-3xl font-semibold mb-8 text-gray-800">Youtube</h2>
        <div class="space-y-5">
            @foreach ($data['youtube'] as $embed)
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
        <h2 class="text-3xl font-semibold mb-8 text-gray-800">Spotify</h2>
        <div class="space-y-5">
            @foreach ($data['spotify'] as $embed)
                <div class="kt-card overflow-hidden">
                    <div
                        class="w-full [&_iframe]:w-full [&_iframe]:max-w-full [&_iframe]:h-auto [&_iframe]:aspect-video">
                        {!! $embed->embed_code !!}
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
