<div>
    <x-alert />
    <x-breadcrumbs defaultSegment="Reports" />
    <div class="grid grid-cols-1 ">
        <div
            class="relative p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            {{-- Header Table --}}
            <div class="flex flex-col w-full border-opacity-50">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">No Transaksi Penitipan</span>
                    </label>
                    <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                        wire:model.live.debounce.450ms="consigmentId" name="consigmentId">
                        <option selected>Pilih Transaksi</option>
                        @foreach ($consigments as $consigment)
                            <option value="{{ $consigment->id }}">{{ $consigment->transaction_code }}</option>
                        @endforeach
                    </select>
                    @error('consigmentId')
                        <label class="label">
                            <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div
                    class="relative p-4 mt-4 overflow-hidden bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                    <label class="inline-block mb-3">Produk</label>
                    <hr />
                    <div class="overflow-x-auto overflow-y-hidden">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">No</th>
                                    <th scope="col" class="px-4 py-3">Produk</th>
                                    <th scope="col" class="px-4 py-3">Total</th>
                                    <th scope="col" class="px-4 py-3">Penitip</th>
                                    <th scope="col" class="px-4 py-3">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($selectedConsigment)
                                    @foreach ($selectedConsigment->products as $index => $data)
                                        <tr>
                                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3">{{ $data->name }}</td>
                                            <td class="px-4 py-3">{{ $data->pivot->total_consigment }}</td>
                                            <td class="px-4 py-3">{{ $data->pivot->konsinyor_name }}</td>
                                            <td class="px-4 py-3">
                                                {{ $selectedConsigment->consigment_date->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-center">Tidak ada Transaksi</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- menambah w-full untuk satu component agar fit dengan card --}}
                <div class="flex items-center justify-end mt-3">
                    <button type="button" wire:click="printPayment()"
                        class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cetak
                        Pelunasan
                    </button>
                    <x-loading />
                </div>
            </div>

        </div>
    </div>
</div>
