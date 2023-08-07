<div>
    <x-alert />
    {{-- Change Profile Information --}}
    <livewire:profile.update-profile :user="auth()->user()" />
    {{-- Change Password --}}
    <livewire:profile.update-password />
</div>
