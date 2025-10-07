@extends('layouts.public.base')

@section('content')
    <div class="kt-container-fixed space-y-5">
        <div class="kt-card px-5">
            <!-- Article Header -->
            <div class="kt-card-header space-y-5 py-10">
                <!-- Title -->
                <h1 class="text-4xl font-semibold text-gray-900">
                    {{ $data['article']->title }}
                </h1>

                <!-- Article Meta -->
                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4">
                    <!-- Author -->
                    <div class="flex items-center gap-2">
                        <i class="ki-filled ki-profile-circle text-gray-500"></i>
                        <span class="text-sm font-medium text-gray-500">{{ $data['article']->user->name }}</span>
                    </div>

                    <!-- Category -->
                    <div class="flex items-center gap-2">
                        <i class="ki-filled ki-category text-gray-500"></i>
                        <span class="text-sm font-medium text-gray-500">{{ $data['article']->category->name }}</span>
                    </div>

                    <!-- Date -->
                    <div class="flex items-center gap-2">
                        <i class="ki-filled ki-calendar text-gray-500"></i>
                        <span
                            class="text-sm font-medium text-gray-500">{{ $data['article']->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Tags -->
                @if ($data['article']->tags->count() > 0)
                    <div class="flex gap-2">
                        @foreach ($data['article']->tags as $tag)
                            <span class="kt-badge kt-badge-outline kt-badge-sm">
                                <i class="ki-filled ki-tag text-xs mr-2"></i>
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <!-- Thumbnail -->
                @if ($data['article']->thumbnail_url)
                    <div class="rounded-lg overflow-hidden shadow-lg">
                        <img src="{{ $data['article']->thumbnail_url }}"
                            alt="Thumbnail Artikel {{ $data['article']->title }}" class="w-full h-auto object-cover"
                            loading="lazy" decoding="async" />
                    </div>
                @endif
            </div>

            <!-- Article Content -->
            <div class="kt-card-content py-10">
                <div class="text-gray-800 ">
                    {!! $data['article']->content !!}
                </div>
            </div>

            <!-- Interaction Section -->
            <div class="kt-card-footer flex flex-col items-start gap-5">
                <!-- Like -->
                <div class="">
                    <form action="{{ route('like', $data['article']->id) }}" method="post">
                        @csrf
                        <input type="text" name="slug" value="{{ $data['article']->slug }}" hidden />
                        <button type="submit" class="kt-btn kt-btn-destructive kt-btn-sm">
                            <i class="ki-filled ki-heart text-sm mr-2"></i>
                            {{ $data['article']->likes }} Suka
                        </button>
                    </form>
                </div>

                <!-- Comments -->
                <div class="w-full space-y-5">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="ki-filled ki-message-text text-gray-600 mr-2"></i>
                        Komentar ({{ $data['article']->comments->count() }})
                    </h3>

                    @if ($data['article']->comments->count() > 0)
                        <div class="space-y-3">
                            @foreach ($data['article']->comments as $comment)
                                <div class="kt-card kt-card-bordered px-5 py-3">
                                    <div class="kt-card-body">
                                        <div class="flex flex-col items-start gap-2">
                                            <!-- User Avatar -->
                                            <div class="flex items-center gap-2">
                                                <i class="ki-filled ki-profile-circle text-gray-500 text-xl"></i>
                                                <div>
                                                    <span
                                                        class="font-medium text-gray-800">{{ $comment->user->name }}</span>
                                                    <span class="text-xs text-gray-500">•</span>
                                                    <span
                                                        class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <p class="text-gray-800">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="ki-filled ki-message-text text-4xl text-gray-300 mb-2"></i>
                            <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @endif

                    @auth
                        <form action="{{ route('comment') }}" method="post">
                            @csrf
                            <div class="flex items-center gap-2">
                                <input type="text" name="slug" value="{{ $data['article']->slug }}" hidden />
                                <input type="text" name="content" placeholder="Tulis komentar..." class="kt-input"
                                    required />
                                <button type="submit" class="kt-btn kt-btn-sm">
                                    <i class="ki-filled ki-send text-sm mr-2"></i>
                                    Kirim
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center">
                            <p class="text-gray-500">Silakan <a href="{{ route('login') }}" class="kt-link">masuk</a> untuk
                                berkomentar.</p>
                        </div>
                    @endauth

                </div>


            </div>
        </div>
    </div>
@endsection
