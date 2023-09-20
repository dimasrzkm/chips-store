<div>
    <x-alert />
    <x-breadcrumbs />
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Pengeluaran Bahan Baku</h5>
        <form method="post" wire:submit="submit">
            @csrf
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nomor Transaksi</span>
                </label>
                <input type="text" wire:model="form.transaction_code" name="transaction_code"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none" disabled>
                <label class="label">
                    @error('form.transaction_code')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Pengguna</span>
                </label>
                <input type="text" name="name" value="{{ auth()->user()->name }}"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none" disabled>
                <label class="label">
                    @error('name')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Tanggal Pengeluaran</span>
                </label>
                <input type="date" wire:model="form.expense_date" name="expense_date"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                <label class="label">
                    @error('form.expense_date')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Produk</span>
                </label>
                <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                    wire:model="form.product_id" name="product_id">
                    <option selected>Pilih Produk</option>
                    @foreach ($form->allProducts as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <label class="label">
                    @error('form.product_id')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="w-full form-control">
                <label class="label">
                    <span class="label-text">Bahan Baku</span>
                </label>
                <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                    @foreach ($form->selectedStocks as $index => $selectedStock)
                        <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                            wire:model="form.selectedStocks.{{ $index }}.stock_id" name="product_id">
                            <option selected>Pilih Bahan</option>
                            @foreach ($form->allStocks as $stock)
                                <option value="{{ $stock->id }}">
                                    {{ "$stock->name - ($stock->total kg / $stock->purchase_date)" }}
                                </option>
                            @endforeach
                        </select>
                        @error('form.supplier_id')
                            <label class="label">
                                <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                            </label>
                        @enderror
                        <input type="number" wire:model="form.selectedStocks.{{ $index }}.quantity"
                            class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                        <p wire:click="removeStock({{ $index }})"
                            class="inline-flex items-center justify-center cursor-pointer text-rose-400 hover:text-red-500">
                            Delete</p>
                    @endforeach
                </div>
            </div>
            <p class="inline-block px-3 py-2 mt-3 text-sm font-medium text-center text-white rounded-lg cursor-pointer bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                wire:click="addStock">Tambah Bahan</p>
            <div class="flex items-center justify-end mt-3">
                <button type="submit"
                    class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tambah
                </button>
                <x-loading />
            </div>
        </form>
    </div>
</div>
