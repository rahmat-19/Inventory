@extends('layout.main')
@push('styles')
<style>
    .input-pnj {
        display: inline-block;
        width: 80%;
    }
</style>

@endpush

@section('container')

<div class="header-tag mb-5">
    <p class="fs-4">Tambah Penanggung Jawab</p>
</div>
<div class="form-input-pnj border-bottom mb-5 px-5 py-3">
    <form action="{{Route('penanggung-jawab.store')}}" method="post">
        @csrf
        @method('POST')
        <div class="mb-3 row ">
            <div class="col-sm-5 px-3 text-center @if(auth()->user()->role == 'admin') border-end @endif">
                <label for="inputName">Name</label>
                <input htmlspecialchars type="text" name="name" class="form-control input-pnj @error('name') is-invalid @enderror" id=" inputName" value="{{old('name')}}">
                @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            @if(auth()->user()->role == "admin")
            <div class="col-sm-3 px-3 text-center border-end">
                <label for="inputName">Posisi</label>
                <select placholder="Select option" class="form-select input-pnj @error('category_id') is-invalid @enderror" name="category_id" aria-label="Default select example" required>

                    @foreach($category as $category)
                    <option value={{$category->id}}>{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            @endif
            <div class=" col-sm-2">
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

        @foreach($pnj as $pnj)
        <li class="list-group-item py-2 px-4">
            <div class="row">
                <div class="col">
                    {{$pnj->name}}
                </div>

                @if(auth()->user()->role == 'admin')
                <div class="col">
                    {{$pnj->category->name}}
                </div>
                @endif


                <div class="col text-center">
                    <form method="post" action="{{route('penanggung-jawab.destroy',$pnj->id)}}">
                        @method('delete')
                        @csrf
                        <button type="submit" id="show_confirm" style="background-color: transparent; border: none;">
                            <i data-feather="user-x" stroke="red"></i>

                        </button>
                    </form>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>







@endsection