<div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">

                        <div class="col-sm">
                            <select class="form-select " id="bulan" wire:ignore aria-label="Default select example" wire:model="bulan">
                                <option selected value='' class="text-center"> --- Select Mount --- </option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value='03'>March</option>
                                <option value='04'>April</option>
                                <option value='05'>May</option>
                                <option value='06'>June</option>
                                <option value='07'>July</option>
                                <option value='08'>August</option>
                                <option value='09'>September</option>
                                <option value='10'>October</option>
                                <option value='11'>November</option>
                                <option value='12'>December</option>
                            </select>
                        </div>
                        <div class="col-sm">
                            <input class="form-control" id="tahun" type="text" wire:ignore wire:model="tahun" placeholder="--- Type Year ---" aria-label="tahun">

                        </div>
                        <div class="col-sm">
                            <input class="form-control" id="tanggal" type="date" wire:ignore wire:model="tanggal">
                        </div>


                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="clearFilter" wire:click="clear()" data-bs-dismiss="modal">Clear Filter</button>
                </div>

            </div>
        </div>
    </div>
    <div class="row align-items-center filter-menu">
        <div class="col-2">
            <select class="form-select filter-slc" aria-label="Default select example" wire:model="showEntris">

                <option value=5>5</option>
                <option value=15>15</option>
                <option value=25>25</option>
                <option value=50>50</option>
                <option value=100>100</option>
            </select>
        </div>

        <div class="col-10 text-end ">

            <div class="c2">
                <div class="input-box open" wire:ignore>
                    <input type="text" placeholder="Search..." wire:model="search">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather search-icon feather-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>



                </div>
                <div class="filter">

                    <button type="button" class="filter-btn filter-color " data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-filter">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- <input type="text" class="d-inline-block py-2 px-6 border border-light border-dark rounded" wire:model="search" placeholder="Search" aria-label="search"> -->
    </div>

    <div class="container mt-3">
	@if(auth()->user()->categories()->pluck('id')[0] != 1)

	<a href="{{Route('barang-keluar.exportAsnet', ['bulan' => $bulan, 'tahun' => $tahun, 'tanggal' => $tanggal, 'search' => $search, 'status' => $statusBarang])}}" class="btn bg-success mb-3">Export</a>
        @else
	<a href="{{Route('barang-keluar.export', ['bulan' => $bulan, 'tahun' => $tahun, 'tanggal' => $tanggal, 'search' => $search])}}" class="btn bg-success mb-3">Export</a>

        @endif
        @if(auth()->user()->categories()->pluck('id')[0] != 1)
<div class="mb-3">
            <button type="button" id="baru" class="btn btn-warning">Baru</button>
            <button type="button" id="bekas" class="btn btn-outline-warning">Bekas</button>
<select class="form-select" aria-label="Default select example"  wire:model="jenisBarang" style="width: 15%; display: inline-block;">
@foreach($barangCategories as $bc)
  <option value={{$bc->id}}>{{$bc->name}}</option>
