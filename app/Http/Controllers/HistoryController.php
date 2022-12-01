<?php

namespace App\Http\Controllers;

use App\Models\HistoryBarangMasuk;

class HistoryController extends Controller
{
    public function index()
    {
        return view('history.index', [
            'title' => 'History | Pemasukan Barang'
        ]);
    }

    public function show(HistoryBarangMasuk $history)
    {
        $data = $history;
        return response()->json($data);
    }

public function destroy(HistoryBarangMasuk $history)
    {
        $valid = BarangMasuk::destroy($history->id);
        if ($valid) {
            Storage::disk('local')->delete('public/ImagesBarang/' . $history->gambar);

            return redirect(Route('history.index'));
        }
    }
}
