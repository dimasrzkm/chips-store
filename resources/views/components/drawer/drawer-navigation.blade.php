<aside class="@if (in_array(
        'kasir',
        auth()->user()->roles->pluck('name')->toArray()) ||
        auth()->user()->roles->count() == 0) h-screen @endif w-80 bg-base-200">
    <div
        class="sticky top-0 z-20 items-center justify-center hidden gap-2 px-4 py-5 shadow-sm bg-base-200 bg-opacity-90 backdrop-blur lg:flex">
        <a href="{{ route('dashboard') }}" class="text-2xl font-semibold text-center" wire:navigate>Dashboard</a>
    </div>
    {{-- responsive --}}
    <div
        class="sticky top-0 z-20 flex items-center justify-center gap-2 px-4 py-2 shadow-sm bg-base-200 bg-opacity-90 backdrop-blur lg:hidden">
        <a href="{{ route('dashboard') }}" class="text-2xl text-center">Dashboards</a>
    </div>
    <div class="h-4"></div>
    {{-- Peran dan Perizinan --}}
    @can('melihat peran dan perizinan')
        <ul class="px-4 py-0 menu menu-sm lg:menu-md">
            <li class="flex flex-row items-center gap-4 menu-title">
                <span class="text-base-content">
                    <svg fill="#000000" width="24" height="24" viewBox="-192 -192 2304.00 2304.00"
                        xmlns="http://www.w3.org/2000/svg" stroke="#000000" transform="matrix(1, 0, 0, 1, 0, 0)">

                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC"
                            stroke-width="11.52" />

                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M1600 1066.667c117.653 0 213.333 95.68 213.333 213.333v106.667H1920V1760c0 88.213-71.787 160-160 160h-320c-88.213 0-160-71.787-160-160v-373.333h106.667V1280c0-117.653 95.68-213.333 213.333-213.333ZM800 0c90.667 0 179.2 25.6 254.933 73.6 29.867 18.133 58.667 40.533 84.267 66.133 49.067 49.067 84.8 106.88 108.053 169.814 11.307 30.4 20.8 61.44 25.814 94.08l2.24 14.613 3.626 20.16-.533.32v.213l-52.693 32.427c-44.694 28.907-95.467 61.547-193.067 61.867-.427 0-.747.106-1.173.106-24.534 0-46.08-2.133-65.28-5.653-.64-.107-1.067-.32-1.707-.427-56.32-10.773-93.013-34.24-126.293-55.68-9.6-6.293-18.774-12.16-28.16-17.6-27.947-16-57.92-27.306-108.16-27.306h-.32c-57.814.106-88.747 15.893-121.387 36.266-4.48 2.88-8.853 5.44-13.44 8.427-3.093 2.027-6.72 4.16-9.92 6.187-6.293 4.053-12.693 8.106-19.627 12.16-4.48 2.666-9.493 5.013-14.293 7.573-6.933 3.627-13.973 7.147-21.76 10.453-6.613 2.987-13.76 5.547-21.12 8.107-6.933 2.347-14.507 4.267-22.187 6.293-8.96 2.347-17.813 4.587-27.84 6.187-1.173.213-2.133.533-3.306.747v57.6c0 17.066 1.066 34.133 4.266 50.133C454.4 819.2 611.2 960 800 960c195.2 0 356.267-151.467 371.2-342.4 48-14.933 82.133-37.333 108.8-54.4v23.467c0 165.546-84.373 311.786-212.373 398.08h4.906a1641.19 1641.19 0 0 1 294.08 77.76C1313.28 1119.68 1280 1195.733 1280 1280h-106.667v480c0 1.387.427 2.667.427 4.16-142.933 37.547-272.427 49.173-373.76 49.173-345.493 0-612.053-120.32-774.827-221.333L0 1576.32v-196.373c0-140.054 85.867-263.04 218.667-313.28 100.373-38.08 204.586-64.96 310.186-82.347h4.8C419.52 907.413 339.2 783.787 323.2 640c-2.133-17.067-3.2-35.2-3.2-53.333V480c0-56.533 9.6-109.867 27.733-160C413.867 133.333 592 0 800 0Zm800 1173.333c-58.773 0-106.667 47.894-106.667 106.667v106.667h213.334V1280c0-58.773-47.894-106.667-106.667-106.667Z"
                                fill-rule="evenodd" />
                        </g>
                    </svg>
                </span>
                <span>Peran dan Perizinan</span>
            </li>
            @can('melihat peran')
                <li><a href="{{ route('roles.index') }}" wire:navigate>Peran</a></li>
            @endcan
            @can('melihat izin')
                <li><a href="{{ route('permissions.index') }}" wire:navigate><span>Izin</span></a></li>
            @endcan
            @can('melihat perizinan peran')
                <li><a href="{{ route('assignable.index') }}" wire:navigate>Perizinan Peran</a></li>
            @endcan
            @can('melihat peran pengguna')
                <li><a href="{{ route('assign.index') }}" wire:navigate>Peran Pengguna</a></li>
            @endcan
        </ul>
    @endcan
    {{-- Pengguna --}}
    @can('melihat pengguna')
        <ul class="px-4 py-0 menu menu-sm lg:menu-md">
            <li></li>
            <li class="flex flex-row items-center gap-4 menu-title">
                <span class="text-base-content">
                    <svg fill="#000000" width="20" height="20" viewBox="0 0 1920 1920"
                        xmlns="http://www.w3.org/2000/svg">

                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M1587.854 1133.986c-109.666-42.353-223.51-72.057-339.276-91.257h-5.195c135.53-91.369 224.866-246.324 224.866-421.609v-24.847c-28.235 18.07-64.377 41.788-115.087 57.713-15.925 202.165-186.466 362.428-393.148 362.428-199.793 0-365.93-148.97-390.777-342.212-3.388-16.94-4.517-34.898-4.517-53.082v-60.988c1.355-.113 2.258-.452 3.614-.678 10.503-1.807 19.877-4.179 29.364-6.663 8.132-2.033 16.15-4.18 23.38-6.664 7.905-2.71 15.472-5.421 22.587-8.583 8.132-3.502 15.586-7.116 23.04-10.956 5.083-2.823 10.391-5.308 15.135-8.132a662.834 662.834 0 0 0 20.668-12.762c3.388-2.259 7.34-4.518 10.503-6.55 4.857-3.163 9.6-5.986 14.344-8.923 34.447-21.572 67.313-38.4 128.527-38.513h.226c53.195 0 84.932 12.085 114.635 29.026 9.826 5.647 19.539 11.972 29.817 18.522 35.124 22.815 73.976 47.549 133.722 58.956.678.113 1.13.452 1.807.564 20.33 3.728 43.143 5.873 69.007 5.873.452 0 .79-.113 1.242-.113 103.342-.225 157.214-34.785 204.537-65.392l55.793-34.448v-.112l.564-.452-3.952-21.346-2.372-15.473c-5.308-34.447-15.247-67.426-27.22-99.501-24.733-66.748-62.568-127.963-114.521-179.803-26.993-27.218-57.6-50.936-89.224-70.136-80.188-50.71-173.93-77.93-269.93-77.93-220.235 0-408.846 141.177-478.87 338.824-19.2 53.082-29.365 109.553-29.365 169.412V621.12c0 19.2 1.13 38.4 3.502 56.47C472.108 829.949 557.152 960.735 678 1042.166h-5.083c-111.812 18.41-222.042 46.983-328.433 87.19-140.612 53.309-231.53 183.417-231.53 331.709V1669.1l26.768 16.49c172.235 106.955 454.475 234.353 820.292 234.353 201.938 0 508.235-40.546 820.404-234.353l26.654-16.49v-208.037c0-144.904-88.094-276.255-219.218-327.078"
                                fill-rule="evenodd" />
                        </g>
                    </svg>
                </span>
                <span>Data Pengguna</span>
            </li>
            <li><a href="{{ route('users.index') }}" wire:navigate>Pengguna</a></li>
        </ul>
    @endcan
    {{-- Supplier --}}
    @canany(['melihat bahan baku', 'melihat supplier'])
        <ul class="px-4 py-0 menu menu-sm lg:menu-md">
            <li></li>
            <li class="flex flex-row items-center gap-4 menu-title">
                <span class="text-base-content">
                    <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="24"
                        viewBox="0 0 444.185 444.184" xml:space="preserve">

                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <path
                                        d="M404.198,205.738c-0.917-0.656-2.096-0.83-3.165-0.467c0,0-119.009,40.477-122.261,41.598 c-2.725,0.938-4.487-1.42-4.487-1.42l-37.448-46.254c-0.935-1.154-2.492-1.592-3.89-1.098c-1.396,0.494-2.332,1.816-2.332,3.299 v167.891c0,1.168,0.583,2.26,1.556,2.91c0.584,0.391,1.263,0.59,1.945,0.59c0.451,0,0.906-0.088,1.336-0.267l168.045-69.438 c1.31-0.541,2.163-1.818,2.163-3.234v-91.266C405.66,207.456,405.116,206.397,404.198,205.738z" />
                                    <path
                                        d="M443.487,168.221l-32.07-42.859c-0.46-0.615-1.111-1.061-1.852-1.27L223.141,71.456c-0.622-0.176-1.465-0.125-2.096,0.049 L34.62,124.141c-0.739,0.209-1.391,0.654-1.851,1.27L0.698,168.271c-0.672,0.898-0.872,2.063-0.541,3.133 c0.332,1.07,1.157,1.918,2.219,2.279l157.639,53.502c0.369,0.125,0.749,0.187,1.125,0.187c1.035,0,2.041-0.462,2.718-1.296 l44.128-54.391l13.082,3.6c0.607,0.168,1.249,0.168,1.857,0v-0.008c0.064-0.016,0.13-0.023,0.192-0.041l13.082-3.6l44.129,54.391 c0.677,0.834,1.683,1.295,2.718,1.295c0.376,0,0.756-0.061,1.125-0.186l157.639-53.502c1.062-0.361,1.887-1.209,2.219-2.279 C444.359,170.283,444.159,169.119,443.487,168.221z M222.192,160.381L88.501,123.856l133.691-37.527l133.494,37.479 L222.192,160.381z" />
                                    <path
                                        d="M211.238,198.147c-1.396-0.494-2.955-0.057-3.889,1.098L169.901,245.5c0,0-1.764,2.356-4.488,1.42 c-3.252-1.121-122.26-41.598-122.26-41.598c-1.07-0.363-2.248-0.189-3.165,0.467c-0.918,0.658-1.462,1.717-1.462,2.846v91.267 c0,1.416,0.854,2.692,2.163,3.233l168.044,69.438c0.43,0.178,0.885,0.266,1.336,0.266c0.684,0,1.362-0.199,1.946-0.59 c0.972-0.65,1.555-1.742,1.555-2.91V201.445C213.57,199.963,212.635,198.641,211.238,198.147z" />
                                </g>
                            </g>
                        </g>

                    </svg>
                </span>
                <span>Data Supplier</span>
            </li>
            @can('melihat supplier')
                <li><a href="{{ route('suppliers.index') }}" wire:navigate>Supplier</a></li>
            @endcan
            @can('melihat bahan baku')
                <li><a href="{{ route('stocks.index') }}" wire:navigate>Bahan Baku</a></li>
            @endcan
        </ul>
    @endcanany
    {{-- Konsinyor atau penitip barang --}}
    @can('melihat konsinyor', 'melihat catatan penitipan')
        <ul class="px-4 py-0 menu menu-sm lg:menu-md">
            <li></li>
            <li class="flex flex-row items-center gap-4 menu-title">
                <span class="text-base-content">
                    <svg fill="#000000" height="19" width="19" version="1.1" id="Layer_1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 491.52 491.52" xml:space="preserve">

                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <path
                                        d="M491.356,162.98c-0.102-2.314-0.492-4.628-1.393-6.84c-0.041-0.102-0.041-0.225-0.102-0.328v-0.041l-61.44-143.36 C425.206,4.874,417.792,0,409.6,0H81.92c-8.192,0-15.606,4.874-18.821,12.411l-61.44,143.36c0,0.021,0,0.021-0.021,0.041 c-0.041,0.102-0.041,0.205-0.082,0.328c-0.901,2.212-1.29,4.526-1.393,6.84c0,0.307-0.164,0.553-0.164,0.86v307.2 c0,11.305,9.155,20.48,20.48,20.48h450.56c11.325,0,20.48-9.175,20.48-20.48v-307.2 C491.52,163.533,491.356,163.287,491.356,162.98z M219.279,321.679c-3.994,3.994-9.237,6.001-14.479,6.001 s-10.486-2.007-14.479-6.001l-6.001-6.001v73.441c0,11.305-9.155,20.48-20.48,20.48s-20.48-9.175-20.48-20.48v-73.441 l-6.001,6.001c-3.994,3.994-9.236,6.001-14.479,6.001c-5.243,0-10.486-2.007-14.479-6.001c-8.008-8.008-8.008-20.951,0-28.959 l40.94-40.94c1.884-1.905,4.157-3.4,6.676-4.444c4.997-2.068,10.65-2.068,15.647,0c2.519,1.044,4.792,2.539,6.677,4.444 l40.94,40.94C227.287,300.728,227.287,313.672,219.279,321.679z M383.119,321.679c-3.994,3.994-9.236,6.001-14.479,6.001 c-5.243,0-10.486-2.007-14.479-6.001l-6.001-6.001v73.441c0,11.305-9.155,20.48-20.48,20.48s-20.48-9.175-20.48-20.48v-73.441 l-6.001,6.001c-3.994,3.994-9.237,6.001-14.479,6.001s-10.486-2.007-14.479-6.001c-8.008-8.008-8.008-20.951,0-28.959l40.94-40.94 c1.884-1.905,4.157-3.4,6.677-4.444c4.997-2.068,10.65-2.068,15.647,0c2.519,1.044,4.792,2.539,6.676,4.444l40.94,40.94 C391.127,300.728,391.127,313.672,383.119,321.679z M51.548,143.36l43.868-102.4h300.687l43.868,102.4H51.548z" />
                                </g>
                            </g>
                        </g>

                    </svg>
                </span>
                <span>Penitip Barang</span>
            </li>
            @can('melihat konsinyor')
                <li><a href="{{ route('konsinyors.index') }}" wire:navigate>Konsinyor</a></li>
            @endcan
            @can('melihat catatan penitipan')
                <li><a href="{{ route('consigments.index') }}" wire:navigate>Catatan Penitipan Barang</a></li>
            @endcan
        </ul>
    @endcan
    {{-- Produk --}}
    @canany(['melihat produk', 'melihat catatan pengeluaran'])
        <ul class="px-4 py-0 menu menu-sm lg:menu-md">
            <li></li>
            <li class="flex flex-row items-center gap-4 menu-title">
                <span class="text-base-content">
                    <svg width="24" height="24" viewBox="0 0 512 512" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">

                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                        <g id="SVGRepo_iconCarrier">
                            <title>product</title>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="icon" fill="#000000" transform="translate(64.000000, 34.346667)">
                                    <path
                                        d="M192,7.10542736e-15 L384,110.851252 L384,332.553755 L192,443.405007 L1.42108547e-14,332.553755 L1.42108547e-14,110.851252 L192,7.10542736e-15 Z M127.999,206.918 L128,357.189 L170.666667,381.824 L170.666667,231.552 L127.999,206.918 Z M42.6666667,157.653333 L42.6666667,307.920144 L85.333,332.555 L85.333,182.286 L42.6666667,157.653333 Z M275.991,97.759 L150.413,170.595 L192,194.605531 L317.866667,121.936377 L275.991,97.759 Z M192,49.267223 L66.1333333,121.936377 L107.795,145.989 L233.374,73.154 L192,49.267223 Z"
                                        id="Combined-Shape"> </path>
                                </g>
                            </g>
                        </g>

                    </svg>
                </span>
                <span>Data Produk</span>
            </li>
            @can('melihat produk')
                <li><a href="{{ route('products.index') }}" wire:navigate>Produk</a></li>
            @endcan
            @can('melihat catatan pengeluaran')
                <li><a href="{{ route('expenses.index') }}" wire:navigate>Catatan Stock Produk</a></li>
            @endcan
        </ul>
    @endcanany
    {{-- Penjualan --}}
    @can('melihat penjualan')
        <ul class="px-4 py-0 menu menu-sm lg:menu-md">
            <li></li>
            <li class="flex flex-row items-center gap-4 menu-title">
                <span class="text-base-content">
                    <svg width="24" height="24" viewBox="0 0 512 512" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">

                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                        <g id="SVGRepo_iconCarrier">
                            <title>product</title>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="icon" fill="#000000" transform="translate(64.000000, 34.346667)">
                                    <path
                                        d="M192,7.10542736e-15 L384,110.851252 L384,332.553755 L192,443.405007 L1.42108547e-14,332.553755 L1.42108547e-14,110.851252 L192,7.10542736e-15 Z M127.999,206.918 L128,357.189 L170.666667,381.824 L170.666667,231.552 L127.999,206.918 Z M42.6666667,157.653333 L42.6666667,307.920144 L85.333,332.555 L85.333,182.286 L42.6666667,157.653333 Z M275.991,97.759 L150.413,170.595 L192,194.605531 L317.866667,121.936377 L275.991,97.759 Z M192,49.267223 L66.1333333,121.936377 L107.795,145.989 L233.374,73.154 L192,49.267223 Z"
                                        id="Combined-Shape"> </path>
                                </g>
                            </g>
                        </g>

                    </svg>
                </span>
                <span>Data Penjualan</span>
            </li>
            {{-- @can('melihat catatan pengeluaran') --}}
            <li><a href="{{ route('sellings.index') }}" wire:navigate>Penjualan</a></li>
            {{-- @endcan --}}
        </ul>
    @endcan
    {{-- Transaksi --}}
    <ul class="px-4 py-0 menu menu-sm lg:menu-md">
        <li></li>
        <li class="flex flex-row items-center gap-4 menu-title">
            <span class="text-base-content">
                <svg width="19" height="19" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                    fill="#000000">

                    <g id="SVGRepo_bgCarrier" stroke-width="0" />

                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                    <g id="SVGRepo_iconCarrier">
                        <path fill="none" stroke="#000000" stroke-width="2"
                            d="M2,7 L20,7 M16,2 L21,7 L16,12 M22,17 L4,17 M8,12 L3,17 L8,22" />
                    </g>

                </svg>
            </span>
            <span>Transaksi</span>
        </li>
        @can('menambah bahan baku')
            <li><a href="{{ route('stocks.create') }}" wire:navigate>Pengadaan Bahan Baku</a></li>
        @endcan
        @can('menambah catatan pengeluaran')
            <li><a href="{{ route('expenses.create') }}" wire:navigate>Pengeluaran Bahan Baku</a></li>
        @endcan
        @can('menambah catatan penitipan')
            <li><a href="{{ route('consigments.create') }}" wire:navigate>Penitipan Produk</a></li>
        @endcan
        @can('menambah penjualan')
            <li><a href="{{ route('sellings.create') }}" wire:navigate>Penjualan Produk</a></li>
        @endcan
    </ul>
    {{-- Laporan --}}
    <ul class="px-4 py-0 menu menu-sm lg:menu-md">
        <li></li>
        <li class="flex flex-row items-center gap-4 menu-title">
            <span class="text-base-content">
                <svg fill="#000000" width="23" height="23" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">

                    <g id="SVGRepo_bgCarrier" stroke-width="0" />

                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                    <g id="SVGRepo_iconCarrier">

                        <path
                            d="m20 8-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z" />

                    </g>

                </svg>
            </span>
            <span>Laporan</span>
        </li>
        @can('cetak laporan penjualan')
            <li><a href="{{ route('reports.sellings.index') }}" wire:navigate>Penjualan </a></li>
        @endcan
        @can('cetak laporan bahan baku')
            <li><a href="{{ route('reports.stocks.index') }}" wire:navigate>Stok Bahan Baku</a></li>
        @endcan
        @can('cetak pelunasan produk')
            <li><a href="{{ route('reports.consigments.index') }}" wire:navigate>Cetakan Pelunasan Produk Titipan</a></li>
        @endcan
    </ul>
    {{-- Lainnya --}}
    @can('melihat unit')
        <ul class="px-4 py-0 menu menu-sm lg:menu-md">
            <li></li>
            <li class="flex flex-row items-center gap-4 menu-title">
                <span class="text-base-content">
                    <svg fill="#000000" width="23" height="23" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">

                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                        <g id="SVGRepo_iconCarrier">

                            <path
                                d="m20 8-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z" />

                        </g>

                    </svg>
                </span>
                <span>Lainnya</span>
            </li>
            <li><a href="{{ route('units.index') }}" wire:navigate>Satuan</a></li>
        </ul>
    @endcan
    <div class="sticky bottom-0 flex h-20 pointer-events-none from-base-200 bg-gradient-to-t to-transparent" />
</aside>
