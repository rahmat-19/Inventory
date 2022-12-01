@extends('layout.main')

@section('container')
<form action="{{Route('barang-keluar.update', $data->serialNumber)}}" method="post" enctype="multipart/form-data">
    @method('put')
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label for="SerialNumber" class="form-label">Serial Number</label>
            <input type="text" value="{{old('serialNumber', $data->serialNumber)}}" name=" serialNumber" class="form-control @error('serialNumber') is-invalid @enderror" id="SerialNumber" required>
            @error('serialNumber')
            <div id="serialNumber" class="invalid-feedback mb-3">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="Device" class="form-label">Device</label>
            <input type="text" name="device" value="{{old('device', $data->device)}}" class="form-control @error('device') is-invalid @enderror" id="Device">
            @error('device')
            <div id="device" class="invalid-feedback mb-3">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Pemilik</label>
            <select class="form-select  @error('category_id') is-invalid @enderror" aria-label="Default select example" name="category_id" id="category_id">
                <option selected disabled class="blockquote-footer">Open this select menu</option>
                @foreach($categoris as $category)
                @if(old('category_id', $data->category_id) == $category->id)
                <option value="{{$category->id}}" selected>{{$category->name}}</option>
                @else
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggl" class="form-label">Tanggal Keluar</label>
            <input type="date" name="tanggalKeluar" class="form-control @error('tanggalKeluar') is-invalid @enderror" id="tanggal" value="{{old('tanggalKeluar', $data->tanggalKeluar )}}">
            @error('tanggalKeluar')
            <div id="tanggalKeluar " class="invalid-feedback mb-3">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputGambar" class="form-label ">Input Image</label>
            @if($data->gambar)
            <img src="{{ Storage::url('public/ImagesBarangKeluar/').$data->gambar }}" class="img-preview img-fluid rounded-2 mb-3 col-sm-5 d-block">
            @else
            <img class="img-preview img-fluid rounded-2 mb-3 col-sm-5">
            @endif
            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" id="inputGambar" onchange="previewImage()">
            @error('gambar')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="hidden" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" value="{{old('keterangan', $data->keterangan)}}">
            <trix-editor input="keterangan"></trix-editor>
            @error('keterangan')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

    </div>
    <div class="modal-footer">
        <a href="{{Route('barang-keluar.index')}}" class="btn btn-secondary">Close</a>
        &nbsp
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>

<script>
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
@endsection