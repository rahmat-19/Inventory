@extends('layout.main')
@push('styls')
@livewireStyles
@endpush
@push('scripts')

@livewireScripts
@endpush
@section('container')
@livewire('barang-masuk-create')


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