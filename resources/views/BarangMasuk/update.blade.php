@extends('layout.main')
@push('styls')
@livewireStyles
@endpush
@push('scripts')

@livewireScripts
@endpush
@section('container')

@livewire('barang-masuk-update', ['datas' => $datas])

@endsection
