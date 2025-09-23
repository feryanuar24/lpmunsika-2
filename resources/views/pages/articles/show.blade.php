@extends('layouts.admin.base')

@section('content')
    <div class="kt-container-fixed py-8">
        <div class="flex items-center justify-between w-full mb-5">
            <h1 class="text-xl font-medium leading-none text-mono">Detail Artikel</h1>
            <a class="kt-btn kt-btn-outline" href="{{ route('articles.index') }}">
                Kembali
            </a>
        </div>
        <div class="kt-card max-w-3xl mx-auto p-8">

            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-4 items-center">
                    @if ($data['article']->thumbnail_url)
                        <img src="{{ $data['article']->thumbnail_url }}" alt="Thumbnail Artikel {{ $data['article']->title }}"
                            class="rounded-lg shadow-lg max-h-80 object-cover w-full max-w-xl" />
                    @endif
                    <div class="flex flex-wrap gap-4 text-gray-500 text-sm justify-center">
                        <div class="flex items-center gap-1"><i class="ki-filled ki-user"></i>
                            {{ $data['article']->user->name }}
                        </div>
                        <div class="flex items-center gap-1"><i class="ki-filled ki-category"></i>
                            {{ $data['article']->category->name }}</div>
                        <div class="flex items-center gap-1"><i class="ki-filled ki-calendar"></i>
                            {{ $data['article']->created_at->format('d M Y') }}</div>
                        <div class="flex items-center gap-1"><i class="ki-filled ki-calendar-edit"></i>
                            {{ $data['article']->updated_at->format('d M Y') }}</div>
                        <div class="flex items-center gap-1"><i class="ki-filled ki-eye"></i>
                            {{ $data['article']->views ?? 0 }} views
                        </div>
                        <div class="flex items-center gap-1"><i class="ki-filled ki-heart"></i>
                            {{ $data['article']->likes ?? 0 }} likes
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <h1 class="text-3xl font-bold text-center text-mono">{{ $data['article']->title }}</h1>
                    <div class="flex flex-wrap gap-2 justify-center mb-2">
                        @foreach ($data['article']->tags as $tag)
                            <span class="kt-badge kt-badge-info">{{ $tag->name ?? $tag }}</span>
                        @endforeach
                    </div>
                    <div class="prose max-w-none text-lg leading-relaxed">{!! $data['article']->content !!}</div>
                    <div class="flex flex-wrap gap-4 mt-4 justify-center">
                        <span class="kt-badge {{ $data['article']->is_active ? 'kt-badge-success' : 'kt-badge-danger' }}">
                            {{ $data['article']->is_active ? 'Dipublikasikan' : 'Diarsipkan' }}
                        </span>
                        <span
                            class="kt-badge {{ $data['article']->is_pinned ? 'kt-badge-warning' : 'kt-badge-secondary' }}">
                            {{ $data['article']->is_pinned ? 'Disematkan' : 'Tidak Disematkan' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endsection
