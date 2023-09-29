<?php

namespace App\Livewire\Units;

use App\Livewire\Forms\UnitForm;
use App\Models\Unit;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUnits extends Component
{
    use WithPagination;

    public UnitForm $form;

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    public function getDataForDelete(Unit $unit)
    {
        $this->form->setPost($unit);
    }

    public function deleteUnit()
    {
        $this->form->destroy();

        return $this->redirectRoute('units.index', navigate: true);
    }

    #[Title('Data Satuan')]
    public function render()
    {
        $units = Unit::orderBy('name', 'asc')->paginate($this->form->showPerPage, pageName: 'units-page');
        if ($this->form->search) {
            $units = Unit::where('name', 'like', '%'.$this->form->search.'%')
                ->orderBy('name', 'asc')
                ->paginate($this->form->showPerPage, pageName: 'units-page');
        }

        return view('livewire.units.show-units', ['units' => $units]);
    }
}
