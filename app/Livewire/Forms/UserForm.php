<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user;

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $modeInput = 'tambah';

    public $name;

    public $email = 'dummy@gmail.com';

    public $username;

    public $password;

    public $address;

    public $telephone_number;

    public function setPost(User $data)
    {
        $this->user = $data;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->username = $data->username;
        $this->password = null;
        $this->address = $data->address;
        $this->telephone_number = $data->telephone_number;
        $this->modeInput = 'ubah';
    }

    public function store()
    {
        try {
            User::create($this->only($this->attributes()));
            session()->flash('status', 'Pengguna baru telah di tambahkan');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->user->update($this->only($this->attributes()));
            $this->resetField();
            session()->flash('status', 'Data pengguna telah di ubah');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            $this->user->delete();
            $this->resetField();
            session()->flash('status', 'Data pengguna telah di hapus');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    protected function attributes()
    {
        $attributes = ['name', 'email', 'username', 'address', 'telephone_number'];
        if ($this->password !== null) {
            array_push($attributes, 'password');
        }

        return $attributes;
    }

    protected function resetField()
    {
        return $this->reset('user', 'name', 'email', 'username', 'password', 'address', 'telephone_number', 'modeInput');
    }

    public function rules()
    {
        return [
            'name' => ['required', 'regex:/^[a-zA-Z\s]*$/'],
            'email' => ['required', 'email'],
            'username' => ['sometimes'],
            'password' => ['sometimes', 'regex:/^[a-zA-Z0-9\s]*$/'],
            'address' => ['required', 'regex:/^[.,a-zA-Z0-9\s]*$/'],
            'telephone_number' => ['required', 'numeric', 'min_digits:12', 'max_digits:13'],
        ];
    }
}
