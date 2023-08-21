<div>
    <x-alert />

    <div class="grid grid-cols-1 mb-5 overflow-hidden">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                Perizinan peran memiliki izin @if ($form->modeInput == 'ubah') (Ubah) @endif
            </h5>
            <form method="post" wire:submit="submit">
                <div class="w-full form-control">
                    <label class="label">
                        <span class="label-text">Peran</span>
                    </label>
                    <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                        wire:model="form.role_id" name="role_id">
                        <option selected>Pilih Peran</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('form.role_id')
                        <label class="label">
                            <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full form-control">
                    <label class="label">
                        <span class="label-text">Izin</span>
                    </label>
                    <select class="select border-2 border-[#272343] focus:outline-none border-opacity-80"
                        wire:model="form.permissions" id="permissions" multiple>
                        <option disabled selected>Pilih Izin</option>
                        @foreach ($permissions as $permission)
                            @if ($form->modeInput == 'tambah')
                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                            @else
                                <option {{ $form->role->permissions->find($permission->id) ? 'selected' : '' }}
                                    value="{{ $permission->name }}">{{ $permission->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('form.permissions')
                        <label class="label">
                            <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="flex items-center justify-end mt-3">
                    <button type="submit"
                        class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        @if ($form->modeInput == 'tambah')
                            Izinkan
                        @else
                            Sync
                        @endif
                    </button>
                    <x-loading />
                </div>
            </form>
        </div>
    </div>
</div>
