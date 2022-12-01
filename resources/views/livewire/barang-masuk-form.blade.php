<div class="modal fade" wire:ignore.self id="ModalUpdate" tabindex="-1" aria-labelledby="ModalUpdateLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pengeluaran Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form wire:submit.prevent="save">
		    @if($action != "keluar-2")

                    @if(count($serialNumber) != 1)

                    <select style="height: 90px;" id="myMultipleSelect2" wire:model="serialNumbers" class="form-select" multiple aria-label="multiple select example">
                        @foreach($serialNumber as $sn)
                        <option value="{{$sn}}">{{$sn}}</option>
                        @endforeach

                    </select>
                    @endif


                    <div class="mb-3">
                        <label for="pemilik" class="form-label">pemilik</label>
                        <input type="text" name="pemilik" wire:model="pemilik" class="form-control @error('pemilik') is-invalid @enderror" id="pemilik" @if($action=="keluar" ) disabled @endif>
                        @error('pemilik')
                        <div id="pemilik" class="invalid-feedback mb-3">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    @endif

                    @if($action == 'keluar-2')
                    <div class="mb-3">
                        <label for="unitKeluar" class="form-label">Unit <span class="text-danger">*</span></label>
                        <input type="number" wire:model="unitKeluar" required class="form-control  @error('unitKeluar') is-invalid @enderror" value="{{old('unitKeluar')}}" id="unitKeluar">
                        @error('unitKeluar')
                        <div id="unitKeluar" class="invalid-feedback mb-3">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    @endif





                    <div class="mb-3" wire:ignore>
                        <label for="penanggungJawab" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                        <select wire:ignore id="mySelect2" class="form-select" style="width: 100%;">
                            <option>Select Option</option>
                            @foreach($penangungJawab as $pnj)
                            <option value={{$pnj->id}}>{{$pnj->name}}</option>
                            @endforeach
                        </select>

                        @error('penanggungJawab')
                        <div id="penanggungJawab" class="invalid-feedback mb-3">
                            {{$message}}
                        </div>
                        @enderror
                    </div>



                    <div class="mb-3">
                        <label for="device" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" wire:model="tanggalKeluar" required class="form-control  @error('tanggalKeluar') is-invalid @enderror" value="{{old('tanggalKeluar')}}" id="tanggalKeluar">
                        @error('tanggalKeluar')
                        <div id="tanggalKeluar" class="invalid-feedback mb-3">
                            {{$message}}
                        </div>
                        @enderror
                    </div>





                    @if($action != 'keluar-2')

                    <div class="mb-3">
                        <label for="inputGambar" class="form-label">Input Image <span class="text-info">Optional</span></label>

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






                    <button type="submit" class="btn btn-primary">Save</button>
                </form>











            </div>


        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {


            $('#mySelect2').select2({
                placeholder: "Select Option",
                dropdownParent: $('#ModalUpdate')
            }).on('change', function() {
                @this.set('penanggungJawab', this.value)
            });
        })
    </script>
</div>