@endforeach
</select>

        </div>

        <div class="table-responsive">
            <table class="table table-striped table-light table-hover">
                <thead>
                    <tr class="text-center  table-dark">
                        <th scope="col">#</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Device</th>
                        <th scope="col">Merk</th>
                        <th scope="col">Qty</th>
			<th scope="col">Tanggal</th>
			<th scope="col">Peanggung Jawab</th>
                        <th scope="col">Description</th>
                        <th scope="col" style="width:9rem;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$datas->count())
                    <tr class="text-center align-middle">
                        <td colspan="10">
                            <p class="text-center"><strong>Barang Tidak di Temukan</strong></p>
                        </td>
                    </tr>
                    @endif

                    @foreach($datas as $key => $data)

                    <tr class="text-center align-middle">
                        <th scope="row">{{$datas->firstItem() + $key}}</th>
                        <td>
                            <ul class="list-group" style="list-style: none;">
				@if(!empty($data->serialNumber))
                                @if(count($data->serialNumber) <= 2) @foreach($data->serialNumber as $sn)
                                    <li>{{$sn}}</li>
                                    @endforeach
                                    @else
                                    @for ($i = 0; $i < 2; $i++) <li>{{$data->serialNumber[$i]}}</li>
                                        @endfor
                                        <p>---</p>
                                        @endif
					@else
					<li>---</li>
					@endif
                            </ul>
                        </td>
                        <td>{{$data->device_categories->name}} </td>
                        <td>{{$data->merek}}</td>
                        <td>{{$data->unitKeluar}} @if($data->device_categories->jenis_id == 1) Unit @else Meter @endif</td>
			<td>{{(new DateTime($data->tanggalKeluar))->format(' l, d M Y')}}</td>
			<td>{{$data->penanggung_jawabs->name}}</td>
                        <td>{!! Str::limit($data->keterangan, 100) !!}</td>
                        <td>

                            <button type="submit" style="background-color: transparent; border: none;" wire:click='inputSN({{$data->id}}, {{$data->unitKeluar}})'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#cb9b2d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                            </button>



                            <form action="{{Route('barang-keluar.undo',['data' => $data->id, 'command'=>'hapus'])}}" method="post" class="d-inline">

                                @method(' delete')
                                @csrf
				 <button onclick="return confirm('Yakin Untuk Menhapus Barang Ini ? Barang Akan Otomatis di Kembalikan ke Pemasukan Barang')" type="submit" style="background-color: transparent; border: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke->
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button> 

                            </form>



                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
	<div class="d-flex justify-content-between">
		<div>
	        	{{ $datas->links() }}
		</div>
		<div class="bg-white py-2 rounded-2 px-4 align-top m-0">
			<p class="p-0 m-0 align-top">Total : <span class="fw-bold">{{$jumlahBarang}}</span></p>
		</div>
	</div>
        @else
        <div class="table-responsive">
            <table class="table table-striped table-light table-hover">
                <thead>
                    <tr class="text-center  table-dark">
                        <th scope="col">#</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Device</th>
                        <th scope="col">Merk</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Type</th>
                        <th scope="col">Owner</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$datas->count())
                    <tr class="text-center align-middle">
                        <td colspan="9">
                            <p class="text-center"><strong>Barang Tidak di Temukan</strong></p>
                        </td>
                    </tr>
                    @endif
                    @foreach($datas as $key => $data)

                    <tr class="text-center align-middle">
                        <th scope="row">{{$datas->firstItem() + $key}}</th>
                        <td>
                            <ul class="list-group" style="list-style: none;">
                                @if(count($data->serialNumber) < 3) @foreach($data->serialNumber as $sn)
                                    <li>{{$sn}}</li>
                                    @endforeach
                                    @else
                                    @for ($i = 0; $i < 3; $i++) <li>{{$data->serialNumber[$i]}}</li>
                                        @endfor
                                        <p>...</p>
                                        @endif
                            </ul>
                        </td>
                        <td>{{$data->device}}</td>
                        <td>{{$data->merek}}</td>
                        <td>{{$data->unitKeluar}}</td>
                        <td>{{Str::limit($data->type, 20)}}</td>
                        <td>{{$data->pemilik}}</td>
                        <td>{{(new DateTime($data->tanggalKeluar))->format(' l, d M Y')}}</td>
                        <td>


                            <button class="open_modal_show" value="{{$data->id}}" data-url="{{Route('barang-keluar.show',$data->id)}}" type="button" style="background-color: transparent; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#a98a0c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                            <form action="{{Route('barang-keluar.destroy', $data->id)}}" method="post" class="d-inline">

                                @method('delete')
                                @csrf
                                <button onclick="return confirm('Apakah Anda Yakin Untuk Menghapus Barang ini?');" type="submit" style="background-color: transparent; border: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>

                            </form>


                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $datas->links() }}

        @endif

    </div>
    @livewire('input-s-n')
<script>
        document.addEventListener('livewire:load', function() {
            $('#bekas').on('click', function() {
                @this.set('statusBarang', 2)
            })
            $('#baru').on('click', function() {
                @this.set('statusBarang', 1)
            })


        })
    </script>
</div>
