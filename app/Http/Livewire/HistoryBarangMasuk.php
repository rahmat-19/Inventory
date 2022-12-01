<?php

namespace App\Http\Livewire;

// use Livewire\WithPagination;

use App\Models\BarangKeluar;
use Livewire\WithPagination;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\HistoryBarangMasuk as ModelsHistoryBarangMasuk;
class HistoryBarangMasuk extends Component
{

    use WithPagination;

    public $showEntris = 5;
    public $search = '';
    public $bulan;
    public $tahun;
    public $tanggal;

    protected $paginationTheme = 'bootstrap';


    public function render()
    {
 $categori_id = Auth::user()->categories()->pluck('id');
        $filterBarang = ModelsHistoryBarangMasuk::whereIn('category_id', $categori_id)->with(['device_categories', 'penanggung_jawabs'])
            ->filter(['bulan' => $this->bulan, 'tahun' => $this->tahun, 'tanggal' => $this->tanggal, 'search' => $this->search])
            ->latest('tanggalMasuk');

        return view('livewire.history-barang-masuk', [
		'datas' => $filterBarang->paginate($this->showEntris)
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingShowEntris()
    {
        $this->resetPage();
    }
    public function updatingBulan()
    {
        $this->resetPage();
    }
}
