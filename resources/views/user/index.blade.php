@extends('layout.main')

@push('styles')

@livewireStyles
@endpush
@push('scripts')
@livewireScripts
@endpush

@section('container')


<h1>User List</h1>
<hr>

<div class="container">
    <div class="mb-4">

        <a href="{{Route('user.create')}}" class="btn btn-success ">+ Tambah User</a>
    </div>



    @livewire('user-search')

</div>


@endsection