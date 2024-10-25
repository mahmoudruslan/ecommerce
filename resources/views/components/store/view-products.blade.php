<div class="row">
    @php
    $lang = app()->getLocale();
@endphp
    @forelse ($products as $product)
        <!-- PRODUCT-->
        <div class="{{$class}}" id="product-block">
            <div class="product text-center">
                <div class="mb-3 position-relative">
                    <div class="badge text-white bg-"></div><a class="d-block"
                        href="{{ route('product.detail', $product->slug) }}"><img
                            class="img-fluid w-100"
                            src="{{ asset('storage/' . $product->media->first()->file_name) }}"
                            alt="..."></a>
                    <div class="product-overlay">
                        <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0">
                                <form action="">
                                    <a onclick="addToWishList({{ $product->id }}, 'http\://{{ request()->httpHost() }}/add-to-wishlist')"
                                        id="add-to-wishList-buttons"
                                        class="add-wishlist-btn{{$product->id}} btn btn-sm btn-outline-dark">
                                        <i class="{{\Cart::session('wishList')->getContent()->pluck('id')->contains($product->id) ? 'bold' : ''}} far fa-heart heart"></i>
                                    </a>
                                </form>
                            </li>
                            <li class="list-inline-item m-0 p-0">
                                <form action="">
                                    <a class="btn btn-sm btn-dark"
                                    {{-- status = quantity status --}}
                                        onclick="addToCart( {{json_encode(['status' => true])}} , {{ $product->id }}, 'http\://{{ request()->httpHost() }}/add-to-cart')">
                                        {{ __('Add to cart') }}
                                    </a>
                                </form>
                            </li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark"
                                    href="#productView{{ $product->slug }}" data-bs-toggle="modal"><i
                                        class="fas fa-expand"></i></a></li>
                        </ul>
                    </div>
                </div>
                <h6> <a class="reset-anchor"
                        href="{{ route('product.detail', $product->slug) }}">{{ $product['name_' . $lang] }}</a>
                </h6>
                <p class="small text-muted">LE. {{ $product->price }}</p>
            </div>
        </div>
        @include('store.layout.product_details_modal')
    @empty
        {{-- <div class="col-lg-4 col-sm-6"> --}}
        <div class="text-center">
            <h6> No products found</h6>
        </div>
        {{-- </div> --}}
    @endforelse
</div>