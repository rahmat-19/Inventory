@extends('layout.main')
@push('styles')
<!-- <style>
    .input-pnj {
        display: inline-block;
        width: 80%;
    }
</style> -->

@endpush

@section('container')

<div class="header-tag mb-5">
    <p class="fs-4">Tambah Device</p>
</div>
<div class="form-input-pnj border-bottom mb-5 px-5 py-3">
    <form action="{{Route('device.store')}}" method="post">
        @csrf
        @method('POST')
        <div class="mb-3 row ">
            <div class="col-sm-5 px-3 text-center  border-end ">
                <label for="inputName">Name</label>
                <input name="name" class="form-control  @error('name') is-invalid @enderror" type="text" id=" inputName" placeholder="Default input" value="{{old('name')}}" aria-label="default input example">

                @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="col-sm-3 px-3 text-center border-end">
                <label for="inputName">Jenis</label>
                <select class="form-select @error('jenis_id') is-invalid @enderror" name="jenis_id" aria-label="Default select example">
                    <option selected>Open Select</option>
                    @foreach($jenis as $jns)
                    <option value={{$jns->id}}>{{$jns->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="align-middle col-sm-2">
                <button type="submit" class="btn btn-warning">
                    <i data-feather="user-plus"></i>
                    Add
                </button>
            </div>
        </div>
    </form>
</div>



<div class="pnj-list px-3">
    <ul class="list-group">
        <li class="list-group-item active" aria-current="true">Daftar Penanggung Jawab</li>

        @foreach($datas as $data)
        <li class="list-group-item py-2 px-4">
            <div class="row">
                <div class="col">
                    {{$data->name}}
                </div>

                <div class="col">
                    {{$data->jenis_devices->name}}
                </div>


                <div class="col text-center">
                    <form method="post" action="{{route('device.destroy',$data->id)}}">
		       @csrf
		       @method('DELETE')
                       <button type="submit" style="background-color: transparent; border: none;">
                            <i data-feather="trash-2" stroke="red"></i>

                        </button>
                    </form>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>










@endsection
