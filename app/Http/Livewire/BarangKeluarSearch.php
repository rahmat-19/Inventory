<?php

namespace App\Http\Livewire;

use App\Models\ActivityLog;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Livewire\Component;
use App\Models\DeviceCategory;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class BarangKeluarSearch extends Component
{
    use WithPagination;

    public $showEntris = 10;
    public $search = '';
    public $bulan = '';
    public $tanggal = '';
    public $statusBarang;

    public $tahun = '';
    public $jenisBarang;
    public $exportDatas;
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
        $this->dispatchBrowserEvent('openmodal');
    }

    public function removeItem($itemId, $id_masuk, $serialNumber)
    {
        $barangMasuk = BarangMasuk::find($id_masuk);
        $barangkeluar = BarangKeluar::find($itemId);

        $serial = $barangkeluar->serialNumber;
        $remove = array_diff($serial, array($serialNumber));

        $valid = $barangkeluar->update([
            'serialNumber' => $remove,
            'unitKeluar' => count($remove),
        ]);

        if ($valid) {
            ActivityLog::create([
                'category_id' => $barangkeluar->category_id,
                'keterangan' => "1 Barang di Hapus (SerialNumber:{$serialNumber}) dari Table Pengeluaran Barang",
                'method' => "DESTROY",
            ]);
            Alert::success('Success', 'Data Has Been Added Successfully');
            if (empty($barangkeluar->serialNumber)) {
                $barangkeluar->delete();
            }

            $sn = $barangMasuk->serialNumber;
            array_push($sn, $serialNumber);
            $valid = $barangMasuk->update([
                'serialNumber' => $sn,
                'unit' => count($sn)
            ]);
        }
    }
    public function clear()
    {
        $this->tahun = '';
        $this->tanggal = '';
        $this->bulan = '';
    }



    public function render()
    {
        $categori_id = Auth::user()->categories()->pluck('id');
        $filterBarang = BarangKeluar::whereIn('category_id', $categori_id)->with(['device_categories', 'penanggung_jawabs']);
        
	$datas = $filterBarang->filter(['bulan' => $this->bulan, 'tahun' => $this->tahun, 'tanggal' => $this->tanggal, 'search' => $this->search, 'status' => $this->statusBarang, 'jenis'=>$this->jenisBarang])
            ->latest('tanggalKeluar');


        return view('livewire.barang-keluar-search', [
            'datas' => $datas->paginate($this->showEntris),
	    'barangCategories' => DeviceCategory::all(),
'jumlahBarang' => $datas->sum('unitKeluar'),
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
