@props(['authinfo'])
<div class="dropdown dropdown-bottom dropdown-end">
    <label tabindex="0" class="m-1 btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
            </path>
        </svg>
    </label>
    <ul tabindex="0" class="p-2 shadow dropdown-content menu bg-base-100 rounded-box w-52">
        <li>
            {{-- <p class="inline-flex justify-between leading-tight">Dalton Rath</p> --}}
            <p class="inline-flex justify-between leading-tight">{{ $authinfo->username }}</p>
        </li>
        <li>
            <a class="inline-flex justify-between">Profile
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z">
                    </path>
                </svg>
            </a>
        </li>
        <li>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex justify-between w-full">
                    Logout
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="w-5 h-5 ml-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9">
                        </path>
                    </svg>
                </button>
            </form>
        </li>
    </ul>
</div>