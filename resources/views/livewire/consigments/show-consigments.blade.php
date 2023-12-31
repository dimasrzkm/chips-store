<div>
    <x-alert />
    <x-breadcrumbs defaultSegment="Consigments" />
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
                            <th scope="col" class="px-4 py-3">Pengguna</th>
                            <th scope="col" class="px-4 py-3">Tanggal Transaksi</th>
                            <th scope="col" class="px-4 py-3">Nomor Transaksi</th>
                            <th scope="col" class="px-4 py-3">Nama Produk</th>
                            <th scope="col" class="px-4 py-3">Nama Penitip</th>
                            <th scope="col" class="px-4 py-3">Total Penitipan</th>
                            <th scope="col" class="px-4 py-3">Tanggal Pelunasan</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3">Struk Penitipan</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($consigments as $index => $consigment)
                            @foreach ($consigment->products as $i => $item)
                                <tr class="border-b dark:border-gray-700">
                                    @if ($i < 1)
                                        <td rowspan="{{ $consigment->products->count() }}" class="px-4 py-3">
                                            {{ $index + 1 }}</td>
                                        <td rowspan="{{ $consigment->products->count() }}" class="px-4 py-3">
                                            {{ $consigment->user->name }}</td>
                                        <td rowspan="{{ $consigment->products->count() }}" class="px-4 py-3">
                                            {{ $consigment->consigment_date->format('d/m/Y') }}</td>
                                        <td rowspan="{{ $consigment->products->count() }}" class="px-4 py-3">
                                            {{ $consigment->transaction_code }}</td>
                                    @endif
                                    <td class="px-4 py-3">
                                        {{ $item->pivot->product_name }}</td>
                                    <td class="px-4 py-3">{{ $item->pivot->konsinyor_name }}</td>
                                    <td class="px-4 py-3">{{ $item->pivot->total_consigment }}</td>
                                    @if ($i < 1)
                                        <td rowspan="{{ $consigment->products->count() }}" class="px-4 py-3">
                                            {{ $consigment->paid_off_date ? $consigment->paid_off_date->format('d/m/Y') : '-' }}
                                        </td>
                                        <td rowspan="{{ $consigment->products->count() }}" class="px-4 py-3">
                                            {{ $consigment->is_paid_off ? 'Lunas' : 'Belum Lunas' }}</td>
                                    @endif
                                    @if (!$consigment->is_paid_off)
                                        @if ($i < 1)
                                            <td rowspan="{{ $consigment->products->count() }}" class="px-4 py-3 ">
                                                <a type="button" target="_blink"
                                                    href="{{ route('laporan.penitipan', ['consigment' => Crypt::encryptString($consigment)]) }}"
                                                    class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                                    </svg>
                                                </a>
                                            </td>
                                            <td rowspan="{{ $consigment->products->count() }}" class="px-4 py-3 ">
                                                @can('menghapus catatan penitipan')
                                                    @if (!$consigment->is_paid_off)
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
                                                                <li>
                                                                    <!-- Open the modal using ID.showModal() method -->
                                                                    <a onclick="my_modal_1.showModal()"
                                                                        wire:click="getDataForDelete({{ $consigment }})"
                                                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Hapus
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                @endcan
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="11" class="px-4 py-3 text-center">Tidak ada data di temukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Paginate --}}
            {{ $consigments->links() }}
        </div>
    </div>

    {{-- @can('menghapus catatan penitipan') --}}
    {{-- Modal Delete --}}
    <dialog wire:ignore.self id="my_modal_1" class="modal">
        <form method="dialog" class="modal-box">
            <h3 class="text-lg font-bold">Menghapus Data Penitipan Barang!</h3>
            <p class="py-4">Apakah anda yakin ingin menghapus data
                <span class="font-medium text-red-600 text">{{ $form->transaction_code }}</span>?
            </p>
            <div class="modal-action">
                <button class="btn btn-error" wire:click="deleteConsigment()">Hapus
                </button>
                <button class="btn btn-active">Tutup</button>
            </div>
        </form>
    </dialog>
    {{-- @endcan --}}

</div>
