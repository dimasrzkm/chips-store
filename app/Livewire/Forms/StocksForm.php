<?php

namespace App\Livewire\Forms;

use App\Models\Stock;
use Livewire\Attributes\Url;
use Livewire\Form;

class StocksForm extends Form
{
    public ?Stock $stock;

    public $modeInput = 'tambah';

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $supplier_id;

    public $nama;

    public $tanggal_pengadaan;

    public $harga;

    public $jumlah;

    public function setPost(Stock $stock)
    {
        $this->stock = $stock;
        $this->supplier_id = $stock->supplier_id;
        $this->nama = $stock->nama;
        $this->tanggal_pengadaan = $stock->tanggal_pengadaan;
        $this->harga = $stock->harga;
        $this->jumlah = $stock->jumlah;
        $this->modeInput = 'ubah';
    }

    public function create()
    {
        try {
            Stock::create($this->only(['supplier_id', 'nama', 'tanggal_pengadaan', 'harga', 'jumlah']));
            session()->flash('status', 'Bahan baku berhasil di tambah');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->stock->update($this->only(['supplier_id', 'nama', 'tanggal_pengadaan', 'harga', 'jumlah']));
            $this->resetField();
            session()->flash('status', 'Bahan baku berhasil di ubah');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            $this->stock->delete();
            $this->resetField();
            session()->flash('status', 'Bahan baku berhasil di hapus');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function rules()
    {
        return [
            'supplier_id' => ['required'],
            'nama' => ['required'],
            'tanggal_pengadaan' => ['required', 'date'],
            'harga' => ['required', 'numeric'],
            'jumlah' => ['required', 'numeric'],
        ];
    }

    protected function resetField()
    {
        return $this->reset('supplier_id', 'nama', 'tanggal_pengadaan', 'harga', 'jumlah', 'stock', 'modeInput');
    }
}
