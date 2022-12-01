<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PenanggungJawab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class PenanggungJawabController extends Controller
{
    public function index()
    {
        $categori_id = Auth::user()->categories()->pluck('id');
        if (Auth::user()->role == 'admin') {
            $pnj = PenanggungJawab::orderby('name', 'ASC')->get();
        } else {

            $pnj = PenanggungJawab::where('category_id', $categori_id)->orderby('name', 'ASC')->get();
        }

        $datas = [
            'title' => 'Penggung Jawab',
            'pnj' => $pnj,

        ];

        $datas['category'] = Category::all();;

        return view('penggungJawab.index', $datas);
    }



    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
        ]);

        if (Auth::user()->role != 'admin') {
            $validated['category_id'] = Auth::user()->categories()->pluck('id')->first();
        } else {
            $validated['category_id'] = $request->category_id;
        }

        $valid = PenanggungJawab::create($validated);

        if ($valid) {

            return redirect(Route('penanggung-jawab.index'));
        } else {
            return redirect(Route('penanggung-jawab.index'));
        }
    }


    public function destroy(PenanggungJawab $penanggungJawab)
    {

        $valid = PenanggungJawab::destroy($penanggungJawab->id);
        if ($valid) {
            return redirect(Route('penanggung-jawab.index'));
        }
    }
}
