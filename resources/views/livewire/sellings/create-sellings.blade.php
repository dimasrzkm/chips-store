<div>
    <x-alert />
    <div class="grid grid-cols-1 overflow-hidden gap-y-6">
        <div
            class="relative overflow-hidden bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            {{-- Nomor, Kode, Tanggal --}}
            <div class="grid p-4 md:items-center md:justify-center gap-y-3 md:grid-cols-3">
                <label>Nomor Transaksi</label>
                <div class="w-full md:col-span-2">
                    <input type="text" wire:model="form.transaction_code"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="" disabled>
                </div>
                <label>Kasir</label>
                <div class="w-full md:col-span-2">
                    <input type="text" value="{{ auth()->user()->name }}"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="" disabled>
                </div>
                <label>Tanggal</label>
                <div class="w-full md:col-span-2">
                    <input type="date" wire:model="form.selling_date"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="" disabled>
                </div>
            </div>
            {{-- Cari Produk --}}
            <div
                class="relative p-4 m-4 overflow-hidden bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                <label class="inline-block mb-3">Produk</label>
                <div class="grid md:items-center md:justify-center md:gap-x-3 md:grid-cols-10 gap-y-3">
                    <div class="md:col-span-2">
                        <select wire:model.live.debounce.500ms="form.product_id"
                            class="w-full select border-2 border-[#272343] focus:outline-none border-opacity-80">
                            <option selected>Pilih Produk</option>
                            @foreach ($form->allProducts as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('form.product_id')
                            <label class="block label">
                                <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <input type="number" wire:model="form.sale_price"
                            class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none"
                            disabled>
                    </div>
                    <div>
                        <input type="number" wire:model="form.stock"
                            class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none"
                            disabled>
                    </div>
                    <div>
                        <input type="number" wire:model="form.quantity"
                            class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                        @error('form.quantity')
                            <label class="block label">
                                <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                    @if (!is_null($form->purchase_unit) && $form->purchase_unit == 'kg')
                        <select wire:model="form.selected_purchase_unit"
                            class="select border-2 border-[#272343] focus:outline-none border-opacity-80 md:col-span-2">
                            <option selected>Satuan Beli</option>
                            <option value="seperempat">1/4 kg</option>
                            <option value="setengah">1/2 kg</option>
                            <option value="sekilo">1 kg</option>
                        </select>
                    @endif
                    <button type="submit" wire:click="addPurchaseProduct"
                        class="p-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg md:py-3 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tambah
                    </button>
                    <x-loading />
                </div>
            </div>
            {{-- Produk Dibeli --}}
            <div
                class="relative p-4 m-4 overflow-hidden bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                <label class="inline-block mb-3">Produk Dibeli</label>
                <hr />
                <div class="overflow-x-auto overflow-y-hidden">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">No</th>
                                <th scope="col" class="px-4 py-3">Product</th>
                                <th scope="col" class="px-4 py-3">Quantity</th>
                                <th scope="col" class="px-4 py-3">Satuan</th>
                                <th scope="col" class="px-4 py-3">Harga</th>
                                <th scope="col" class="px-4 py-3">Sub-Total</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!is_null($form->selectedProducts))
                                @foreach ($form->selectedProducts as $index => $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">{{ $item['name'] }}</td>
                                        <td class="px-4 py-3">{{ $item['quantity'] }}</td>
                                        <td class="px-4 py-3">{{ $item['selected_purchase_unit'] }}</td>
                                        <td class="px-4 py-3">Rp. {{ number_format($item['sale_price'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3">Rp. {{ number_format($item['sub_total'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <p wire:click="removePurchaseProduct({{ $index }})"
                                                class="inline-flex items-center justify-center cursor-pointer text-rose-400 hover:text-red-500">
                                                Hapus</p>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="border-b dark:border-gray-700">
                                    <td colspan="7" class="px-4 py-3 text-center">Belum ada produk dibeli</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Pembayaran --}}
            <div
                class="relative p-4 m-4 overflow-hidden bg-white border border-gray-200 rounded-lg md:ml-auto md:max-w-md dark:bg-gray-800 dark:border-gray-700">
                <label class="inline-block mb-3">Proses Pembayaran</label>
                <form wire:submit="submit">
                    <div class="grid md:items-center md:justify-center gap-y-3 md:grid-cols-3">
                        <label for="">Total</label>
                        <div class="md:col-span-2">
                            <input type="number" wire:model="form.total"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                disabled>
                        </div>
                        <label for="">Bayar</label>
                        <div class="md:col-span-2">
                            <input type="number" wire:model.live.debounce.800ms="form.nominal_payment"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @error('form.nominal_payment')
                                <label class="block label">
                                    <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                        <label for="">Kembalian</label>
                        <div class="md:col-span-2">
                            <input type="number" wire:model="form.nominal_return"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                disabled>
                        </div>
                    </div>
                    <button type="submit"
                        class="flex px-3 py-2 mt-2 ml-auto text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
