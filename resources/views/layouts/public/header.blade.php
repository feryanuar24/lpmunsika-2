<header class="bg-gray-100 py-5">
    <div class="kt-container-fixed flex items-center justify-between">
        <div>
            <a href="{{ route('landing') }}">
                <img src="{{ asset('assets/media/app/default-logo.svg') }}" alt="Logo" class="h-10">
            </a>
        </div>

        <nav>
            <ul class="kt-menu gap-5">
                <li><a href="{{ route('berita') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Berita</a></li>
                <li><a href="{{ route('buletin') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Buletin</a></li>
                <li class="inline-flex" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
                    <button class="kt-link kt-link-mono text-gray-800 text-sm" data-kt-dropdown-toggle="true">Karya Mahasiswa</button>
                    <div class="kt-dropdown w-full max-w-56 p-3 text-sm" data-kt-dropdown-menu="true"> 
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{ route('resensi-buku') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Resensi Buku</a>
                            <a href="{{ route('review-film') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Review Film</a>
                            <a href="{{ route('opini') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Opini</a>
                            <a href="{{ route('esai') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Esai</a>
                            <a href="{{ route('artikel') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Artikel</a>
                            <a href="{{ route('puisi') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Puisi</a>
                            <a href="{{ route('cerpen') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Cerpen</a>
                        </div>
                    </div>
                </li>
                <li><a href="{{ route('gaya-mahasiswa') }}" class="kt-link kt-link-mono text-gray-800 text-sm">Gaya
                        Mahasiswa</a></li>
            </ul>
        </nav>

        @guest
            <div class="space-x-2">
                <a href="{{ route('login') }}" class="kt-btn kt-btn-mono">Masuk</a>
                <a href="{{ route('register') }}" class="kt-btn kt-btn-outline">Daftar</a>
            </div>
        @endguest

        @auth
            <a href="{{ route('dashboard') }}" class="kt-btn kt-btn-mono">Dashboard</a>
        @endauth
    </div>
</header>
