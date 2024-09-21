<div>
    <div class="row">
        <!-- PRODUCT-->
        @php
            $lang = app()->getLocale();
            
        @endphp
        @foreach ($featured_products as $product)
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="product text-center">
                    <div class="position-relative mb-3">
                        <div class="badge text-white bg-"></div>
                        <a class="d-block" href="{{ route('detail') }}">
                            <img class="img-fluid w-100" src="{{ asset('storage/' . $product->firstMedia['file_name']) }}"
                                alt="...">
                        </a>
                        <div class="product-overlay">
                            <ul class="mb-0 list-inline">
                                <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark"
                                        href="#!"><i class="far fa-heart"></i></a></li>
                                <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">
                                    {{__('Add to cart')}}</a></li>
                                <li class="list-inline-item me-0">
                                    <a class="btn btn-sm btn-outline-dark"
                                        href="#productView{{$product->id}}" data-bs-toggle="modal">
                                        <i class="fas fa-expand"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h6> <a class="reset-anchor" href="{{ route('detail') }}">{{$product['name_' . $lang]}}</a></h6>
                    <p class="small text-muted">LE. {{$product->price}}</p>
                </div>
            </div>
            @include('store.layout.modal')
        @endforeach
    </div>
</div>
