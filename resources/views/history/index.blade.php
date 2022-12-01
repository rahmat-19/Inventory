@extends('layout.main')
@section('container')
@push('styles')
<link rel="stylesheet" href="/css/search.css">

@livewireStyles
@endpush

@push('scripts')
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
</script>
@livewireScripts
@endpush

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
@livewire('history-barang-masuk')
@endsection