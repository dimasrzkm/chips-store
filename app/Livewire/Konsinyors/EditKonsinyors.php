<?php

namespace App\Livewire\Konsinyors;

use App\Livewire\Forms\KonsinyorForm;
use App\Models\Konsinyor;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditKonsinyors extends Component
{
    public KonsinyorForm $form;

    public function mount(Konsinyor $konsinyor)
    {
        $this->form->setPost($konsinyor);
    }

    public function submit()
    {
        $this->validate();
        $this->form->update();

        return $this->redirectRoute('konsinyors.index', navigate: true);
    }

    #[Title('Ubah data konsinyor')]
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
