@extends('store.layout.master')
@section('content')
    <!-- HERO SECTION-->
    @php
        $lang = app()->getLocale();
    @endphp
    <section class="py-5 bg-light">
        <div class="container m-auto">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 mb-0">{{ __('Wishlist') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                            <li class="breadcrumb-item"><a class="text-dark"
                                    href="{{ route('customer.store') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Wishlist') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <h2 class="h5 text-uppercase mb-4">{{ __('Wishlist') }}</h2>
        <div class="row">
            <div class="col-lg-12 mb-4 mb-lg-0 wishlist-div-main">
                <!-- CART TABLE-->

                @foreach ($wishlist_items as $item)
                    <div id="wishlist-{{ $item->id }}" class="row align-items-center my-4 wishlist-row">
                        <div class="col-md-4 mb-2">
                            <div class="row align-items-center">
                                <div class="col-5">
                                    <a class="d-inline-block reset-anchor  animsition-link"
                                        href="product/{{ $item->associatedModel->slug }}">
                                        <img src="http://{{ request()->httpHost() }}/storage/{{ $item->associatedModel->firstMedia->file_name }}"
                                            alt="..." width="80" />
                                    </a>
                                </div>
                                <div class="col-7">
                                    <h6 class="d-inline-block ">
                                        <strong class="reset-anchor animsition-link">
                                            {{ $item->associatedModel['name_' . $lang] }}
                                        </strong>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <p class="mb-0">
                                <small>{{ getCurrency() }}</small><small
                                    id="price-{{ $item->id }}">{{ number_format($item->price, 2) }}</small>
                            </p>
                        </div>
                        <div class="col-md-3 mb-2">
                            <form id="cartForm" action="">
                                <input type="hidden" name="quantity" id="quantity" value="1">
                            <a href="javascript:void(0)" class="reset-anchor animsition-link" onclick="addToCart( {{json_encode(['status' => true])}} , {{ $item->id }}, 'http\://{{ request()->httpHost() }}/add-to-cart')">
                                {{ __('Add to cart') }}
                            </a>
                            </form>
                        </div>
                        <div class="col-md-1 mb-2">
                            <a href="javascript:void(0)" class="reset-anchor  animsition-link"
                                            onclick="removeFromWishList({{ $item->id }}, 'http\://{{ request()->httpHost() }}/remove-from-wishlist')">
                                            <i class="fas fa-trash-alt small text-muted"></i>
                                        </a>
                        </div>
                    </div>
                    <hr style="margin: 0%">
                @endforeach


                <!-- CART NAV-->
                <div class="bg-light px-4 py-3">
                    <div class="row align-items-center text-center">
                        <div class="col-md-6 mb-3 mb-md-0 text-md-start"><a class="btn btn-link p-0 text-dark btn-sm"
                                href="{{  strpos(url()->previous(), 'shopping') ? url()->previous() : route('customer.shopping') }}"><i class="fas fa-long-arrow-alt-left me-2">
                                </i>{{ __('Continue shopping') }}</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

