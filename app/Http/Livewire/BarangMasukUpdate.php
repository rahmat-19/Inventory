<?php

namespace App\Http\Livewire;

use App\Models\BarangMasuk;
use App\Models\PenanggungJawab;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;

class BarangMasukUpdate extends Component
{
    use WithFileUploads;


    public $serialNumbers = [];
    public $serialNumber = [];
    public $inputs = [0];
    public $i = 1;
    public $category_id, $itemId, $penangungJawab_id, $pemilik, $device, $merek, $type, $gambar, $keterangan, $dbGambar, $tanggalMasuk;
    protected $rules = [
        'serialNumber.*' => 'required',
        'type' => 'required',
        'pemilik' => 'required',
        'keterangan' => 'nullable',
        'penangungJawab_id' => 'required',
        'device' => 'required',
        'merek' => 'required',
        'tanggalMasuk' => 'required',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:6144',
    ];

    protected $messages = [
        'serialNumber.0.required' => 'The Serial Number cannot be empty'
    ];

    public function mount($datas)
    {
        $this->itemId = $datas->id;
        $this->serialNumber = $datas->serialNumber;
        $this->penangungJawab_id = $datas->penangungJawab_id;
        $this->pemilik = $datas->pemilik;
        $this->device = $datas->device;
        $this->merek = $datas->merek;
        $this->type = $datas->type;
        $this->dbGambar = $datas->gambar;
        $this->keterangan = $datas->keterangan;
        $this->tanggalMasuk = $datas->tanggalMasuk;
        $this->category_id = $datas->category_id;
        if (!empty($datas->serialNumber)) {
            $this->inputs = $datas->serialNumber;
        }
    }

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
        $validatedData = $this->validate($this->rules);
        if ($this->dbGambar) {

            $validatedData['gambar'] = $this->dbGambar;
        }
        if ($this->gambar) {
            $validatedData['gambar'] = $this->gambar->hashName();
        }
	$validatedData['unit'] = count($this->serialNumber);
        $validatedData['unitAwal'] = count($this->serialNumber);
        $validatedData['category_id'] = $this->category_id;
        $valid = BarangMasuk::where('id', $this->itemId)
            ->update($validatedData);

        if ($valid) {
            if ($this->gambar) {
                $this->gambar->storeAs('public/ImagesBarang', $this->gambar->hashName());
                Storage::disk('local')->delete('public/ImagesBarang/' . $this->dbGambar);
            }
            return redirect(Route('barang-masuk.index'));
        } else {

            return redirect(Route('barang-masuk.index'));
        }
    }



    public function render()
    {
        $categori_id = Auth::user()->categories()->pluck('id');
        $pnj = PenanggungJawab::where('category_id', $categori_id)->get();
        return view('livewire.barang-masuk-update', [
            "penangungJawab" => $pnj,
        ]);
    }
}

