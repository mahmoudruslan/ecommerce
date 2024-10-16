<div class="modal fade" id="productView{{$product->slug}}" tabindex="-1" role="dialog" aria-hidden="true">

    @php
        $lang = app()->getLocale();
    @endphp
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content overflow-hidden border-0">
            <div class="modal-body p-0">
                <div class="row align-items-stretch">
                    <div class="col-lg-6">
                        <div class="p-4 my-md-4">
                            <ul class="list-inline mb-2">
                                @for ($i = 0; $i < 5; $i++)
                                    <li class="list-inline-item m-0"><i
                                            class="{{ round($product->reviews_avg_rating) > $i ? 'fas' : 'far' }} fa-star small text-warning"></i>
                                @endfor
                                </li>
                            </ul>
                            <h2 class="h4">{{ $product['name_' . $lang] }}</h2>
                            <p class="text-muted">LE. {{ $product->price }}</p>
                            <p class="text-sm mb-4">{{ $product['description_' . $lang] }}</p>
                            <form id="cartForm" action="">
                                <div class="row align-items-stretch mb-4 gx-0">
                                    <div class="col-sm-5">
                                        <a class="btn btn-dark btn-sm w-100 h-100 d-flex align-items-center justify-content-center px-0"
                                        {{-- status = quantity status --}}
                                            onclick="addToCart( {{json_encode(['status' => false])}} ,{{ $product->id }}, 'http\://{{ request()->httpHost() }}/add-to-cart')">
                                            {{ __('Add to cart') }}
                                        </a>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="border d-flex align-items-center justify-content-between py-1 px-3">
                                            <span
                                                class="small text-uppercase text-gray mr-4 no-select">{{ __('Quantity') }}</span>
                                            
                                            <div class="quantity">
                                                <input type="hidden" class="available_quantity" id="available_quantity"
                                                value="{{ $product->quantity }}">
                                                <input type="hidden" id="product_id"
                                                value="{{ $product->id }}">
                                                {{-- decreas --}}
                                                <span class="dec-btn p-0"><i class="fas fa-caret-left"></i></span>

                                                <input id="quantity" name="quantity" value="1"
                                                    style="background-color: #ffff" readonly type="text"
                                                    class="form-control border-0 shadow-0 p-0">

                                                {{-- increas --}}
                                                <span class="inc-btn p-0"><i class="fas fa-caret-right"></i></span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="">
                                <a class="add-wishlist-btn btn btn-link text-dark text-decoration-none p-0"
                                    onclick="addToWishList({{ $product->id }}, 'http\://{{ request()->httpHost() }}/add-to-wishlist')">
                                    <i class="{{\Cart::session('wishList')->getContent()->pluck('id')->contains($product->id) ? 'bold' : ''}} far fa-heart me-2"></i>
                                    {{ __('Add to wish list') }}
                                </a>
                            </form>
                        </div>
                    </div>
                    <button class="btn-close p-4 position-absolute top-0 end-0 z-index-20 shadow-0" type="button"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="col-lg-6 p-lg-0">
                        @foreach ($product->media as $media)
                            @if ($loop->first)
                                <a class="glightbox product-view d-block h-100 bg-cover bg-center"
                                    style="background: url({{ asset('storage/' . $media->file_name) }})"
                                    href="{{ asset('storage/' . $media->file_name) }}"
                                    data-gallery="gallery{{ $product->id }}" data-glightbox="Red digital smartwatch">
                                </a>
                            @else
                                <a class="glightbox d-none" href="{{ asset('storage/' . $media->file_name) }}"
                                    data-gallery="gallery{{ $product->id }}" data-glightbox="Red digital smartwatch">
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                {{-- @endif --}}
            </div>
        </div>
    </div>
</div>

