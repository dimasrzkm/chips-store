<div>
    <x-alert />
    <x-breadcrumbs />
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
            @if ($form->modeInput !== 'ubah')
                Pengadaan Bahan Baku
            @else
                Ubah Pengadaan Bahan Baku
            @endif
        </h5>
        <form method="post" wire:submit="submit">
            @csrf
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Tanggal Pengadaan</span>
                </label>
                <input type="date" wire:model="form.purchase_date" name="purchase_date"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                <label class="label">
                    @error('form.purchase_date')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="w-full form-control">
                <label class="label">
                    <span class="label-text">Supplier</span>
                </label>
                <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                    wire:model="form.supplier_id" name="supplier">
                    <option selected>Pilih Supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
                @error('form.supplier_id')
                    <label class="label">
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    </label>
                @enderror
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Bahan Baku</span>
                </label>
                <input type="text" wire:model="form.name" name="nama_bahan"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                <label class="label">
                    @error('form.name')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Harga</span>
                </label>
                <input type="number" wire:model="form.price" name="price"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                <label class="label">
                    @error('form.price')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Jumlah Beli</span>
                </label>
                <input type="number" wire:model="form.initial_stock" name="initial_stock"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                <label class="label">
                    @error('form.initial_stock')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="w-full form-control">
                <label class="label">
                    <span class="label-text">Satuan</span>
                </label>
                <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                    wire:model="form.unit_id">
                    <option selected>Pilih Satuan</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                    @endforeach
                </select>
                @error('form.unit_id')
                    <label class="label">
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    </label>
                @enderror
            </div>
            <div class="flex items-center justify-end mt-3">
                <button type="submit"
                    class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    @if ($form->modeInput !== 'ubah')
                        Tambah
                    @else
                        Ubah
                    @endif
                </button>
                <x-loading />
            </div>
        </form>
    </div>
</div>