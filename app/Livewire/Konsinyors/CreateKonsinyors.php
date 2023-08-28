<?php

namespace App\Livewire\Konsinyors;

use App\Livewire\Forms\KonsinyorForm;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateKonsinyors extends Component
{
    public KonsinyorForm $form;

    public function submit()
    {
        $this->validate();
        $this->form->store();

        return $this->redirectRoute('konsinyors.index', navigate: true);
    }

    #[Title('Tambah data konsinyor')]
    public function render()
    {
        return view('livewire.konsinyors.edit-konsinyors');
    }

    protected $validationAttributes = [
        'form.name' => 'nama',
        'form.address' => 'alamat',
        'form.telephone_number' => 'no telpon',
    ];
}
