<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;
use App\Models\PenanggungJawab;


class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        return view('BarangMasuk.index', [
            'title' => 'Masuk Barang'
        ]);
    }

    public function create()
    {
        return view('BarangMasuk.create', [
            'title' => 'Tambah | Barang',
            'categorys' => Auth::user()->categories,
        ]);
    }



    public function show(BarangMasuk $barangMasuk)
    {
        $data = $barangMasuk;
        return response()->json($data);
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        // dd($barangMasuk->serialNumber);
        $this->authorize('update', $barangMasuk);

        return view('BarangMasuk.update', [
            'title' => 'Data | UPdate',
            'datas' => $barangMasuk,
        ]);
    }


    public function destroy(BarangMasuk $barangMasuk)
    {
        $valid = BarangMasuk::destroy($barangMasuk->id);
        if ($valid) {
            $dataUpdate = [
                'category_id' => $barangMasuk->category_id,
                'keterangan' => "User " . Auth::user()->username . " Menghapus Barang ({$barangMasuk->device}) dari Table Pengeluaran Barang",
                'method' => "DELETE",
            ];

            if (Auth::user()->categories->pluck('id')[0] != 1) {
                $dataUpdate['keterangan'] = "User " . Auth::user()->username . " Menghapus Barang ({$barangMasuk->device_categories->name})  dari Table Pengeluaran Barang";
            }

            ActivityLog::create($dataUpdate);
            return redirect(Route('barang-masuk.index'));
            Storage::disk('local')->delete('public/ImagesBarang/' . $barangMasuk->gambar);
        }
    }

public function form(BarangMasuk $barangMasuk)
    {
        $categori_id = Auth::user()->categories()->pluck('id');
        $pnj = PenanggungJawab::where('category_id', $categori_id)->get();
        return view('BarangMasuk.form', [
            'title' => 'Data | Form',
            'data' => $barangMasuk,
            'penangungJawabs' => $pnj
        ]);
    }

    public function formPost(Request $request)
    {
        $datasTarget = BarangMasuk::find($request->masuk_id);
        $categori_id = Auth::user()->categories()->pluck('id')[0];
        $validateds = [
            'serialNumber' => 'required',
            'penangungJawab_id' => ['required'],
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
            'keterangan' => 'nullable',
            'tanggalKeluar' => 'required|date',
            'merek' => 'required',
            'pemilik' => 'required',
            'type' => 'required',
            'device' => 'required',
            'masuk_id' => 'required',
            'satusBarang' => 'required',
	    'barangRusak' => 'required',
            'unitKeluar' => "nullable|numeric|min:1|max:{$datasTarget->unit}"

        ];

        if ($categori_id != 1) {
            $validateds['device'] = 'nullable';
            $validateds['pemilik'] = 'nullable';
            $validateds['type'] = 'nullable';
            $validateds['device_id'] = 'required';
            $validateds['serialNumber'] = 'nullable';
        }

        $validatedData = $request->validate($validateds);


        if ($request->file('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->hashName();
            $request->gambar->storeAs('public/ImagesBarangKeluar', $request->gambar->hashName());
        }
        if (!$request->serialNumber) {
            $validatedData['serialNumber'] = [];
        }

        $validatedData['category_id'] = $categori_id;

        if (!$request->unitKeluar) {
            $validatedData['unitKeluar'] = count($request->serialNumber);
        }
        $result = BarangKeluar::create($validatedData);
        if ($result) {

            $serial = $datasTarget->serialNumber;
            if (!empty($result->serialNumber)) {
                $datasSerial = array_values(array_diff($serial, $request->serialNumber));
                $datasTarget->update([
                    'unit' => $datasTarget->unit - $result->unitKeluar,
                    'serialNumber' => $datasSerial
                ]);
            } else {
                $datasTarget->update([
                    'unit' => $datasTarget->unit - $result->unitKeluar,
                ]);
            }
	 $dataUpdate = [
                'category_id' => $result->category_id,
                'keterangan' => "Pengeluaran Barang ({$result->device}) dengan jumlah {$result->unitKeluar} unit, yang dikeluarkan oleh user " . Auth::user()->username,
                'method' => "POST",
            ];

            if (Auth::user()->categories->pluck('id')[0] != 1) {

                $satuan = $result->device_categories->jenis_id == 1 ? 'Unit' : 'Meter';
                $dataUpdate['keterangan'] = "Pengeluaran Barang ({$result->device_categories->name}) dengan jumlah {$result->unitKeluar} {$satuan}, yang dikeluarkan oleh user " . Auth::user()->username;
            }

            ActivityLog::create($dataUpdate);


            return redirect(Route('barang-masuk.index'));
        } else {
            return redirect(Route('barang-masuk.index'));
        }
    }
}
