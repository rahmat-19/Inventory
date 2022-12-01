<div>

    <!-- ======================================== FILTER DATA ======================================== -->

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
                            <select class="form-select" id="bulan" wire:ignore aria-label="Default select example" wire:model="bulan">
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

        <div class="col-10 text-end">

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
    </div>

    <!-- =================================================================================================================================== -->
    <div class="container mt-3">

        @if(auth()->user()->categories()->pluck('id')[0] != 1)
<div class="mb-3">
            <button type="button" id="baru" class="btn btn-warning">Baru</button>
            <button type="button" id="bekas" class="btn btn-outline-warning">Bekas</button>
<select class="form-select" aria-label="Default select example"  wire:model="jenisBarang" style="width: 15%; display: inline-block;">
@foreach($barangCategories as $bc)
  <option value={{$bc->id}}>{{$bc->name}}</option>
@endforeach
</select>
<div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" id="hideunit" checked>
  <label class="form-check-label" for="hideunit">Hide the Units 0</label>
</div>

@if($statusBarang == 2)
@endif
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-light table-hover">
                <thead>
                    <tr class="text-center  table-dark">
                        <th scope="col">#</th>
                        <th scope="col" width="20%">Serial Number</th>
                        <th scope="col">Device</th>
			<th scope="col">Merk</th>
			<th scope="col">Unit Awal</th>
                        <th scope="col">Sisa Unit</th>
			<th scope="col">Tanggal</th>
			<th scope="col">Penanggung Jawab</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
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
				<div class="row">
				<div class="col">
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
				</div>
				<div class="col align-middle text-center">
					<button type="submit" style="background-color: transparent; border: none;" wire:click='inputSN({{$data->id}}, {{$data->unit}})'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#cb9b2d" stroke-width="2" stroke-linecap="round" stroke->
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                            </button>


				</div>
				</div>
                            </ul>
                        </td>

                        <td>{{$data->device_categories->name}}</td>
			<td>{{$data->merek}}</td>
			<td>{{$data->unitAwal}} @if($data->device_categories->jenis_id == 1) Unit @else Meter @endif</td>
                        <td>{{$data->unit}} @if($data->device_categories->jenis_id == 1) Unit @else Meter @endif</td>
			<td>{{(new DateTime($data->tanggalMasuk))->format(' l, d M Y')}}</td>
			<td>{{$data->penanggung_jawabs->name}}</td>
                        <td>{!! Str::limit($data->keterangan, 100) !!}</td>
                        <td>
			@if($data->unit != 0)
                           <!-- <button type="button" style="background-color: transparent; border: none;" wire:click='getItems({{$data->id}})'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shuffle">
                                    <polyline points="16 3 21 3 21 8"></polyline>
                                    <line x1="4" y1="20" x2="21" y2="3"></line>
                                    <polyline points="21 16 21 21 16 21"></polyline>
                                    <line x1="15" y1="15" x2="21" y2="21"></line>
                                    <line x1="4" y1="4" x2="9" y2="9"></line>
                                </svg>
			    </button> -->

<a href="{{Route('barang-masuk.form', $data->id)}}" style="background-color: transparent; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shuffle">
                                    <polyline points="16 3 21 3 21 8"></polyline>
                                    <line x1="4" y1="20" x2="21" y2="3"></line>
                                    <polyline points="21 16 21 21 16 21"></polyline>
                                    <line x1="15" y1="15" x2="21" y2="21"></line>
                                    <line x1="4" y1="4" x2="9" y2="9"></line>
                                </svg>
                            </a>
			@endif



                            <form action="{{Route('barang-masuk.destroy',$data->id)}}" method="post" class="d-inline">

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
	<div>
		{{ $datas->links() }}
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
			<th scope="col">Penaggung Jawab</th>
                        <th scope="col" style="width: 9rem;">Action</th>
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
		    @if($data->unit != 0)
                    <tr class="text-center align-middle">
                        <th scope="row">{{$datas->firstItem() + $key}}</th>
                        <td>
                            <ul class="list-group" style="list-style: none;">
                                                @if(count($data->serialNumber) <= 2) @foreach($data->serialNumber as $sn)
                                                        <li>{{$sn}}</li>
                                                        @endforeach
                                                @else
                                                @for ($i = 0; $i < 2; $i++) <li>{{$data->serialNumber[$i]}}</li>
                                                @endfor
                                                <p>...</p>
                                                @endif
                            </ul>
                        </td>
                        <td>{{$data->device}}</td>
                        <td>{{$data->merek}}</td>
                        <td>{{$data->unit}}</td>
                        <td>{{Str::limit($data->type, 20)}}</td>
                        <td>{{$data->pemilik}}</td>
                        <td>{{(new DateTime($data->tanggalMasuk))->format(' l, d M Y')}}</td>
			<td>{{$data->penanggung_jawabs->name}}</td>
			<td>
			@if(!empty($data->serialNumber))
<a href="{{Route('barang-masuk.form', $data->id)}}" style="background-color: transparent; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shuffle">
                                    <polyline points="16 3 21 3 21 8"></polyline>
                                    <line x1="4" y1="20" x2="21" y2="3"></line>
                                    <polyline points="21 16 21 21 16 21"></polyline>
                                    <line x1="15" y1="15" x2="21" y2="21"></line>
                                    <line x1="4" y1="4" x2="9" y2="9"></line>
                                </svg>
                            </a>
                            <!-- <button type="button" style="background-color: transparent; border: none;" wire:click='keluar({{$data->id}})'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shuffle">
                                    <polyline points="16 3 21 3 21 8"></polyline>
                                    <line x1="4" y1="20" x2="21" y2="3"></line>
                                    <polyline points="21 16 21 21 16 21"></polyline>
                                    <line x1="15" y1="15" x2="21" y2="21"></line>
                                    <line x1="4" y1="4" x2="9" y2="9"></line>
                                </svg>
			    </button> -->
			@endif
			
			<a href="{{Route('barang-masuk.edit',$data->id)}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>

                            <button class="open_modal_show" value="{{$data->id}}" data-url="{{Route('barang-masuk.show',$data->id)}}" type="button" style="background-color: transparent; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#a98a0c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                            <form action="{{Route('barang-masuk.destroy',$data->id)}}" method="post" class="d-inline">

                                @method('delete')
				@csrf
                                <button onclick="return confirm('Apakah Anda Yakin Untuk Menghapus Barang ini?');"  type="submit" style="background-color: transparent; border: none;">
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
		   @endif

                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $datas->links() }}
        @endif
@livewire('edit-sn')

    </div>

 <script>
        document.addEventListener('livewire:load', function() {
            $('#bekas').on('click', function() {
                @this.set('statusBarang', 2)
            })
            $('#baru').on('click', function() {
                @this.set('statusBarang', 1)
            })

	 $('#hideunit').on('change', function() {
                if (this.checked == true) {
                    @this.set('hidden', 1)
                } else {
                    @this.set('hidden', null)
                }
            })

        })



    </script>
</div>
