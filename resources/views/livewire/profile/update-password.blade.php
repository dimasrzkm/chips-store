<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Change Password</h5>
    <form method="post" wire:submit="updatePassword">
        @csrf
        <div class="form-control">
            <label class="label">
                <span class="label-text">Kata sandi sebelumnya</span>
            </label>
            <input type="password" wire:model="form.oldPassword" name="oldPassword"
                class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
            <label class="label">
                @error('form.oldPassword')
                    <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                @enderror
            </label>
        </div>

        <div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Kata sandi saat ini</span>
                </label>
                <input type="password" wire:model="form.newPassword" name="newPassword"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                <label class="label">
                    @error('form.newPassword')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Konfirmasi kata sandi baru</span>
                </label>
                <input type="password" wire:model="form.newConfirmPassword" name="password_confirmation"
                    class="input w-full border-opacity-80 border-2 border-[#272343] focus:outline-none">
                <label class="label">
                    @error('form.newConfirmPassword')
                        <span class="text-sm label-text-alt text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
        </div>

        <button type="submit"
            class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
    </form>
</div>