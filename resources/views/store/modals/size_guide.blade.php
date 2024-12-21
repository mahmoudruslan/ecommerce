<div class="modal fade" id="sizeGuide{{ $product->id }}" tabindex="-1" role="dialog">
    <div style="max-width: 400px;" class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0">
            <div class="modal-header p-0">
                <button class="btn-close p-4 top-0 end-0 z-index-20" type="button" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
                <div class="modal-body text-start p-4">
                    <img style="width: 100%" src="{{asset('storage/'. $product->size_guide)}}">
                </div>
        </div>
    </div>
</div>
