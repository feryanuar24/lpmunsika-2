<header class="bg-gray-100 py-5">
    <div class="kt-container-fixed flex items-center justify-between">
        <div>
            <a href="{{ route('landing') }}">
                <img src="{{ asset('assets/media/app/default-logo.svg') }}" alt="Logo" class="h-10">
            </a>
        </div>

        <nav>
            <ul class="kt-menu gap-5">
                <li><a href="#berita" class="kt-link kt-link-mono text-gray-800 text-sm">Berita</a></li>
                <li><a href="#buletin" class="kt-link kt-link-mono text-gray-800 text-sm">Buletin</a></li>
                <li><a href="#karyaMahasiswa" class="kt-link kt-link-mono text-gray-800 text-sm">Karya Mahasiswa</a></li>
                <li><a href="#gayaMahasiswa" class="kt-link kt-link-mono text-gray-800 text-sm">Gaya Mahasiswa</a></li>
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
