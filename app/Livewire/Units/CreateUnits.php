<?php

namespace App\Livewire\Units;

use App\Livewire\Forms\UnitForm;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateUnits extends Component
{
    public UnitForm $form;

    #[Title('Tambah satuan')]
    public function render()
    {
        return view('livewire.units.edit-units');
    }

    public function submit()
    {
        $this->validate();
        $this->form->create();

        return $this->redirectRoute('units.index', navigate: true);
    }

    protected $validationAttributes = [
        'form.name' => 'nama',
    ];
}
