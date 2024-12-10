<div class="modal fade" id="buyAgain{{ $order->id }}" tabindex="-1" role="dialog" aria-hidden="true">

    @php
        $lang = app()->getLocale();
    @endphp
    <div class="modal-dialog">
        <div class="modal-content overflow-hidden border-0">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Buy again') }}</h5>
                <button class="btn-close p-4 position-absolute top-0 end-0 z-index-20 shadow-0" type="button"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-4">
                    {{ __('Do you want to replace the products in your shopping cart with the new order?') }}</p>
            </div>
            <div class="modal-footer">
                <a href="{{route('customer.order.buy.again.merge', $order->id)}}" class="btn btn-secondary" data-dismiss="modal">{{ __('Merge') }}</a>
                <a href="{{route('customer.order.buy.again.replace', $order->id)}}" class="btn btn-primary">{{ __('Replace') }}</a>
            </div>

        </div>
    </div>
</div>
