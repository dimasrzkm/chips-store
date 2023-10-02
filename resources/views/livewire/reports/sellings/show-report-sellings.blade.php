<div>
    <x-alert />
    <x-breadcrumbs defaultSegment="Reports"/>
    <div class="grid grid-cols-1 ">
        <div
            class="relative p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            {{-- Header Table --}}
            <div class="flex flex-col w-full border-opacity-50">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanggal Awal</span>
                    </label>
                    {{-- <input type="date" value="2023-09-01" --}}
                    <input type="date" wire:model="tanggal_awal"
                        class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                    <label class="label">
                        @error('tanggal_awal')
                            <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="divider">Sampai</div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanggal Akhir</span>
                    </label>
                    {{-- <input type="date" value="2023-09-10" --}}
                    <input type="date" wire:model="tanggal_akhir"
                        class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                    <label class="label">
                        @error('tanggal_akhir')
                            <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                    {{-- menambah w-full untuk satu component agar fit dengan card --}}
                    <div class="w-full dropdown sm:dropdown-end">
                        <label tabindex="0"
                            class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 hover:cursor-pointer">
                            <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                            Export</label>
                        <ul tabindex="0"
                            class="w-full dropdown-content top-12 z-[1] menu p-2 shadow bg-base-100 rounded-box">
                            <li><a wire:click="exportAs('pdf')">Pdf</a></li>
                        </ul>
                    </div>
            </div>
            
        </div>
    </div>
</div>
