@extends('layout.main')

@push('styles')
<link rel="stylesheet" href="/css/search.css">

@livewireStyles
@endpush
@push('scripts')
@livewireScripts

<script>
    $(document).on('click', '.open_modal_show', function() {
        let url = $(this).data('url');
        let tour_id = $(this).val();
        $.get(url, function(data) {
            $('#keterangan').html(data.keterangan);
            $('#waktu').text(new Date(data.tanggalMasuk).toDateString());
            if (data.type) {
                $('#type').text(data.type)
            }
            if (data.pemilik) {
                $('#pemilik').text(`Pemilik : ${data.pemilik}`)
            }
            $('#unit').text(data.unit);
            // $('#pnj').text(data.unit);
            $('#device').text(data.device);
            $('#merek').text(data.merek);
            if (data.gambar) {

                $('#image-bar').attr('src', "{{ Storage::url('public/ImagesBarang/') }}" + data.gambar);
            } else {
                $('#image-bar').attr('src', "images/imagesNotFound.jpg");

            }
            $('#modalShow').modal('show');
        })
    });



//    window.addEventListener('openmodal', event => {
//        $("#ModalUpdate").modal('show');

//    })
//    window.addEventListener('closemodal', event => {
//        $("#ModalUpdate").modal('hide');

//    })



    window.addEventListener('openmodaledit', event => {
        $("#ModalEditInputSN").modal('show');

    })
    window.addEventListener('closemodaledit', event => {
        $("#ModalEditInputSN").modal('hide');

    })
</script>

@endpush

@section('container')


<!-- Modal -->
<div class="modal fade" id="modalShow" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><strong id="device"></strong> : <span id="merek"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fs-5" id="type"></p>
                <div class="card mb-3 border-0" style="max-width: 540px;">
                    <div class="row g-0">
                        <img src="" id="image-bar" class="card-img-top rounded mx-auto d-block" style="width:24rem;">
                        <div>
                            <div class="card-body">
                                <p class="fs-5" id="pemilik"></p>
                                <p class="fs-5" id="pnj"></p>
                                <p class="card-text"><small class="text-muted" id="waktu"></small></p>
                                <h5 class="mb-4">Jumlah : <strong id="unit"></strong> unit</h5>
                                <p class="card-text" id="keterangan"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="mb-4 ">
        <!-- background: linear-gradient(0deg, rgba(133,108,0,1) 0%, rgba(142,115,0,1) 29%, rgba(177,145,0,1) 100%) -->
        <a href="{{Route('barang-masuk.create')}}" class="btn add-btn ">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather me-2 feather-upload-cloud">
                <polyline points="16 16 12 12 8 16"></polyline>
                <line x1="12" y1="12" x2="12" y2="21"></line>
                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path>
                <polyline points="16 16 12 12 8 16"></polyline>
            </svg>
            Tambah Barang</a>
    </div>



    @livewire('barang-masuk-search')

</div>


@endsection
