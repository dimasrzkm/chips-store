<aside class="h-full w-80 bg-base-200">
    <div
        class="sticky top-0 z-20 items-center justify-center hidden gap-2 px-4 py-5 shadow-sm bg-base-200 bg-opacity-90 backdrop-blur lg:flex">
        <a href="#" class="text-2xl text-center">Dashboard</a>
    </div>
    {{-- responsive --}}
    <div
        class="sticky top-0 z-20 flex items-center justify-center gap-2 px-4 py-2 shadow-sm bg-base-200 bg-opacity-90 backdrop-blur lg:hidden">
        <a href="#" class="text-2xl text-center">Dashboards</a>
    </div>
    <ul class="h-full p-4 menu w-80 bg-base-200">
        <!-- Sidebar content here -->
        <li><a href="{{ url('/') }}" wire:navigate>Dashboard</a></li>
        <li><a href="{{ route('permissions.index') }}" wire:navigate>Permissions</a></li>
        <li><a href="{{ route('roles.index') }}" wire:navigate>Roles</a></li>
        <li><a href="{{ route('assignable.index') }}" wire:navigate>Apply Permissions</a></li>
        <li><a href="{{ route('assign.index') }}" wire:navigate>Apply Roles</a></li>
    </ul>
    <div
        class="sticky bottom-0 flex h-20 pointer-events-none from-base-200 bg-gradient-to-t to-transparent" />
</aside>