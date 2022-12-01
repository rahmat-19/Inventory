<div class="modal-body">

    <form wire:submit.prevent="save">
        @csrf
        @method('POST')



        <div class="row">
            <div class="col ">

                <button wire:click.prevent="plus({{$i}})" class="btn btn-outline-success" id="klm">+</button>
                <div class="mb-3 ">
                    <label for="serialNumber" class="form-label d-block">Serial Number <span class="text-danger">*</span></label>
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


                <div class="mb-3">
                    <label for="device" class="form-label">Device <span class="text-danger">*</span></label>
                    <input htmlspecialchars type="text" placeholder="Device" wire:model="device" name="device" class="form-control  @error('device') is-invalid @enderror" value="{{old('device')}}" id="device">
                    @error('device')
                    <div id="device" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>






                <div class="mb-3">
                    <label for="merek" class="form-label">Merk <span class="text-danger">*</span></label>
                    <input htmlspecialchars type="text" placeholder="Merk" wire:model="merek" name="merek" class="form-control  @error('merek') is-invalid @enderror" value="{{old('merek')}}" id="merek">
                    @error('merek')
                    <div id="merek" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>


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
                        @if($penangungJawab_id === $pj->id)
                        <option value="{{$pj->id}}" selected>{{$pj->name}}</option>

                        @else
                        <option value={{$pj->id}}>{{$pj->name}}</option>
                        @endif
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
                    <input type="date" class="form-control  @error('tanggal') is-invalid @enderror" value="{{(new DateTime($tanggalMasuk))->format('Y-m-d') }}" id="tanggalMasuk">
                    @error('tanggal')
                    <div id="tanggal" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>





                <div class="mb-3">
                    <label for="file" class="form-label">Input Image <span class="text-info">(Optional)</span></label>
                    @if ($dbGambar && !$gambar)
                    <img class="img-preview img-fluid rounded-2 d-block mb-3 col-sm-5" src="{{ Storage::url('public/ImagesBarang/'. $dbGambar) }}">
                    @elseif($gambar)

                    <img class="img-preview img-fluid rounded-2 d-block mb-3 col-sm-5" src="{{ $gambar->temporaryUrl() }}">
                    @endif


                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" id="file" wire:model="gambar">

                    @error('gambar')
                    <div id=" gambar" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>




                <div class="mb-3">
                    <div class="mb-4" wire:ignore>
                        <label for="keterangan" class="form-label">Keterangan <span class="text-info">(Optional)</span></label>
                        <input id="body" type="hidden" name="content" class="form-control keter  @error('keterangan') is-invalid @enderror" id="keterangan">
                        <trix-editor style=" background-color: white;" wire:model.debounce.365ms="keterangan" input="body" class="bdy"></trix-editor>
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
            <a href="{{route('barang-masuk.index')}}" class="btn btn-secondary">Cancle</a>
            <button class="btn btn-primary">Save</button>
        </div>
    </form>


    <script>
        function previewImage() {
            const image = document.querySelector("#file");
            const priview = document.querySelector('.img-preview')


            priview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                priview.src = oFREvent.target.result;
            }

        }
        document.addEventListener('livewire:load', function() {
            $('.select2').select2({
                allowClear: true,

            })
            $('.select2').on('change', function() {
                @this.set('penangungJawab_id', this.value)
            })
            $('#tanggalMasuk').on('change', function() {
                @this.set('tanggalMasuk', this.value)
            })

        })
    </script>

</div>
