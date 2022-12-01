<?php

namespace App\Http\Livewire;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use Livewire\Component;

class InputSN extends Component
{
    public $modalId;
    public $unitParams;
    public $serialNumber = [];
    public $inputs = [0];
    public $i = 1;
    public $keterangan = "";
    public $jenisBarang;

    protected $listeners = [
        'getModal'
    ];


    public function getModal($modald, $unit)
    {
        $this->modalId = $modald;
        $this->unitParams = $unit;
        $datas = BarangKeluar::find($modald);
        $this->serialNumber = $datas->serialNumber;
	if(!empty($datas->serialNumber)){
		$this->inputs = $datas->serialNumber;
	};
$this->jenisBarang = $datas->device_categories->jenis_id;
$this->keterangan = $datas->keterangan;
    }
    public function plus($i)
    {
       // if (empty($this->serialNumber)) {
       //     $this->inputs = $this->serialNumber;
       //}
        $i = $i + 1;
        $this->i = $i;
        if (count($this->inputs) != $this->unitParams) {
            array_push($this->inputs, $i);
        }
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        unset($this->serialNumber[$i]);
    }

    public function save()
    {
        // dd($this->serialNumber);
	$datas = [
            "keterangan" => $this->keterangan
        ];

	if($this->jenisBarang == 1) {
		$datas['serialNumber'] = $this->serialNumber;
	}

        $barangKeluar = BarangKeluar::find($this->modalId);
	$snLama = $barangKeluar->serialNumber;
        $valid = $barangKeluar->update($datas);

        if ($valid) {
	    $dataLogs = [
		'category_id' => $barangKeluar->category_id,
		'keterangan' =>  "User " . Auth::user()->username . " Merubah SerialNumber Pada Table Pengeluaran Barang",
		'method' => "POST/PUT",
		'id_masuk' => $barangKeluar->masuk_id,
		'id_keluar' => $barangKeluar->id,
		'dataLama' => $snLama,
		'dataBaru' => $barangKeluar->serialNumber,
	    ];
	    ActivityLog::create($dataLogs);
            $this->emit('refreshParent');
            $this->dispatchBrowserEvent('closemodal');
            $this->cleanVars();
        }
    }
    private function cleanVars()
    {
        $this->serialNumber = null;
    }







    public function render()
    {
        return view('livewire.input-s-n');
    }
}
