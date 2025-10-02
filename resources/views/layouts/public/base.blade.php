<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">

<head>
    @include('layouts.partials.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="kt-sidebar-fixed kt-header-fixed flex h-full bg-background text-base text-foreground antialiased">
    @include('partials.theme-toggle')

    <!-- Page -->
    <!-- Main -->
    <div class="flex grow">
        <!-- Wrapper -->
        <div class="kt-wrapper flex grow flex-col">
            @include('layouts.public.header')

            <!-- Content -->
            <main class="py-5 grid grid-cols-3" id="content" role="content">
                <div class="col-span-2">
                    @yield('content')
                </div>
                <div class="col-span-1">
                    Spotify
                </div>
            </main>
            <!-- End of Content -->

            @include('layouts.public.footer')
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->
    <!-- End of Page -->

    @include('layouts.partials.scripts')
</body>

</html>
