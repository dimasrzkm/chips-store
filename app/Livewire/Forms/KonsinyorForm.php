<?php

namespace App\Livewire\Forms;

use App\Models\Konsinyor;
use Livewire\Attributes\Url;
use Livewire\Form;

class KonsinyorForm extends Form
{
    public ?Konsinyor $konsinyor;

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $modeInput = 'tambah';

    public $name;

    public $address;

    public $telephone_number;

    public function setPost(Konsinyor $konsinyor)
    {
        $this->konsinyor = $konsinyor;
        $this->name = $konsinyor->name;
        $this->address = $konsinyor->address;
        $this->telephone_number = $konsinyor->telephone_number;
        $this->modeInput = 'ubah';
    }

    public function store()
    {
        try {
            Konsinyor::create($this->only(['name', 'address', 'telephone_number']));
            session()->flash('status', 'berhasil menambah data konsinyor');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->konsinyor->update($this->only(['name', 'address', 'telephone_number']));
            $this->reset('konsinyor', 'name', 'address', 'telephone_number', 'modeInput');
            session()->flash('status', 'berhasil mengubah data konsinyor');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            $this->konsinyor->delete();
            $this->reset('konsinyor', 'name', 'address', 'telephone_number', 'modeInput');
            session()->flash('status', 'berhasil menghapus data konsinyor');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'regex:/^[a-zA-Z\s]*$/'],
            'address' => ['required', 'regex:/^[.,a-zA-Z0-9\s]*$/'],
            'telephone_number' => ['required', 'numeric', 'min_digits:12', 'max_digits:13'],
        ];
    }
}
