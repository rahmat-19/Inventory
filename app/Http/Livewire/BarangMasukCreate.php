<?php

namespace App\Http\Livewire;

use App\Models\ActivityLog;
use App\Models\BarangMasuk;
use App\Models\DeviceCategory;
use App\Models\HistoryBarangMasuk;
use App\Models\PenanggungJawab;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithFileUploads;

class BarangMasukCreate extends Component
{

    use WithFileUploads;
    public $serialNumbers = [];
    public $serialNumber = [];
    public $otomatis;
    public $status = 1;
    public $barangRusak = 1;
    public $device_id;
    public $gambar;
    public $type;
    public $unit;
    public $pemilik;
    public $penangungJawab_id;
    public $device;
    public $keterangan;
    public $tanggal;
    public $merek;
    public $inputs = [0];
    public $i = 1;

    protected $rules = [
        'device' => 'required',
        'merek' => ['required'],
        'tanggal' => ['required'],
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:6144',
        'penangungJawab_id' => 'required'
    ];

    public function plus($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        unset($this->serialNumber[$i]);
    }


    public function save()
    {
        if (Auth::user()->categories->pluck('id')[0] == 1) {
            $this->rules['penangungJawab_id'] = 'required';
            $this->rules['pemilik'] = 'required';
            $this->rules['type'] = 'required';
        } else {
            $this->rules['device_id'] = 'required';
            $this->rules['device'] = 'nullable';
            if (!$this->serialNumber) {

                $this->rules['unit'] = 'required|numeric';
            }
        }

        if ($this->otomatis) {
            $this->rules['unit'] = 'required|numeric';
            $this->inputs = [0];
        }


        $this->validate();

        $data = [
            'device_id' => $this->device_id,
            'device' => $this->device,
            'merek' => $this->merek,
            'tanggalMasuk' => $this->tanggal,
            'category_id' => Auth::user()->categories[0]->id,
            'keterangan' => $this->keterangan,
            'satusBarang' => $this->status,
	    'barangRusak' => $this->barangRusak,
	    'unitAwal' => $this->unit,
            'unit' => $this->unit,
            'penangungJawab_id' => $this->penangungJawab_id
        ];

        if (Auth::user()->categories->pluck('id')[0] == 1) {
            $data['pemilik'] = $this->pemilik;
            $data['type'] = $this->type;
        }



        $hariMasuk = date('d.m.y', strtotime($this->tanggal));
        if ($this->otomatis) {
            for ($x = 1; $x <= $this->unit; $x++) {
                $push = $this->serialNumber[0] . '-' . $hariMasuk  . '-' . $x;
                array_push($this->serialNumbers, $push);
            }
            $data['serialNumber'] = $this->serialNumbers;
	    $data['unit'] = $this->unit;
	    $data['unitAwal'] = $this->unit;
        } else {
            $data['serialNumber'] = $this->serialNumber;
	    if (!$this->unit) {
		$data['unitAwal'] = count($this->serialNumber);
                $data['unit'] = count($this->serialNumber);
            }
        }

        if ($this->gambar) {
            $data['gambar'] = $this->gambar->hashName();
            $this->gambar->storeAs('public/ImagesBarang', $this->gambar->hashName());
        }


//        dd($data);
        $valid = BarangMasuk::create($data);
        if ($valid) {
            HistoryBarangMasuk::create($data);
	    $unit = $this->unit ? $this->unit : count($this->serialNumber);
	    $dataUpdate = [
                'category_id' => Auth::user()->categories[0]->id,
                'keterangan' => "User " . Auth::user()->username . " Menambahkan Barang {$valid->device} dengan jumlah {$unit} unit",
                'method' => "POST",
	    ];
	    if (Auth::user()->categories->pluck('id')[0] != 1) {
                $dataUpdate['keterangan'] = "User " . Auth::user()->username . " Menambahkan Barang {$valid->device_categories->name} dengan jumlah {$unit} unit";
            }
            ActivityLog::create($dataUpdate);

            Alert::success('Success', 'Data Has Been Added Successfully');

            return redirect(Route('barang-masuk.index'));
        } else {
            Alert::error('Error', 'Data Failed to Add');
            return redirect(Route('barang-masuk.index'));
        }
    }

    public function render()
    {
        $categori_id = Auth::user()->categories()->pluck('id');
        $pnj = PenanggungJawab::where('category_id', $categori_id)->get();


        $datas = [
            "penangungJawab" => $pnj,
            "deviceBarang" => DeviceCategory::all()
        ];
        return view('livewire.barang-masuk-create', $datas);
    }
}
