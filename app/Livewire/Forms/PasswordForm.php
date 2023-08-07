<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Form;

class PasswordForm extends Form
{
    public ?User $user;

    public $oldPassword = null;

    public $newPassword = null;

    public $newConfirmPassword = null;

    public function storePassword()
    {
        // Memvalidasi bahwa kata sandi baru sesuai dengan kata sandi terkini
        if (! (Hash::check($this->oldPassword, auth()->user()->password))) {
            return session()->flash('status', 'Kata sandi saat ini tidak sesuai dengan kata sandi baru yang anda berikan.');
        }

        // Memvalidasi kata sandi terkini dan kata sandi baru sama
        if (strcmp($this->oldPassword, $this->newPassword) == 0) {
            return session()->flash('status', 'Kata sandi baru tidak boleh sama dengan kata sandi saat ini.');
        }

        // Memvalidasi kata sandi baru dan kata sandi konfirmasi tidak sama
        if (strcmp($this->newPassword, $this->newConfirmPassword) != 0) {
            return session()->flash('status', 'Kata sandi konfirmasi tidak sama dengan kata sandi baru anda.');
        }

        $this->user->update([
            'password' => Hash::make($this->newPassword),
        ]);

        return session()->flash('status', 'Berhasil mengupdate password');
    }

    public function rules()
    {
        return [
            'oldPassword' => 'required|min:8|max:25',
            'newPassword' => 'required|min:8|max:25',
            'newConfirmPassword' => 'required|min:8|max:25',
        ];
    }
}
