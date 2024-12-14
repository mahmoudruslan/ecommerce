<div class="offcanvas offcanvas-{{ app()->getLocale() == 'en' ? 'end' : 'start' }}" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{ __('Cart') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @foreach (\Cart::session('cart')->getContent()->reverse() as $item)
            <div id="cart-bar-{{ $item->id }}" class="row align-items-center cart-bar-row">
                <div class="col-md-4 my-4">
                    <a class="reset-anchor d-block animsition-link" href="product/{{ $item->associatedModel->slug }}">
                        <img src="http://{{ request()->httpHost() }}/storage/{{ $item->associatedModel->firstMedia->file_name }}"
                            alt="..." width="80" />
                    </a>
                </div>
                <div class="col-md-7">
                    <h6>
                        <strong class="reset-anchor animsition-link">
                            {{ $item->associatedModel['name_' . $lang] }}
                        </strong>
                    </h6>
                    <p class="text-muted">
                        <small>{{ getCurrency() }}</small><small
                            id="price-{{ $item->id }}">{{ number_format($item->price, 2) }}</small>
                    </p>
                    <form id="cartForm{{ $item->id }}" action="">
                        <input type="hidden" class="available_quantity" id="available_quantity"
                            value="{{ $item->associatedModel->quantity }}">
                        <div class="w-75 border d-flex align-items-center justify-content-between px-3"><span
                                class="small text-uppercase text-gray headings-font-family">{{ __('Quantity') }}</span>
                            <div class="quantity">
                                <span
                                    onclick="decreaseQuantity({{ $item->id }}, 'http\://{{ request()->httpHost() }}/cart-decrease-quantity')"
                                    class="decrease p-0">
                                    <i class="fas fa-caret-{{ $lang === 'ar' ? 'right' : 'left' }}"></i></span>
                                <input readonly name="quantity" id="quantity-{{ $item->id }}"
                                    class="bg-white form-control form-control-sm border-0 shadow-0 p-0" type="text"
                                    value="{{ $item->quantity }}" />
                                <span
                                    onclick="increaseQuantity({{ $item->id }}, 'http\://{{ request()->httpHost() }}/cart-increase-quantity')"
                                    class="increase p-0"><i
                                        class="fas fa-caret-{{ $lang === 'ar' ? 'left' : 'right' }}"></i></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-1">
                    <a href="javascript:void(0)" class="reset-anchor"
                        onclick="removeFromCartBar({{ $item->id }}, 'http\://{{ request()->httpHost() }}/remove-from-cart')">
                        <i class="fas fa-trash-alt small text-muted"></i>
                    </a>
                </div>
                <hr style="margin: 0%">
            </div>
        @endforeach
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
        let Quantity = "{{ __('Quantity') }}";
    </script>
</div>
