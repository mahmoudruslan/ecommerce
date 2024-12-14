<div class="row">
    @php
        $lang = app()->getLocale();
    @endphp
    @forelse ($products as $product)
        <!-- PRODUCT-->
        <div class="{{ $class }}" id="product-block">
            <div class="product text-center">
                <div class="mb-3 position-relative">
                    {{-- mobile devices --}}
                    <div class="product-options-btn">
                        <div class="wishlist-icon">
                            <form action="">
                                <a onclick="addToWishList({{ $product->id }}, 'http\://{{ request()->httpHost() }}/add-to-wishlist')"
                                    id="add-to-wishList-buttons"
                                    class="w-100 add-wishlist-btn{{ $product->id }} btn btn-sm">
                                    <i
                                        class="{{ \Cart::session('wishList')->getContent()->pluck('id')->contains($product->id)? 'bold': '' }} far fa-heart heart">
                                    </i>
                                </a>
                            </form>
                        </div>
                        <div class="modal-icon">
                            <a class="w-100 btn btn-sm" href="#productView{{ $product->slug }}" data-bs-toggle="modal">
                                <i class="fas fa-expand"></i>
                            </a>
                        </div>
                    </div>
                    {{-- end mobile devices --}}
                    <div class="badge text-white bg-">
                    </div>
                    <a class="d-block" href="{{ route('customer.product.detail', $product->slug) }}">
                        <img class="w-100" src="{{ checkImg('storage/' . $product->media->first()->file_name) }}"
                            alt="...">
                    </a>
                    <div class="product-overlay">
                        <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0">
                                {{-- <form action=""> --}}
                                    <a onclick="addToWishList({{ $product->id }}, 'http\://{{ request()->httpHost() }}/add-to-wishlist')"
                                        id="add-to-wishList-buttons"
                                        class="add-wishlist-btn{{ $product->id }} btn btn-sm btn-outline-dark">
                                        <i
                                            class="{{ \Cart::session('wishList')->getContent()->pluck('id')->contains($product->id)? 'bold': '' }} far fa-heart heart"></i>
                                    </a>
                                {{-- </form> --}}
                            </li>
                            <li class="list-inline-item m-0 p-0">
                                {{-- <form action=""> --}}
                                <a href="#addToCart{{ $product->slug }}" data-bs-toggle="modal"
                                    class="btn btn-sm btn-dark" {{-- status = quantity status --}}>
                                    {{ __('Add to cart') }}
                                </a>
                                {{-- </form> --}}
                            </li>
                            <li class="list-inline-item mr-0">
                                <a class="btn btn-sm btn-outline-dark" href="#productView{{ $product->slug }}"
                                    data-bs-toggle="modal">
                                    <i class="fas fa-expand"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @include('store.modals.add_to_cart')
                <h6>
                    <a class="reset-anchor"
                        href="{{ route('customer.product.detail', $product->slug) }}">{{ $product['name_' . $lang] }}
                    </a>
                </h6>
                <p class="small price-mb text-muted d-inline-block">
                    {{ getCurrency() . number_format($product->price, 2) }}
                </p>
                {{-- mobile screens --}}
                <div class="mobile-devices mb-2">
                    <form action="">
                        <a class="btn custom-btn-sm btn-dark" {{-- status = quantity status --}}
                            onclick="addToCart( {{ json_encode(['status' => true]) }} , {{ $product->id }}, 'http\://{{ request()->httpHost() }}/add-to-cart')">
                            {{ __('Add to cart') }}
                        </a>
                    </form>
                </div>


                {{-- end --}}

            </div>
        </div>
        @include('store.modals.product_details_modal')
    @empty
        {{-- <div class="col-lg-4 col-sm-6"> --}}
        <div class="text-center">
            <h6> No products found</h6>
        </div>
        {{-- </div> --}}
    @endforelse
</div>
@section('js')
    <script>
        // const sizeBoxes = document.querySelectorAll('.size-box');
        // const selectedSizeLabel = document.querySelector('.selected-size');

        // sizeBoxes.forEach((box) => {
        //     box.addEventListener('click', function() {
        //         sizeBoxes.forEach((b) => b.classList.remove('selected'));
        //         this.classList.add('selected');
        //         selectedSizeLabel.innerHTML = this.textContent;
        //     });
        // });



        document.addEventListener('DOMContentLoaded', () => {
    const sizeBoxes = document.querySelectorAll('.size-box');

    sizeBoxes.forEach((box) => {
        box.addEventListener('click', function () {
            const siblingBoxes = this.closest('.row').querySelectorAll('.size-box');
            siblingBoxes.forEach((b) => b.classList.remove('bg-primary'));
            this.classList.add('bg-primary');
            const targetId = this.dataset.target;
            const selectedSizeLabel = document.getElementById(targetId);
            selectedSizeLabel.textContent = this.textContent.trim();
        });
    });
});




    </script>





@endsection
