<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class EditSn extends Component
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
        $datas = BarangMasuk::find($modald);
        $this->serialNumber = $datas->serialNumber;
 	if (!empty($this->serialNumber)) {
	           $this->inputs = $this->serialNumber;
        }
	$this->jenisBarang = $datas->device_categories->jenis_id;
	$this->keterangan = $datas->keterangan;

    }
    public function plus($i)
    {
//        if (!empty($this->serialNumber)) {
//            $this->inputs = $this->serialNumber;
//        }
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
        $barangMasuk = BarangMasuk::find($this->modalId);
	$snLama = $barangMasuk->serialNumber;
	$datas = [
            "keterangan" => $this->keterangan
        ];

	 if($this->jenisBarang == 1) {
                $datas['serialNumber'] = $this->serialNumber;
        }


        $valid = $barangMasuk->update($datas);

        if ($valid) {
	    $dataLogs = [
                'category_id' => $barangMasuk->category_id,
                'keterangan' =>  "User " . Auth::user()->username . " Merubah SerialNumbe Pada Pemasukan Barang",
                'method' => "POST/PUT",
                'id_masuk' => $barangMasuk->id,
                'dataLama' => $snLama,
                'dataBaru' => $barangMasuk->serialNumber,
            ];
	    ActivityLog::create($dataLogs);
            $this->emit('refreshParent');
            $this->dispatchBrowserEvent('closemodaledit');
            $this->cleanVars();
        }
    }
    private function cleanVars()
    {
        $this->serialNumber = null;
    }


    public function render()
    {
        return view('livewire.edit-sn');
    }
}
