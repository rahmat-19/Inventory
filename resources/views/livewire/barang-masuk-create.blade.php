<div class="modal-body">
    <form wire:submit.prevent="save">
        @csrf
        @method('POST')



        <div class="row">
            <div class="col ">
                
                <button wire:click.prevent="plus({{$i}})" class="btn btn-outline-success" id="klm">+</button>

               
                <div class="mb-3 ">
                    <label for="serialNumber" class="form-label d-block">Serial Number <span class="text-info">Optional</span></label>
                    @foreach($inputs as $index => $input)
                    <div class="row mb-1">
                        <div class="@if($index != 0) col-10 @else col @endif">
                            <input htmlspecialchars type="text" class="form-control @error('serialNumber.'.$index) is-invalid @enderror" placeholder="Serial Number" wire:model="serialNumber.{{ $index }}">
                            @error('serialNumber.'.$index) <span class="text-danger error">{{ $message }}</span>@enderror

                        </div>
                        @if($index != 0)
                        <div class="col-2 text-end">

                            <button type="button" class="btn btn-warning" wire:click.prevent="remove({{$index}})">-</button>
                        </div>
                        @endif
                    </div>


                    @error('serialNumber.*')
                    <div id=" serialNumber" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                    @endforeach
                </div>


                @if(auth()->user()->categories->pluck('id')[0] == 1)

                <div class="mb-3">
                    <label for="device" class="form-label">Device <span class="text-danger">*</span></label>
                    <input htmlspecialchars type="text" placeholder="Device" wire:model="device" name="device" class="form-control  @error('device') is-invalid @enderror" value="{{old('device')}}" id="device">
                    @error('device')
                    <div id="device" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                @else
                <div class="mb-3">
                    <label for="device_id" class="form-label">Device <span class="text-danger">*</span></label>
                    <select class="form-control  @error('device_id') is-invalid @enderror" value="{{old('device_id')}}" id="device_id" wire:model="device_id" aria-label="Default select example">
                        <option selected>Open Select</option>
                        @foreach($deviceBarang as $device)
                        <option value="{{$device->id}}">{{$device->name}}</option>
                        @endforeach

                    </select>
                    @error('device_id')
                    <div id="device_id" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
		</div>

		 <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                    <label class="form-check-label" for="flexSwitchCheckChecked"><span class="text-muted">Matikan Jika Barangnya Bekas</span></label>
                </div>

		@if($status == 2)



			<label class"form-check-label" for="satusBarang">Setatus Barang</label>
			<select class="form-select" aria-label="Default select example" wire:model="barangRusak">
				<option value=1>Baik</option>
				<option value=2>Rusak</option>
			</select>

			@endif


                @endif



                <div class="mb-3">
                    <label for="merek" class="form-label">Merk <span class="text-danger">*</span></label>
                    <input htmlspecialchars type="text" placeholder="Merk" wire:model="merek" name="merek" class="form-control  @error('merek') is-invalid @enderror" value="{{old('merek')}}" id="merek">
                    @error('merek')
                    <div id="merek" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>
               
                @if(empty($serialNumber) || (count($serialNumber)==1 && $serialNumber[0] == ''))
                <div class="mb-3">
                    <label for="unit" class="form-label">unit <span class="text-danger">*</span></label>
                    <input htmlspecialchars type="text" wire:model="unit" placeholder="Qty / Meter" name="unit" class="form-control  @error('unit') is-invalid @enderror" value="{{old('unit')}}" id="unit">
                    @error('unit')
                    <div id="unit" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                @endif
           

                @if(auth()->user()->categories->pluck('id')[0] == 1)
                <div class="mb-3">
                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                    <input htmlspecialchars type="text" placeholder="Type" wire:model="type" name="type" class="form-control  @error('type') is-invalid @enderror" value="{{old('type')}}" id="type">
                    @error('type')
                    <div id="type" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror

                </div>

                <div class="mb-3">
                    <label for="pemilik" class="form-label">Owner <span class="text-danger">*</span></label>
                    <input htmlspecialchars type="text" wire:model="pemilik" placeholder="Owner" name="pemilik" class="form-control  @error('pemilik') is-invalid @enderror" value="{{old('pemilik')}}" id="pemilik">
                    @error('pemilik')
                    <div id="pemilik" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                @endif







            </div>


            <div class="col">
                <div class="mb-3">
                    &ensp;
                </div>
                <div class="mb-3" wire:ignore>
                    <label for="penanggungJawab" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                    <select class="select2 js-states form-select" required aria-label="Default select example" style="width: 100%;">
                        <option>SELECT Penanggung Jawab</option>
                        @foreach($penangungJawab as $pj)
                        <option value={{$pj->id}}>{{$pj->name}}</option>
                        @endforeach
                    </select>
                    @error('penangungJawab_id')
                    <div id="penanggungJawab" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="device" class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input htmlspecialchars type="date" wire:model="tanggal" class="form-control  @error('tanggal') is-invalid @enderror" value="{{old('tanggal')}}" id="tanggal">
                    @error('tanggal')
                    <div id="tanggal" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>





                @if(auth()->user()->categories->pluck('id')[0] == 1)
                <div class="mb-3">
                    <label for="inputGambar" class="form-label">Input Image <span class="text-info">(Optional)</span></label>

               @if ($gambar)
                    <img class="img-preview img-fluid rounded-2 d-block mb-3 col-sm-5" src="{{ $gambar->temporaryUrl() }}">
                    @endif
                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" id="inputGambar" wire:model="gambar">

                    @error('gambar')
                    <div id="unit" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                @endif


                <div class="mb-3">
                    <div class="mb-4" wire:model.debounce.365ms="keterangan" wire:ignore>
                        <label for="keterangan" class="form-label">Keterangan <span class="text-info">(Optional)</span></label>
                        <input id="body" type="hidden" name="content" class="form-control keter  @error('keterangan') is-invalid @enderror" id="keterangan" value="{{old('keterangan')}}">
                        <trix-editor style="background-color: white;" input="body" class="bdy"></trix-editor>
                        @error('keterangan')
                        <div id="body" class="invalid-feedback mb-3">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

            </div>

        </div>










        <div class="button-footer text-end mt-3 border-top pt-3">
            <a href="{{route('barang-masuk.index')}}" class="btn btn-secondary">Cancel</a>
            <button class="btn btn-primary @if(!$penangungJawab_id)  disabled @endif">Save</button>
        </div>
    </form>


    <script>
        document.addEventListener('livewire:load', function() {
            $('.select2').select2({
                // placeholder: "Select a state",
                // theme: "classic",
                allowClear: true,
                // tags: true,

            })


            $('.select2').on('change', function() {
                @this.set('penangungJawab_id', this.value)
	    })

	     $('#flexSwitchCheckChecked').on('change', function() {

                if (this.checked == true) {
                    @this.set('status', 1)
                } else {
                    @this.set('status', 2)
                }
            })


        })

    </script>

</div>
