<div class="flex items-center gap-1.5">
    <!-- Notifications -->
    <button class="kt-btn kt-btn-ghost kt-btn-icon size-8 hover:bg-background hover:[&amp;_i]:text-primary"
        data-kt-drawer-toggle="#notifications_drawer">
        <i class="ki-filled ki-notification-status text-lg">
        </i>
    </button>
    <!--Notifications Drawer-->

    <!--End of Notifications Drawer-->
    <!-- End of Notifications -->
    <form action="{{ route('logout') }}" method="POST">
        @method('DELETE')

        @csrf

        <button type="button" data-kt-modal-toggle="#modal"
            class="kt-btn kt-btn-ghost kt-btn-icon size-8 hover:bg-background hover:[&amp;_i]:text-primary">
            <i class="ki-filled ki-exit-right">
            </i>
        </button>
    </form>
</div>
