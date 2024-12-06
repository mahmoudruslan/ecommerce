<div class="offcanvas offcanvas-{{ app()->getLocale() == 'en' ? 'end' : 'start' }}" tabindex="-1"
    id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{ __('Cart') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        {{-- addToCart() in cart.js --}}
    </div>
    <div class="bg-white bottom-0 shadow-top">
        <div class="row p-3">
            <div class="col-md-6">
                <p class="text-muted">
                    {{ __('Subtotal') }}:
                </p>
            </div>
            <div class="col-md-6">
                <p id="cart-subtotal" class="text-muted">
                </p>
            </div>
            <div class="col-md-12">
                <a href="{{ route('customer.cart') }}" class="btn w-100 btn-outline-dark mb-3">
                    {{ __('View Cart') }}
                </a>
            </div>
            <br>
            <div class="col-md-12">
                <a href="{{ route('customer.checkout') }}" class="btn w-100 btn-dark">
                    {{ __('Checkout') }}
                </a>
            </div>
        </div>
    </div>
    <script>
        let Quantity = "{{__('Quantity')}}";
    </script>
</div>
