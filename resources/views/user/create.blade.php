@extends('layout.main')

@section('container')
<form action="{{Route('user.store')}}" method="post">
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" value="{{old('username')}}" class="form-control @error('username') is-invalid @enderror" id=" username" required autocomplete="off">
            @error('username')
            <div id="username" class="invalid-feedback mb-3">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" value="{{old('password')}}" required name="password" class="form-control @error('password') is-invalid @enderror" id="password">
            @error('password')
            <div id="password" class="invalid-feedback mb-3">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="akses" class="form-label">Hak Akses</label>

            <select class="form-select" name="akses" style="width: 100%;" aria-label="Default select example">
                <option>Select Akses User</option>
                @foreach($categorys as $category)
                <option value={{$category->id}}>{{$category->name}}</option>
                @endforeach
            </select>

        </div>






    </div>
    <div class="modal-footer">
        <a href="{{Route('user.index')}}" class="btn btn-secondary">Kembali</a> &nbsp;
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>

</form>




@endsection