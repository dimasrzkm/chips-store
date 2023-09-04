<div>
    <x-alert />
    <x-breadcrumbs defaultSegment="Suppliers"/>
    <div class="grid grid-cols-1 overflow-hidden">
        <div
            class="relative overflow-hidden bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            {{-- Header Table --}}
            <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div
                                class="absolute inset-y-0 left-0 right-0 flex items-center justify-between pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                                <x-loading />
                            </div>
                            <input type="text" id="simple-search" wire:model.live.debounce.450ms="form.search"
                                class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search" required="">
                        </div>
                    </form>
                </div>
                <div
                    class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                    @can('menambah supplier')
                        <a type="button" href="{{ route('suppliers.create') }}" wire:navigate
                            class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Tambah Supplier
                        </a>
                    @endcan
                    <div class="flex items-stretch justify-end w-full space-x-3 md:w-auto">
                        {{-- menambah w-full untuk satu component agar fit dengan card --}}
                        <div class="w-full dropdown sm:dropdown-end">
                            <label tabindex="0"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 hover:cursor-pointer">
                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                                {{ $form->showPerPage }}</label>
                            <ul tabindex="0"
                                class="dropdown-content top-12 z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li><a wire:click="setHowMuchPageShow(10)">10</a></li>
                                <li><a wire:click="setHowMuchPageShow(25)">25</a></li>
                                <li><a wire:click="setHowMuchPageShow(50)">50</a></li>
                                <li><a wire:click="setHowMuchPageShow(100)">100</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Table --}}
            <div class="overflow-x-auto overflow-y-hidden">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">No</th>
                            <th scope="col" class="px-4 py-3">Nama</th>
                            <th scope="col" class="px-4 py-3">No Telpon</th>
                            <th scope="col" class="px-4 py-3">Alamat</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $index => $supplier)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">{{ $supplier->name }}</td>
                                <td class="px-4 py-3">{{ $supplier->telephone_number }}</td>
                                <td class="px-4 py-3">{{ $supplier->address }}</td>
                                <td class="flex items-center justify-end px-4 py-3">
                                    {{-- @can('menghapus supplier') --}}
                                        <div class="dropdown dropdown-left dropdown-end">
                                            <button tabindex="0"
                                                class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                                type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                            <ul tabindex="0"
                                                class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                @can('mengubah supplier')
                                                    <li>
                                                        <a href="{{ route('suppliers.edit', $supplier->name) }}" wire:navigate
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                    </li>
                                                @endcan
                                                @can('menghapus supplier')
                                                    <li>
                                                        <!-- Open the modal using ID.showModal() method -->
                                                        <a onclick="my_modal_1.showModal()"
                                                            wire:click="getDataForDelete({{ $supplier }})"
                                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Hapus
                                                        </a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    {{-- @endcan --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center">Tidak ada data di temukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Paginate --}}
            {{ $suppliers->links() }}
        </div>
    </div>

    @can('menghapus supplier')
        {{-- Modal Delete --}}
        <dialog wire:ignore.self id="my_modal_1" class="modal">
            <form method="dialog" class="modal-box">
                <h3 class="text-lg font-bold">Menghapus Data Supplier!</h3>
                <p class="py-4">Apakah anda yakin ingin menghapus data
                    <span class="font-medium text-red-600 text">{{ $form->name }}</span>?
                </p>
                <div class="modal-action">
                    <button class="btn btn-error" wire:click="deleteSupplier()">Hapus
                    </button>
                    <button class="btn btn-active">Tutup</button>
                </div>
            </form>
        </dialog>
    @endcan

</div>
