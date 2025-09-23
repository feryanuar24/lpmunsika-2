<header class="flex items-center justify-between py-4 px-10 bg-gray-100">
    <div>
        <a href="{{ route('landing') }}">
            <h1 class="font-bold text-3xl">Laravel</h1>
        </a>
    </div>

    <nav>
        <ul class="kt-menu gap-5">
            <li><a href="#" class="kt-link">Section A</a></li>
            <li><a href="#" class="kt-link">Section B</a></li>
            <li><a href="#" class="kt-link">Section C</a></li>
        </ul>
    </nav>

    @guest
        <div class="space-x-2">
            <a href="{{ route('login') }}" class="kt-btn kt-btn-primary">Masuk</a>
            <a href="{{ route('register') }}" class="kt-btn kt-btn-outline">Daftar</a>
        </div>
    @endguest

    @auth
        <a href="{{ route('dashboard') }}" class="kt-btn kt-btn-primary">Dashboard</a>
    @endauth

</header>
