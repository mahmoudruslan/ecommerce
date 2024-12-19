@extends('store.layout.master')
@section('content')
@section('style')
    <style>
        iframe {
        width: 100%;
    }
    </style>
@endsection

    <section class="py-5">
        @php
            $lang = app()->getLocale();
        @endphp
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6">
                    <!-- PRODUCT SLIDER-->
                    <div class="row m-sm-0">
                        <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0 px-xl-2">
                            <div class="swiper product-slider-thumbs">
                                <div class="swiper-wrapper">
                                    @foreach ($d_product->media as $media)
                                        <div class="swiper-slide h-auto swiper-thumb-item mb-3">
                                            <img class="w-100" src="{{ checkImg('storage/' . $media->file_name) }}"
                                                alt="{{ $d_product['name_' . $lang] }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-10 order-1 order-sm-2">
                            <div class="swiper product-slider">
                                <div class="swiper-wrapper">
                                    @foreach ($d_product->media as $media)
                                        <div class="swiper-slide h-auto">
                                            <a class="glightbox product-view"
                                                href="{{ checkImg('storage/' . $media->file_name) }}"
                                                data-gallery="gallery2" data-glightbox="Product item 1">
                                                <img class="img-fluid w-100"
                                                    src="{{ checkImg('storage/' . $media->file_name) }}"
                                                    alt="{{ $d_product['name_' . $lang] }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PRODUCT DETAILS-->
                <div class="col-lg-6">
                    <a href="#productReview{{ $d_product->slug }}" data-bs-toggle="modal">
                        <ul class="list-inline mb-2 text-sm d-inline-block">
                            @for ($i = 0; $i < 5; $i++)
                                <li class="list-inline-item m-0"><i
                                        class="{{ round($d_product->reviews_avg_rating) > $i ? 'fas' : 'far' }} fa-star small text-warning"></i>
                                </li>
                            @endfor
                        </ul>
                    </a>
                    @include('store.modals.review')
                    <h1>{{ $d_product['name_' . $lang] }}</h1>
                    {{ getCurrency() }}<p class="text-muted lead">{{ number_format($d_product->price, 2) }}</p>
                    <p class="text-sm mb-4">{!! $d_product['description_' . $lang] !!}</p>
                    <div class="row align-items-stretch mb-4">
                        <div class="col-sm-5 pr-sm-0">
                            <form id="cartForm" action="">
                                <div
                                    class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white">
                                    <span class="small text-uppercase text-gray mr-4 no-select">{{ __('Quantity') }}</span>
                                    <div class="quantity">
                                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                        <input type="hidden" class="available_quantity" id="available_quantity"
                                            value="{{ $d_product->quantity }}">
                                        <input type="hidden" id="product_id" value="{{ $d_product->id }}">
                                        {{-- decreas --}}
                                        <span class="dec-btn p-0"><i
                                                class="px-2 fas fa-caret-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i></span>

                                        <input id="quantity" name="quantity" value="1" style="background-color: #ffff"
                                            readonly type="text" class="form-control border-0 shadow-0 p-0">

                                        {{-- increas --}}
                                        <span class="inc-btn p-0"><i
                                                class="px-2 fas fa-caret-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i></span>

                                    </div>
                                </div>
                            </form>
                        </div>
                        @php
                            $product = $d_product;
                        @endphp
                        <div class="col-sm-3 pl-sm-0">
                             <a onclick="resetQuantity({{ $product->id }})" href="#addToCart{{ $d_product->id }}"
                                    data-bs-toggle="modal" class="btn btn-sm btn-dark">
                                    {{ __('Add to cart') }}
                                </a>
                        </div>
                        @include('store.modals.add_to_cart')
                    </div>
                    <form id="cartForm" action="">
                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                        <a class="add-wishlist-btn{{ $d_product->id }}  text-dark p-0 mb-4 d-inline-block"
                            href="javascript:void();"
                            onclick="addToWishList({{ $d_product->id }}, 'http\://{{ request()->httpHost() }}/add-to-wishlist')">
                            <i
                                class="{{ \Cart::session('wishList')->getContent()->pluck('id')->contains($d_product->id)? 'bold': '' }} far fa-heart me-2"></i>
                            {{ __('Add to wish list') }}
                        </a>
                    </form>
                    <br>
                    <ul class="list-unstyled small d-inline-block">
                        <li class="px-3 py-2 mb-1 bg-white text-muted">
                            <strong class="text-uppercase text-dark">{{ __('Category') }}:</strong>
                            <a class="reset-anchor ms-2"
                                href="{{ route('customer.shopping', ['category', $d_product->category->slug]) }}">
                                {{ $d_product->category['name_' . $lang] }}
                            </a>
                        </li>
                        <li class="px-3 py-2 mb-1 bg-white text-muted">
                            <strong class="text-uppercase text-dark">{{ __('Tags') }}:</strong>
                            @foreach ($d_product->tags as $tag)
                                <a class="reset-anchor ms-2"
                                    href="{{ route('customer.shopping', ['tag', $tag->slug]) }}">{{ $tag['name_' . $lang] }}</a>
                                |
                            @endforeach
                        </li>
                        @if ($d_product->video_link)
                        <li class="px-3 py-2 mb-1 bg-white text-muted">
                            <strong class="text-uppercase text-dark">{{ __('Explainer video') }}:</strong>
                                <a target="_blank" class="reset-anchor ms-2"
                                    href="{{ $d_product->video_link }}">{{ __('Watch on YouTube') }}
                                </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- DETAILS TABS-->
            <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link text-uppercase active" id="description-tab" data-bs-toggle="tab"
                        href="#description" role="tab" aria-controls="description"
                        aria-selected="true">{{ __('Description') }}</a></li>
                <li class="nav-item"><a class="nav-link text-uppercase" id="reviews-tab" data-bs-toggle="tab"
                        href="#reviews" role="tab" aria-controls="reviews"
                        aria-selected="false">{{ __('Reviews') }}</a></li>
                <li class="nav-item"><a class="nav-link text-uppercase" id="youtube-tab" data-bs-toggle="tab"
                        href="#youtube" role="tab" aria-controls="youtube"
                        aria-selected="false">{{ __('Explainer video') }}</a></li>
            </ul>
            <div class="tab-content mb-5" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel"
                    aria-labelledby="description-tab">
                    <div class="p-4 p-lg-5 bg-white">
                        <h6 class="text-uppercase">{{ __('Product description') }} </h6>
                        <p class="text-muted text-sm mb-0">{!! $d_product['description_' . $lang] !!}</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <div class="p-4 p-lg-5 bg-white">
                        <div class="row">
                            <div class="col-lg-8">
                                @forelse ($d_product->reviews->reverse() as $review)
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0"><img class="rounded-circle"
                                                src="{{ $review->user_id ? asset('storage/' . $review->user->image) : asset('storage/images/users/avatar.png') }}"
                                                alt="" width="50" />
                                        </div>
                                        <div class="ms-3 flex-shrink-1">
                                            <h6 class="mb-0 text-uppercase">{{ $review->fullName }}</h6>
                                            <p class="small text-muted mb-0 text-uppercase">
                                                {{ $review->created_at->format('Y-m-d') }}</p>
                                            <ul class="list-inline mb-1 text-xs">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <li class="list-inline-item m-0"><i
                                                            class="{{ round($review->rating) > $i ? 'fas' : 'far' }} fa-star text-warning"></i>
                                                    </li>
                                                @endfor
                                                {{-- <li class="list-inline-item m-0"><i class="fas fa-star-half-alt text-warning"></i></li> --}}
                                            </ul>
                                            <p class="text-sm mb-0 text-muted">{!! $review->body !!}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="d-flex mb-3">{{ __('Not found reviews') }}</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="youtube" role="tabpanel" aria-labelledby="youtube-tab">
                    <div class="p-4 p-lg-5 bg-white">
                        <div class="row">
                            <div class="col-lg-8">
                                @if ($d_product->iframe)
                                    {!! $d_product->iframe !!}
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- RELATED PRODUCTS-->
            <h2 class="h5 text-uppercase mb-4">{{ __('Related products') }}</h2>

            <x-store.view-products :products="$related_products" class="col-xl-3 col-lg-4 col-sm-6"></x-view-products>
        </div>
    </section>
@endsection
