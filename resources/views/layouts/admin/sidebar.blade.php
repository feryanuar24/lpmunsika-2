<!-- Sidebar -->
<div class="kt-sidebar fixed bottom-0 top-0 z-20 hidden shrink-0 flex-col items-stretch border-e border-e-border bg-background [--kt-drawer-enable:true] lg:flex lg:[--kt-drawer-enable:false]"
    data-kt-drawer="true" data-kt-drawer-class="kt-drawer kt-drawer-start top-0 bottom-0" id="sidebar">
    <div class="kt-sidebar-header relative hidden shrink-0 items-center justify-between px-3 lg:flex lg:px-6"
        id="sidebar_header">
        <a class="dark:hidden" href="{{ route('dashboard') }}">
            <img class="default-logo h-10 max-w-none" src="{{ asset('assets/media/app/default-logo.svg') }}" />
            <img class="small-logo h-10 max-w-none" src="{{ asset('assets/media/app/mini-logo.svg') }}" />
        </a>
        <a class="hidden dark:block" href="{{ route('dashboard') }}">
            <img class="default-logo h-10 max-w-none" src="{{ asset('assets/media/app/default-logo-dark.svg') }}" />
            <img class="small-logo h-10 max-w-none" src="{{ asset('assets/media/app/mini-logo.svg') }}" />
        </a>
        <button
            class="kt-btn kt-btn-outline kt-btn-icon absolute start-full top-2/4 size-[30px] -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4"
            data-kt-toggle="body" data-kt-toggle-class="kt-sidebar-collapse" id="sidebar_toggle">
            <i
                class="ki-filled ki-black-left-line kt-toggle-active:rotate-180 rtl:translate rtl:kt-toggle-active:rotate-0 transition-all duration-300 rtl:rotate-180">
            </i>
        </button>
    </div>
    <div class="kt-sidebar-content flex shrink-0 grow py-5 pe-2" id="sidebar_content">
        <div class="kt-scrollable-y-hover flex shrink-0 grow pe-1 ps-2 lg:pe-3 lg:ps-5" data-kt-scrollable="true"
            data-kt-scrollable-dependencies="#sidebar_header" data-kt-scrollable-height="auto"
            data-kt-scrollable-offset="0px" data-kt-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">
            <!-- Sidebar Menu -->
            <div class="kt-menu flex grow flex-col gap-1" data-kt-menu="true" data-kt-menu-accordion-expand-all="false"
                id="sidebar_menu">
                <div class="kt-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('dashboard') }}"
                        class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        tabindex="0">
                        <span class="kt-menu-icon w-[20px] items-start text-muted-foreground">
                            <i class="ki-filled ki-element-11 text-lg">
                            </i>
                        </span>
                        <span
                            class="kt-menu-title kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium text-foreground">
                            Dashboards
                        </span>
                    </a>
                </div>
                <div class="kt-menu-item pt-2.25 pb-px">
                    <span
                        class="kt-menu-heading pe-[10px] ps-[10px] text-xs font-medium uppercase text-muted-foreground">
                        Pengguna
                    </span>
                </div>
                <div class="kt-menu-item {{ request()->routeIs('profile', 'profile.edit') ? 'active' : '' }}"
                    data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('profile') }}"
                        class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        tabindex="0">
                        <span class="kt-menu-icon w-[20px] items-start text-muted-foreground">
                            <i class="ki-filled ki-profile-circle text-lg">
                            </i>
                        </span>
                        <span
                            class="kt-menu-title kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium text-foreground">
                            Profil
                        </span>
                    </a>
                </div>
                <div class="kt-menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}"
                    data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('users.index') }}"
                        class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        tabindex="0">
                        <span class="kt-menu-icon w-[20px] items-start text-muted-foreground">
                            <i class="ki-filled ki-users text-lg">
                            </i>
                        </span>
                        <span
                            class="kt-menu-title kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium text-foreground">
                            Data
                        </span>
                    </a>
                </div>
                <div class="kt-menu-item pt-2.25 pb-px">
                    <span
                        class="kt-menu-heading pe-[10px] ps-[10px] text-xs font-medium uppercase text-muted-foreground">
                        Artikel
                    </span>
                </div>
                <div class="kt-menu-item {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                    data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('categories.index') }}"
                        class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        tabindex="0">
                        <span class="kt-menu-icon w-[20px] items-start text-muted-foreground">
                            <i class="ki-filled ki-category text-lg">
                            </i>
                        </span>
                        <span
                            class="kt-menu-title kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium text-foreground">
                            Kategori
                        </span>
                    </a>
                </div>
                <div class="kt-menu-item {{ request()->routeIs('tags.*') ? 'active' : '' }}"
                    data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('tags.index') }}"
                        class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        tabindex="0">
                        <span class="kt-menu-icon w-[20px] items-start text-muted-foreground">
                            <i class="ki-filled ki-price-tag text-lg">
                            </i>
                        </span>
                        <span
                            class="kt-menu-title kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium text-foreground">
                            Tag
                        </span>
                    </a>
                </div>
                <div class="kt-menu-item {{ request()->routeIs('articles.*') ? 'active' : '' }}"
                    data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('articles.index') }}"
                        class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        tabindex="0">
                        <span class="kt-menu-icon w-[20px] items-start text-muted-foreground">
                            <i class="ki-filled ki-document text-lg">
                            </i>
                        </span>
                        <span
                            class="kt-menu-title kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium text-foreground">
                            Data
                        </span>
                    </a>
                </div>
                <div class="kt-menu-item pt-2.25 pb-px">
                    <span
                        class="kt-menu-heading pe-[10px] ps-[10px] text-xs font-medium uppercase text-muted-foreground">
                        Integrasi
                    </span>
                </div>
                <div class="kt-menu-item {{ request()->routeIs('platforms.*') ? 'active' : '' }}"
                    data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('platforms.index') }}"
                        class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        tabindex="0">
                        <span class="kt-menu-icon w-[20px] items-start text-muted-foreground">
                            <i class="ki-filled ki-lock text-lg">
                            </i>
                        </span>
                        <span
                            class="kt-menu-title kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium text-foreground">
                            Platform
                        </span>
                    </a>
                </div>
                <div class="kt-menu-item {{ request()->routeIs('embeds.*') ? 'active' : '' }}"
                    data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('embeds.index') }}"
                        class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        tabindex="0">
                        <span class="kt-menu-icon w-[20px] items-start text-muted-foreground">
                            <i class="ki-filled ki-code text-lg">
                            </i>
                        </span>
                        <span
                            class="kt-menu-title kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium text-foreground">
                            Penyematan
                        </span>
                    </a>
                </div>
                <div class="kt-menu-item pt-2.25 pb-px">
                    <span
                        class="kt-menu-heading pe-[10px] ps-[10px] text-xs font-medium uppercase text-muted-foreground">
                        Pengaturan
                    </span>
                </div>
                <div class="kt-menu-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}"
                    data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('permissions.index') }}"
                        class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        tabindex="0">
                        <span class="kt-menu-icon w-[20px] items-start text-muted-foreground">
                            <i class="ki-filled ki-social-media text-lg">
                            </i>
                        </span>
                        <span
                            class="kt-menu-title kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium text-foreground">
                            Permission
                        </span>
                    </a>
                </div>
                <div class="kt-menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}"
                    data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('roles.index') }}"
                        class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        tabindex="0">
                        <span class="kt-menu-icon w-[20px] items-start text-muted-foreground">
                            <i class="ki-filled ki-key text-lg">
                            </i>
                        </span>
                        <span
                            class="kt-menu-title kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium text-foreground">
                            Role
                        </span>
                    </a>
                </div>
                <div class="kt-menu-item {{ request()->routeIs('permission-role.*') ? 'active' : '' }}"
                    data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('permission-role.index') }}"
                        class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        tabindex="0">
                        <span class="kt-menu-icon w-[20px] items-start text-muted-foreground">
                            <i class="ki-filled ki-key-square text-lg">
                            </i>
                        </span>
                        <span
                            class="kt-menu-title kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium text-foreground">
                            Permission Role
                        </span>
                    </a>
                </div>
            </div>
            <!-- End of Sidebar Menu -->
        </div>
    </div>
</div>
<!-- End of Sidebar -->
