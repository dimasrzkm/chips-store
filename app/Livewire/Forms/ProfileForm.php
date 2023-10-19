<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Form;

class ProfileForm extends Form
{
    public ?User $user;

    public $name;

    public $email;

    public $username;

    public $address;

    public $telephone_number;

    public function setPost(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->address = $user->address;
        $this->telephone_number = $user->telephone_number;
    }

    public function storeProfile()
    {
        $this->user->update($this->only(['name', 'email', 'username', 'address', 'telephone_number']));
        session()->flash('status', 'Profile Berhasil di updated');
    }

    public function rules()
    {
        return [
            'name' => 'required|min:5',
            'email' => 'sometimes|email|unique:users,email,'.auth()->user()->id,
            'username' => 'required|min:5|unique:users,username,'.auth()->user()->id,
            'address' => 'required', 'regex:/^[.,a-zA-Z0-9\s]*$/',
            'telephone_number' => 'required', 'numeric', 'min_digits:12', 'max_digits:13',
        ];
    }
}
