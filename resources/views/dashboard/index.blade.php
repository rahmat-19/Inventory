@extends('layout.main')


@section('container')
<link rel="stylesheet" type="text/css" href="{!! asset('css/sb-admin-2.min.css') !!}">
<div class="container">
    <div class="row">
@if(auth()->user()->role != 'admin')
@if(is_object($unitMasuk))







<div class="col-xl-5 col-md-6 ">
            <div class="card border-left-success shadow h-100 py-1">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col ms-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                                Pengeluaran Barang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <div class="row">
                                    @foreach($unitMasuk as $um)
                                    <div class="col-xl-5 col-md-6">
                                        <div class="card border-left-primary shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col ms-2">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                            {{$um->device_categories->name}}
                                                        </div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$um->totalBarang}} @if($um->device_id == 2) Meter @elseif(!$um->device_id || $um->device_id == 1) Unit @endif</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>










        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-5 col-md-6 ">
            <div class="card border-left-danger shadow h-100 py-1">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col ms-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-2">
                                Pengeluaran Barang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <div class="row">
                                    @foreach($unitKeluar as $um)
                                    <div class="col-xl-5 col-md-6">
                                        <div class="card border-left-secondary shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col ms-2">
                                                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                            {{$um->device_categories->name}}
                                                        </div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$um->totalBarang}} @if($um->device_id == 2) Meter @elseif(!$um->device_id || $um->device_id == 1) Unit @endif</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@else
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pemasukan Barang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$unitMasuk}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pengeluaran Barang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$unitKeluar}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endif
@endif
    </div>

    <div class="row mt-4">
        <div class="col">
            <h2>Activitas User</h2>
            @if(!$logs->count())
            <p class="my-5"><strong>Tidak di Temukan Activitas</strong></p>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Method</th>
			<th scope="col">Data Lama</th>
			<th scope="col">Data Baru</th>
			<th scope="col">Keterangan</th>
			<th scope="col">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$log->method}}</td>
			<td>
				@if(!empty($log->dataLama))
				@foreach($log->dataLama as $dataLama)
					<p>{{$dataLama}}</p>
				@endforeach
				@endif
			</td>
			<td>
                                @if(!empty($log->dataBaru))
                                @foreach($log->dataBaru as $dataBaru)
                                        <p>{{$dataBaru}}</p>
                                @endforeach
                                @endif
                        </td>

			<td>{{$log->keterangan}}</td>
			<td>{{(new DateTime($log->created_at))->format('d M Y')}}<td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

        </div>
        <!-- <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0"></div> -->

    </div>


</div>
@endsection
