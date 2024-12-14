<div class="modal fade" id="addToCart{{ $product->slug }}" tabindex="-1" role="dialog">
    <div style="max-width: 30%;" class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0">
            <div class="modal-header p-0">
                <button class="btn-close p-4 top-0 end-0 z-index-20" type="button" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="reviewForm" action="" method="POST">
                @csrf
                <div class="modal-body text-start p-4">
                    <div class="align-items-stretch">
                        <h2 class="h4">{{ $product['name_' . $lang] }}</h2>
                        <p class="text-muted">{{ getCurrency() . number_format($product->price, 2) }}</p>
                        <div>
                            <label class="form-label">{{ __('Size') }} :</label>
                            <span class="selected-size fw-bold"
                                id="selected-size-{{ $product->id }}">{{ $product->sizes()->first()->name }}</span>
                        </div>
                        <div class="row m-auto mb-2">
                            @foreach ($product->sizes as $size)
                                <div class="col-2 p-1">
                                    <div class="{{ $loop->first ? 'bg-primary' : '' }} w-100 size-box rounded border p-1 text-center"
                                        data-size="{{ $size->name }}" data-target="selected-size-{{ $product->id }}">
                                        <small>{{ $size->name }}</small>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                        <div class="mb-4 g-3">
                            <form id="cartForm" action="">
                                <input type="hidden" class="available_quantity" id="available_quantity"
                                    value="{{ $product->quantity }}">
                                <input type="hidden" id="product_id" value="{{ $product->id }}">
                                <div class="col-sm-8 mb-2">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div
                                                class="border d-flex align-items-center justify-content-between py-1 px-3 h-100">
                                                <span
                                                    class="small text-gray mr-4 no-select">{{ __('Quantity') }}</span>
                                                <div class="quantity">
                                                    {{-- decreas --}}
                                                    <span class="dec-btn p-0"><i
                                                            class="px-2 fas fa-caret-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i></span>

                                                    <input id="quantity" name="quantity" value="1"
                                                        style="background-color: #ffff" readonly type="text"
                                                        class="form-control border-0 shadow-0 p-0">

                                                    {{-- increas --}}
                                                    <span class="inc-btn p-0"><i
                                                            class="px-2 fas fa-caret-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <a onclick="addToWishList({{ $product->id }}, 'http\://{{ request()->httpHost() }}/add-to-wishlist')"
                                                id="add-to-wishList-buttons"
                                                class="add-wishlist-btn{{ $product->id }} btn btn-outline-dark border">
                                                <i
                                                    class="{{ \Cart::session('wishList')->getContent()->pluck('id')->contains($product->id)? 'bold': '' }} far fa-heart heart"></i>
                                            </a>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-sm-12 m-auto">
                                    <a class="btn btn-dark btn-sm w-100 mb-2" {{-- status = quantity status --}}
                                        onclick="newAddToCart( {{ json_encode(['status' => false]) }} ,{{ $product->id }}, 'http\://{{ request()->httpHost() }}/add-to-cart')">
                                        {{ __('Add to cart') }}
                                    </a>
                                </div>
                            </form>
                            <div class="col-sm-12 m-auto">
                                <a href="{{ route('customer.checkout') }}" class="w-100 btn btn-outline-dark">
                                    {{ __('Checkout') }}
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
