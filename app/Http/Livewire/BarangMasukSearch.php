<?php

namespace App\Http\Livewire;

use App\Models\ActivityLog;
use App\Models\DeviceCategory;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BarangMasukSearch extends Component
{
    use WithPagination;
    // Variable Filter
    public $showEntris = 10;
    public $search = '';
    public $bulan;
    public $tahun;
    public $tanggal;
    public $hidden = 1;
    public $statusBarang;
    public $jenisBarang;
    public $barangRusak;


    public $tanggalMasuk, $gambar, $keterangan, $unit;


    public $serialNumber;
    public $serialNumbers = [];
    public $selectedItem;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'refreshParent' => '$refresh'
    ];

 public function mount()
    {
        $id = Auth::user()->categories->pluck('id')[0];
        if ($id != 1) {
            $this->statusBarang = 1;
	    $this->jenisBarang = 1;
        }
    }

public function inputSN($itemId, $unit)
    {

        $this->emit('getModal', $itemId, $unit);
        $this->dispatchBrowserEvent('openmodaledit');
    }
//    public function keluar($itemId, $action = 'keluar')
//    {
//        $this->emit('getModal', $itemId, $action);
//        $this->dispatchBrowserEvent('openmodal');
//    }

//    public function getItems($itemId, $action = 'keluar-2')
//    {
//        $this->emit('getModal', $itemId, $action);
//        $this->dispatchBrowserEvent('openmodal');
//    }

//    public function selectItem($itemId, $serialNumber)

//    {
//        $this->emit('getModalId', $itemId, $serialNumber);
//        $this->dispatchBrowserEvent('openmodal');
//    }

    public function setStatus(){
	$this->statusBarang = $value;
    }

    public function removeItem($itemId, $serialNmber)
    {
        $barangMasuk = BarangMasuk::find($itemId);
        $serial = $barangMasuk->serialNumber;

        $remove = array_diff($serial, array($serialNmber));

        $valid = $barangMasuk->update([
            'unit' => count($remove),
            'serialNumber' => $remove
        ]);

        if ($valid) {
            ActivityLog::create([
                'category_id' => $barangMasuk->category_id,
                'keterangan' => "1 Barang di Hapus (SerialNumber:{$serialNmber}) dari Table Pemasukan Barang",
                'method' => "DESTROY",
            ]);
        }
    }



    public function clear()
    {
        $this->tahun = null;
        $this->tanggal = null;
        $this->bulan = null;
    }

    public function render()
    {

        $categori_id = Auth::user()->categories()->pluck('id');
	
	$filterBarang = BarangMasuk::whereIn('category_id', $categori_id)->with(['device_categories', 'penanggung_jawabs']);

        $datas = $filterBarang->filter(['bulan' => $this->bulan, 'tahun' => $this->tahun, 'tanggal' => $this->tanggal, 'search' => $this->search, 'hidden'=>$this->hidden, 'status' => $this->statusBarang, 'jenis' => $this->jenisBarang])
            ->latest('tanggalMasuk');
        return view('livewire.barang-masuk-search', [
            'datas' => $datas->paginate($this->showEntris),
	    'barangCategories' => DeviceCategory::all(),
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
