<div class="modal" id="ModalInputSN" wire:ignore.self tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Serial Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="save">
@if($jenisBarang == 1)
				<div class="row">
					<div class="col">
                    			<button wire:click.prevent="plus({{$i}})" class="btn btn-outline-success" id="klm">+</button>
                    			<div class="mb-3 ">
                        		<label for="serialNumber" class="form-label d-block">Serial Number <span class="text-danger">*</span></label>
                        		@foreach($inputs as $index => $input)
                        			<div class="row mb-1">
				            <div class="@if($index != 0) col-10 @else col @endif">
				                <input htmlspecialchars type="text" class="form-control " placeholder="Serial Number" wire:model="serialNumber.{{ $index }}">

				            </div>
				            @if($index != 0)
				            <div class="col-2 text-end">

				                <button type="button" class="btn btn-warning" wire:click.prevent="remove({{$index}})">-</button>
				            </div>
				            @endif
				        </div>



				        @endforeach
					</div>
@endif
					<div class="col">
      						<div class="mb-3">
                        <div class="mb-4" wire:ignore>
                            <label for="keterangan" class="form-label">Keterangan <span class="text-info">(Optional)</span></label>
                            <input id="body" type="hidden" name="content" class="form-control keter  @error('keterangan') is-invalid @enderror" id="keterangan">
                            <trix-editor style=" background-color: white;" wire:model.debounce.365ms="keterangan" input="body" class="bdy"></trix-editor>
                            @error('keterangan')
                            <div id="body" class="invalid-feedback mb-3">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
					</div>
				 </div>
                    <button type="submit" class="btn btn-primary">Save</button>

                </form>
            </div>

        </div>
    </div>
</div>
