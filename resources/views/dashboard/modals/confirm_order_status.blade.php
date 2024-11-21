<div class="modal fade" id="orderStatusModal{{$order->id}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Warning') }}</h5>
                <button class="close close-l" type="button" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to change the order status?') }}</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button"
                        data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button class="btn btn-danger" type="submit">{{ __('Update') }}</button>
                </div>
        </div>
    </div>
</div>
