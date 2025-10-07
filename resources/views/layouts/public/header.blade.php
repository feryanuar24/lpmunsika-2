<header class="bg-gray-100 py-5">
    <div class="kt-container-fixed flex items-center justify-between">
        <div>
            <a href="{{ route('landing') }}">
                <img src="{{ asset('assets/media/app/default-logo.svg') }}" alt="Logo" class="h-10">
            </a>
        </div>

        <nav class="hidden lg:block">
            <ul class="kt-menu gap-5">
                <li><a href="{{ route('berita') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Berita</a></li>
                <li><a href="{{ route('buletin') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Buletin</a></li>
                <li class="inline-flex" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
                    <button class="kt-link kt-link-mono text-gray-800 text-sm" data-kt-dropdown-toggle="true">Karya
                        Mahasiswa</button>
                    <div class="kt-dropdown w-full max-w-56 p-3 text-sm" data-kt-dropdown-menu="true">
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{ route('resensi-buku') }}"
                                class="kt-link kt-link-mono text-gray-800 text-sm">Resensi Buku</a>
                            <a href="{{ route('review-film') }}"
                                class="kt-link kt-link-mono text-gray-800 text-sm">Review Film</a>
                            <a href="{{ route('opini') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Opini</a>
                            <a href="{{ route('esai') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Esai</a>
                            <a href="{{ route('artikel') }}"
                                class="kt-link kt-link-mono text-gray-800 text-sm">Artikel</a>
                            <a href="{{ route('puisi') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Puisi</a>
                            <a href="{{ route('cerpen') }}"
                                class="kt-link kt-link-mono text-gray-800 text-sm">Cerpen</a>
                        </div>
                    </div>
                </li>
                <li><a href="{{ route('gaya-mahasiswa') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Gaya
                        Mahasiswa</a></li>
            </ul>
        </nav>

        @guest
            <div class="space-x-2 hidden lg:block">
                <a href="{{ route('login') }}" class="kt-btn kt-btn-mono">Masuk</a>
                <a href="{{ route('register') }}" class="kt-btn kt-btn-outline">Daftar</a>
            </div>
        @endguest

        @auth
            <a href="{{ route('dashboard') }}" class="kt-btn kt-btn-mono hidden lg:block">Dashboard</a>
        @endauth

        <div class="inline-flex lg:hidden" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
            <button type="button" class="kt-btn kt-btn-icon kt-btn-outline" data-kt-dropdown-toggle="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-menu" aria-hidden="true">
                    <line x1="4" y1="8" x2="20" y2="8" />
                    <line x1="4" y1="16" x2="20" y2="16" />
                </svg>
            </button>
            <div class="kt-dropdown p-3 text-sm space-y-3" data-kt-dropdown-menu="true">
                <div class="kt-dropdown-item">
                    <a href="{{ route('berita') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Berita</a>
                </div>
                <div class="kt-dropdown-item">
                    <a href="{{ route('buletin') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Buletin</a>
                </div>
                <div class="kt-dropdown-item" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
                    <button class="kt-link kt-link-mono text-gray-800 text-sm w-full text-left"
                        data-kt-dropdown-toggle="true">Karya Mahasiswa</button>
                    <div class="kt-dropdown w-full max-w-56 p-3 text-sm" data-kt-dropdown-menu="true">
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{ route('resensi-buku') }}"
                                class="kt-link kt-link-mono text-gray-800 text-sm">Resensi Buku</a>
                            <a href="{{ route('review-film') }}"
                                class="kt-link kt-link-mono text-gray-800 text-sm">Review Film</a>
                            <a href="{{ route('opini') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Opini</a>
                            <a href="{{ route('esai') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Esai</a>
                            <a href="{{ route('artikel') }}"
                                class="kt-link kt-link-mono text-gray-800 text-sm">Artikel</a>
                            <a href="{{ route('puisi') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Puisi</a>
                            <a href="{{ route('cerpen') }}"
                                class="kt-link kt-link-mono text-gray-800 text-sm">Cerpen</a>
                        </div>
                    </div>
                </div>
                <div class="kt-dropdown-item">
                    <a href="{{ route('gaya-mahasiswa') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Gaya
                        Mahasiswa</a>
                </div>
                @guest
                    <div class="kt-dropdown-item">
                        <a href="{{ route('login') }}" class="kt-btn kt-btn-mono w-full text-center">Masuk</a>
                    </div>
                    <div class="kt-dropdown-item">
                        <a href="{{ route('register') }}" class="kt-btn kt-btn-outline w-full text-center">Daftar</a>
                    </div>
                @endguest
                @auth
                    <div class="kt-dropdown-item">
                        <a href="{{ route('dashboard') }}" class="kt-btn kt-btn-mono w-full text-center">Dashboard</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>
