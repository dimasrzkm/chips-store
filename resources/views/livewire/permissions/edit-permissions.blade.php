<div>
    <x-breadcrumbs />
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
            @if ($form->modeInput != 'ubah')
                Tambah Izin
            @else
                Ubah Izin
            @endif
        </h5>
        <form method="post" wire:submit="submit">
            @csrf
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Izin</span>
                </label>
                <input type="text" wire:model="form.name" name="name"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                <label class="label">
                    @error('form.name')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="flex items-center justify-end mt-3">
                <button type="submit"
                    class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    @if ($form->modeInput != 'ubah')
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
