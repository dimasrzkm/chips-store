<div class="bg-base-100 drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
        <div class="sticky top-0 z-10 shadow-sm navbar bg-base-100 bg-opacity-90 backdrop-blur dark:shadow-gray-700">
            <div class="navbar-start">
                <div>
                    <label class="btn btn-ghost lg:hidden" for="my-drawer-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h8m-8 6h16"></path>
                        </svg>
                    </label>
                </div>
                {{-- <a class="text-xl normal-case btn btn-ghost">Sistem Pengelolaan Keuangan</a> --}}
            </div>
            <div class="navbar-end">
                <x-drawer.drawer-profile-info :authinfo="auth()->user()"/>
            </div>
        </div>
        <div class="p-4">
            {{ $slot }}
        </div>
    </div>
    <div class="z-40 h-screen drawer-side">
        <label for="my-drawer-2" class="drawer-overlay"></label>
        <x-drawer.drawer-navigation />
    </div>
</div>    