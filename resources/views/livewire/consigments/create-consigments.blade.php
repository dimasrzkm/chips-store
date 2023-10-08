<div>
    <x-alert />
    <x-breadcrumbs />
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Penitipan Produk</h5>
        <form method="post" wire:submit="submit">
            @csrf
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nomor Transaksi</span>
                </label>
                <input type="text" wire:model="form.transaction_code" name="transaction_code"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none" disabled>
                @error('form.transaction_code')
                    <label class="label">
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    </label>
                @enderror
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Pengguna</span>
                </label>
                <input type="text" name="name" value="{{ auth()->user()->name }}"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none" disabled>
                @error('name')
                    <label class="label">
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    </label>
                @enderror
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Tanggal Penitipan</span>
                </label>
                <input type="date" wire:model="form.consigment_date" name="consigment_date"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                @error('form.consigment_date')
                    <label class="label">
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    </label>
                @enderror
            </div>
            <div class="w-full form-control">
                <label class="label">
                    <span class="label-text">Penitip Produk</span>
                </label>
                <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                    wire:model.live.debounce.500ms="form.konsinyor_id">
                    <option selected>Pilih Konsinyor</option>
                    @foreach ($form->allKonsinyors as $konsinyor)
                        <option value="{{ $konsinyor->id }}">{{ $konsinyor->name }}</option>
                    @endforeach
                </select>
                @error('form.konsinyor_id')
                    <label class="label">
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    </label>
                @enderror
            </div>
            <div class="w-full form-control">
                <label class="label">
                    <span class="label-text">Produk yang dititipkan</span>
                </label>
                <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                    @foreach ($form->selectedProducts as $index => $selectedProduct)
                        <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                            wire:model="form.selectedProducts.{{ $index }}.product_id" name="product_id">
                            <option selected>Pilih Produk</option>
                            @foreach ($form->allProducts as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" wire:model="form.selectedProducts.{{ $index }}.quantity"
                            class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                        <p wire:click="removeProduct({{ $index }})"
                            class="inline-flex items-center justify-center cursor-pointer text-rose-400 hover:text-red-500">
                            Hapus</p>
                    @endforeach
                </div>
            </div>
            @error('form.selectedProducts')
                <label class="label">
                    <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                </label>
            @enderror
            <p class="inline-block px-3 py-2 mt-3 text-sm font-medium text-center text-white rounded-lg cursor-pointer bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                wire:click="addProduct">Tambah Produk</p>
            <div class="flex items-center justify-end mt-3">
                <button type="submit"
                    class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tambah
                </button>
                <x-loading />
            </div>
        </form>
    </div>
</div>
