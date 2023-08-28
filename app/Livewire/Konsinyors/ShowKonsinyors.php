<?php

namespace App\Livewire\Konsinyors;

use App\Livewire\Forms\KonsinyorForm;
use App\Models\Konsinyor;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ShowKonsinyors extends Component
{
    use WithPagination;

    public KonsinyorForm $form;

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    public function getDataForDelete($data)
    {
        $this->form->setPost(Konsinyor::find($data['id']));
    }

    public function deleteKonsinyor()
    {
        $this->form->destroy();

        return $this->redirectRoute('konsinyors.index', navigate: true);
    }

    #[Title('Data Konsinyors')]
    public function render()
    {
        $konsinyors = Konsinyor::orderBy('name', 'asc')->paginate($this->form->showPerPage, pageName: 'konsinyor-page');
        if ($this->form->search !== '') {
            $konsinyors = Konsinyor::where('name', 'like', '%'.$this->form->search.'%')
                ->paginate($this->form->showPerPage, pageName: 'konsinyor-page');
        }

        return view('livewire.konsinyors.show-konsinyors', [
            'konsinyors' => $konsinyors,
        ]);
    }
}
