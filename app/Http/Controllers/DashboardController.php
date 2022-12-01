<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
 $categori_id = Auth::user()->categories()->pluck('id');
	if (Auth::user()->role == 'admin') {
            $filterLog = ActivityLog::all();
        } else {
            $filterLog = ActivityLog::where('category_id', $categori_id)->latest()->limit(10)->get();
        }
	$datas = [
            'title' => 'Dashboard',
            'logs' => $filterLog,
        ];

if(Auth::user()->role != 'admin'){
        $filterPengeluaranBarang = BarangKeluar::whereIn('category_id', $categori_id);
	$filterPemasukanBarang = BarangMasuk::whereIn('category_id', $categori_id);
	
	if($categori_id[0] != 1){
	$resultPemasukanBarang = $filterPemasukanBarang->with('device_categories')->groupBy('device_id')->orderBy(DB::raw('SUM(unit)', 'desc'))
            ->get(array(DB::raw('SUM(unit) as totalBarang'), 'device_id'));


        $resultPengeluaranBarang = $filterPengeluaranBarang->with('device_categories')->groupBy('device_id')->orderBy(DB::raw('SUM(unitKeluar)', 'desc'))
            ->get(array(DB::raw('SUM(unitKeluar) as totalBarang'), 'device_id'));

	}else{
	$resultPemasukanBarang = $filterPemasukanBarang->count();
	$resultPengeluaranBarang = $filterPengeluaranBarang->count();
	}
	$datas['unitMasuk'] = $resultPemasukanBarang;
	$datas['unitKeluar'] = $resultPengeluaranBarang;
}




        return view('dashboard.index', $datas);
    }
}
