@extends('layout.main')
@push('styls')
@livewireStyles
@endpush
@push('scripts')

@livewireScripts

<script>
    $(document).ready(function() {
        $('.serialNumber').select2({
            placeholder: "Select Serial Number",
            allowClear: true,
            tags: true
        });

        $('#mySelect2').select2({
            placeholder: "Penanggung Jawab",
            allowClear: true,
        });


    });

 function previewImage() {
        const image = document.querySelector("#inputGambar");
        const priview = document.querySelector('.img-preview')


        priview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            priview.src = oFREvent.target.result;
        }

    }
</script>
@endpush
@section('container')
<form action="{{Route('barang-masuk.formPost')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        @if(auth()->user()->categories()->pluck('id')[0] == 1)
        <input type="hidden" name="device" value="{{$data->device}}">
        <input type="hidden" name="type" value="{{$data->type}}">
        <input type="hidden" name="pemilik" value="{{$data->pemilik}}">
        @else
        <input type="hidden" name="device_id" value="{{$data->device_id}}">
        @endif
        <input type="hidden" name="masuk_id" value="{{$data->id}}">
        <input type="hidden" name="merek" value="{{$data->merek}}">
	<input type="hidden" name="satusBarang" value="{{$data->satusBarang}}">
	<input type="hidden" name="barangRusak" value="{{$data->barangRusak}}">
        
	<div class="row">
            <div class="col">
                @if(auth()->user()->categories()->pluck('id')[0] == 1)
                <div class="mb-3">
                    <label for="pemilik" class="form-label">pemilik <span class="text-danger">*</span></label>
                    <input type="text" name="pemilik" name="pemilik" disabled class="form-control @error('pemilik') is-invalid @enderror" id="pemilik" value="{{old('pemilik', $data->pemilik)}}">
                    @error('pemilik')
                    <div id="pemilik" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                @else
                <div class="mb-3">
                    <label for="device" class="form-label">Device <span class="text-danger">*</span></label>
                    <input type="text" name="device" disabled class="form-control @error('device') is-invalid @enderror" id="pemilik" value="{{old('device', $data->device_categories->name)}}">
                    @error('device')
                    <div id="device" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                @endif

                @if(!empty($data->serialNumber))
                <div class="mb-3">
                    <label for="serialNumber" class="form-label">Serial Number <span class="text-danger">(optional)</span></label>
                    <select class="serialNumber" name="serialNumber[]" multiple="multiple" style="width: 100%;">
                        @foreach($data->serialNumber as $sn)
                        <option value="{{$sn}}" @if(count($data->serialNumber) == 1) selected @endif>{{$sn}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                @if(auth()->user()->categories()->pluck('id')[0] != 1)
                <div class="mb-3">
                    <label for="unitKeluar" class="form-label">Unit <span class="text-danger">*</span></label>
                    <input type="number" name="unitKeluar" class="form-control  @error('unitKeluar') is-invalid @enderror" value="{{old('unitKeluar')}}" id="unitKeluar" placeholder="unit / meter">
@if(!empty($data->serialNumber))
<div id="passwordHelpBlock" class="form-text">
  jika tidak diisi maka unit di isi berdasarkan serial number yang di pilih
</div>
@endif
                    @error('unitKeluar')
                    <div id="unitKeluar" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                @endif






                <div class="mb-3">
                    <label for="penanggungJawab" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                    <select id="mySelect2" class="form-select" name="penangungJawab_id" style="width: 100%;">
                        <option>Select Option</option>
                        @foreach($penangungJawabs as $pnj)
                        <option value={{$pnj->id}}>{{$pnj->name}}</option>
                        @endforeach
                    </select>

                    @error('penanggungJawab')
                    <div id="penanggungJawab" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>

            </div>


            <div class="col">
                <div class="mb-3">
                    <label for="tanggla" class="form-label">Tanggal Keluar<span class="text-danger">*</span></label>
                    <input type="date" name="tanggalKeluar" class="form-control @error('tanggalKeluar') is-invalid @enderror" id="tanggal" value="{{old('tanggalKeluar')}}">
                    @error('tanggalKeluar')
                    <div id="tanggalKeluar" class="invalid-feedback mb-3">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                @if(auth()->user()->categories()->pluck('id')[0] == 1)
                <div class="mb-3">
                    <label for="inputGambar" class="form-label">Input Image <span class="text-info">(optional)</span></label>
                    <img class="img-preview img-fluid rounded-2 mb-3 col-sm-5">
                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" id="inputGambar" onchange="previewImage()">
                    @error('gambar')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                @endif

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan <span class="text-info">(optional)</span></label>
                    <input type="hidden" name="keterangan" class="form-control  @error('keterangan') is-invalid @enderror" id="keterangan" value="{{old('keterangan', $data->keterangan)}}">
                    <trix-editor input="keterangan"></trix-editor>
                    @error('keterangan')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
        </div>












    </div>
    <div class=" modal-footer">

                <a class="btn btn-secondary" href="{{Route('barang-masuk.index')}}">Cancel</a>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </div>
</form>
@endsection
