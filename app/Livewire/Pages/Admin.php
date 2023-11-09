<?php

namespace App\Livewire\Pages;

use App\Models\Product;
use App\Models\Selling;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Carbon;
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

    public $datesInWeeks = [];

    public $date_selling_start;

    public $date_selling_end;

    public $checkRenderDateForToday = 1;

    public function mount()
    {
        $this->date_selling_start = Carbon::now();

        $this->date_selling_end = $this->date_selling_start;

        $countHowManyWeeks = Carbon::now()->endOfMonth()->weekOfMonth;

        $start = Carbon::now()->startOfMonth();
        $countHowManyWeeks = ($countHowManyWeeks == 5) ? $countHowManyWeeks - 1 : $countHowManyWeeks;

        for ($i = 0; $i < $countHowManyWeeks; $i++) {
            if ($i == 3 && $countHowManyWeeks == $countHowManyWeeks) {
                $this->datesInWeeks[] = [
                    'start' => $start->format('Y-m-d'),
                    'end' => $start->endOfMonth()->format('Y-m-d'),
                ];
            } else {
                $this->datesInWeeks[] = [
                    'start' => $start->format('Y-m-d'),
                    'end' => $start->addDay(6)->format('Y-m-d'),
                ];
            }
            $start->addDay();
        }

        $this->nameOfProduct = Product::all()->pluck('name');
        $this->products = Product::with('sellings')->whereIn('name', $this->nameOfProduct)->get();
        $this->totalProducts = $this->nameOfProduct->count();
        $this->totalSellings = Selling::whereBetween('selling_date',
            [$this->date_selling_start->format('Y-m-d'), $this->date_selling_start->format('Y-m-d')]
        )->count();
        $colors = [
            '#f6ad55', '#fc8181', '#f97316', '#86efac', '#059669', '#5eead4', '#06b6d4', '#075985',
            '#ec4899', '#172554', '#15803d', '#94a3b8', '#16a34a', '#155e75', '#93c5fd', '#5b21b6',
            '#831843', '#34d399', '#a3e635', '#854d0e', '#fecaca', '#d9f99d', '#083344', '#1d4ed8'
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
                $name = $data->first()->name;
                // dd($name);

                if ($this->checkRenderDateForToday == 1) {
                    $value = $data->first()->sellings->where('selling_date', $this->date_selling_start->format('Y-m-d').' 00:00:00')->reduce(fn ($prev, $nex) => $prev += $nex->pivot->quantity);
                } else {
                    $value = $data->first()->sellings->whereBetween('selling_date', [$this->date_selling_start, $this->date_selling_end])->reduce(fn ($prev, $nex) => $prev += $nex->pivot->quantity);
                }

                // dd($value);
                // dd($this->colorsOfProduct);
                return $columnChartModel->addColumn($name, $value, $this->colorsOfProduct[$name]);
            }, (new ColumnChartModel())
                ->setTitle('Produk Terjual')
                ->setAnimated($this->firstRun)
                ->withOnColumnClickEventName('onColumnClick')
                ->withOnColumnClickEventName('onColumnClickYes')
            );

        return view('livewire.pages.admin', compact('columnChartModel'));
    }

    public function handleOnColumnClick($event)
    {
        $this->checkRenderDateForToday = 1;

        $this->date_selling_start = Carbon::now();
        $this->date_selling_end = $this->date_selling_start;

        $this->products = Product::with('sellings')->whereIn('name', $this->nameOfProduct)->get();
        $this->totalProducts = $this->products->count();
        $this->totalSellings = Selling::where('selling_date', $this->date_selling_start->format('Y-m-d').' 00:00:00')->count();
    }

    public function handleOnColumnClickYes($dateStart, $dateEnd)
    {
        $this->checkRenderDateForToday += 1;

        $this->date_selling_start = $dateStart;
        $this->date_selling_end = $dateEnd;

        $this->products = Product::with('sellings')->whereIn('name', $this->nameOfProduct)->get();
        $this->totalProducts = $this->products->count();
        $this->totalSellings = Selling::whereBetween('selling_date', [$this->date_selling_start, $this->date_selling_end])->count();
    }
}
