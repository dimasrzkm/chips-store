<?php

namespace App\Livewire\Units;

use App\Livewire\Forms\UnitForm;
use App\Models\Unit;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditUnits extends Component
{
    public UnitForm $form;

    public function mount(Unit $unit)
    {
        $this->form->setPost($unit);
    }

    #[Title('Tambah satuan')]
    public function render()
    {
        return view('livewire.units.edit-units');
    }

    public function submit()
    {
        $this->validate();
        $this->form->update();

        return $this->redirectRoute('units.index', navigate: true);
    }

    protected $validationAttributes = [
        'form.name' => 'nama',
    ];
}
