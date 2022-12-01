@extends('layout.main')

@section('container')
<form action="{{Route('barang-keluar.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label for="SerialNumber" class="form-label">Serial Number</label>
            <input type="text" value="{{old('serialNumber')}}" name=" serialNumber" class="form-control @error('serialNumber') is-invalid @enderror" id="SerialNumber" required>
            @error('serialNumber')
            <div id="serialNumber" class="invalid-feedback mb-3">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="Device" class="form-label">Device</label>
            <input type="text" name="device" class="form-control  @error('device') is-invalid @enderror" value="{{old('device')}}" id="Device">
            @error('device')
            <div id="device" class="invalid-feedback mb-3">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggla" class="form-label">Tanggal Keluar</label>
            <input type="date" name="tanggalKeluar" class="form-control @error('tanggalKeluar') is-invalid @enderror" id="tanggal" value="{{old('tanggalKeluar')}}">
            @error('tanggalKeluar')
            <div id="tanggalKeluar" class="invalid-feedback mb-3">
                {{$message}}
            </div>
            @enderror
        </div>


        <div class=" mb-3">
            <label for="category_id" class="form-label">Pemilik</label>
            <select class="form-select" aria-label="Default select example" name="category_id" id="category_id">
                <option selected disabled class="blockquote-footer">Open this select menu</option>

                @foreach($categorys as $category)
                @if(old('category_id') == $category->id)
                <option value="{{$category->id}}" selected>{{$category->name}}</option>
                @else
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="inputGambar" class="form-label">Input Image</label>
            <img class="img-preview img-fluid rounded-2 mb-3 col-sm-5">
            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" id="inputGambar" onchange="previewImage()">
            @error('gambar')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="hidden" name="keterangan" class="form-control  @error('keterangan') is-invalid @enderror" id="keterangan" value="{{old('keterangan')}}">
            <trix-editor input="keterangan"></trix-editor>
            @error('keterangan')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

    </div>
    <div class=" modal-footer">

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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