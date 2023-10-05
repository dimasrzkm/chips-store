<?php

namespace App\Livewire\Pages;

use App\Models\Product;
use App\Models\Selling;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Attributes\Title;
use Livewire\Component;

class Admin extends Component
{
    public $products;

    public $nameOfProduct;

    public $colorsOfProduct;

    public $firstRun = true;

    public $totalProducts;

    public $totalSellings;

    public function mount()
    {
        $this->nameOfProduct = Product::all()->pluck('name');
        $this->products = Product::with('sellings')->whereIn('name', $this->nameOfProduct)->get();
        $this->totalProducts = $this->nameOfProduct->count();
        $this->totalSellings = Selling::count();
        $colors = [
            '#f6ad55', '#fc8181', '#f97316', '#86efac', '#059669', '#5eead4', '#06b6d4', '#075985',
            '#ec4899', '#172554', '#15803d', '#94a3b8',
        ];
        foreach ($this->nameOfProduct as $index => $product) {
            $this->colorsOfProduct[$product] = $colors[$index];
        }
    }

    #[Title('Dashboard')]
    public function render()
    {
        $columnChartModel = $this->products->groupBy('name')
            ->reduce(function (ColumnChartModel $columnChartModel, $data) {
                // dd($data->first()->sellings->reduce(fn ($prev, $nex) => $prev += $nex->pivot->quantity));
                $name = $data->first()->name;
                // dd($name);
                $value = $data->first()->sellings->reduce(fn ($prev, $nex) => $prev += $nex->pivot->quantity);

                // dd($value);
                // dd($this->colorsOfProduct);
                return $columnChartModel->addColumn($name, $value, $this->colorsOfProduct[$name]);
            }, (new ColumnChartModel())
                ->setTitle('Produk Terjual')
                ->setAnimated($this->firstRun)
                ->withOnColumnClickEventName('onColumnClick')
            );

        return view('livewire.pages.admin', compact('columnChartModel'));
    }

    public function handleOnColumnClick($event)
    {
        $this->products = Product::with('sellings')->whereIn('name', $this->nameOfProduct)->get();
        $this->totalProducts = $this->products->count();
        $this->totalSellings = Selling::count();
    }
}
