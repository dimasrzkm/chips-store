<div>
    <x-alert />
    <x-breadcrumbs />
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
            @if ($form->modeInput !== 'ubah')
                Tambah Produk
            @else
                Ubah Data Produk
            @endif
        </h5>
        <form method="post" wire:submit="submit">
            @csrf
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input type="text" wire:model="form.name" name="name"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                <label class="label">
                    @error('form.name')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Harga Dasar Produk</span>
                </label>
                <input type="text" wire:model.blur="form.initial_price" name="initial_price"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                <label class="label">
                    @error('form.initial_price')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Persentase Keuntungan</span>
                </label>
                <input type="number" wire:model.live.blur="form.percentage_profit" name="percentage_profit"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                <label class="label">
                    @error('form.percentage_profit')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Harga Jual</span>
                </label>
                <input type="text" wire:model="form.sale_price" name="sale_price"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none" disabled>
                <label class="label">
                    @error('form.sale_price')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <p wire:dirty wire:target="form.initial_price" class="text-xs">Menghitung...</p>
            <p wire:dirty wire:target="form.percentage_profit" class="text-xs">Menghitung...</p>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Satuan Produk</span>
                </label>
                <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                    wire:model="form.unit_id">
                    <option selected>Pilih Satuan</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                    @endforeach
                </select>
                <label class="label">
                    @error('form.unit_id')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="w-full form-control">
                <label class="label">
                    <span class="label-text">Kategori Produk</span>
                </label>
                <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                    wire:model.live.debounce.500ms="form.categoryProduct">
                    <option selected>Pilih Kategori</option>
                    <option value="0">Milik sendiri</option>
                    <option value="1">Titipan</option>
                </select>
                @error('form.categoryProduct')
                    <label class="label">
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    </label>
                @enderror
            </div>
            @if ($form->categoryProduct)
                <div class="w-full form-control">
                    <label class="label">
                        <span class="label-text">Penitip Produk</span>
                    </label>
                    <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                    wire:model="form.konsinyor_id">
                        <option selected>Pilih Konsinyor</option>
                        @foreach ($form->allKonsinyors as $konsinyor)
                            <option value="{{ $konsinyor->id }}">{{ $konsinyor->name }}</option>
                        @endforeach
                    </select>
                    @error('form.categoryProduct')
                        <label class="label">
                            <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
            @endif
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
