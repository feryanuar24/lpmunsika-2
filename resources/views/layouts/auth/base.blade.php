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
    <div class="flex grow flex-col lg:flex-row">
        @include('layouts.auth.sidebar')

        <!-- Wrapper -->
        <div class="w-full items-center justify-center flex kt-container-fixed py-10 lg:py-0">
            <!-- Content -->
            <main id="content" role="content">
                @yield('content')
            </main>
            <!-- End of Content -->
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->
    <!-- End of Page -->

    @include('layouts.partials.scripts')
</body>

</html>
