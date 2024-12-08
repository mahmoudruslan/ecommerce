@extends('store.layout.master')
@section('content')
    @php
        $lang = App::getLocale();
    @endphp
    <!-- HERO SECTION-->

    <section class="hero pb-3 bg-cover bg-center d-flex align-items-center"
        @if (Config::get('app.locale') == 'ar') style="background: url({{ asset('store/img/hero-banner-alt-ltr.jpg') }})"
        @else
            style="background: url({{ asset('store/img/hero-banner-alt-rtl.jpg') }})" @endif>
        <div class="container py-5">
            <div class="row px-4 px-lg-5">
                <div class="col-lg-6">
                    <p class="text-muted small text-uppercase mb-2">New Inspiration 2020</p>
                    <h1 class="h2 text-uppercase mb-3">20% off on new season</h1><a class="btn btn-dark"
                        href="{{ route('customer.shopping') }}">Browse collections</a>
                </div>
            </div>
        </div>
    </section>
    <!-- CATEGORIES SECTION-->

    <section class="pt-5">
        <header class="text-center">
            <p class="small text-muted small text-uppercase mb-1">Carefully created collections</p>
            <h2 class="h5 text-uppercase mb-4">Browse our categories</h2>
        </header>
        <div class="row">
            <div class="col-md-4"><a class="category-item"
                    href="{{ route('customer.shopping', ['category', $categories[0]->slug]) }}"><img class="img-fluid"
                        src="{{ asset('store/img/cat-img-1.jpg') }}" alt="" /><strong
                        class="category-item-title">{{ $categories[0]['name_' . $lang] }}</strong></a>
            </div>
            <div class="col-md-4"><a class="category-item mb-4"
                    href="{{ route('customer.shopping', ['category', $categories[1]->slug]) }}"><img class="img-fluid"
                        src="{{ asset('store/img/cat-img-2.jpg') }}" alt="" /><strong
                        class="category-item-title">{{ $categories[1]['name_' . $lang] }}</strong></a>
                <a class="category-item" href="{{ route('customer.shopping', ['category', $categories[2]->slug]) }}"><img
                        class="img-fluid" src="{{ asset('store/img/cat-img-3.jpg') }}" alt="" /><strong
                        class="category-item-title">{{ $categories[2]['name_' . $lang] }}</strong></a>
            </div>
            <div class="col-md-4"><a class="category-item"
                    href="{{ route('customer.shopping', ['category', $categories[3]->slug]) }}"><img class="img-fluid"
                        src="{{ asset('store/img/cat-img-4.jpg') }}" alt="" /><strong
                        class="category-item-title">{{ $categories[3]['name_' . $lang] }}</strong></a>
            </div>
        </div>

    </section>
    <!-- TRENDING PRODUCTS-->
    <section class="py-5">
        <header>
            <h2 class="h5 text-uppercase mb-4">{{ __('Featured products') }}</h2>
        </header>
        {{-- feachered products --}}
        <x-store.view-products :products="$featured_products" class="col-xl-3 col-lg-4 col-sm-6"></x-view-products>

    </section>
    <!-- SERVICES-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center gy-3">
                <div class="col-lg-4">
                    <div class="d-inline-block">
                        <div class="d-flex align-items-end">
                            <svg class="svg-icon svg-icon-big svg-icon-light">
                                <use xlink:href="#delivery-time-1"> </use>
                            </svg>
                            <div class="text-start ms-3">
                                <h6 class="text-uppercase mb-1">Free shipping</h6>
                                <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-inline-block">
                        <div class="d-flex align-items-end">
                            <svg class="svg-icon svg-icon-big svg-icon-light">
                                <use xlink:href="#helpline-24h-1"> </use>
                            </svg>
                            <div class="text-start ms-3">
                                <h6 class="text-uppercase mb-1">24 x 7 service</h6>
                                <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-inline-block">
                        <div class="d-flex align-items-end">
                            <svg class="svg-icon svg-icon-big svg-icon-light">
                                <use xlink:href="#label-tag-1"> </use>
                            </svg>
                            <div class="text-start ms-3">
                                <h6 class="text-uppercase mb-1">Festivaloffers</h6>
                                <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- NEWSLETTER-->
    <section class="py-5">
        <div class="container p-0">
            <div class="row gy-3">
                <div class="col-lg-6">
                    <h5 class="text-uppercase">Let's be friends!</h5>
                    <p class="text-sm text-muted mb-0">Nisi nisi tempor consequat laboris nisi.</p>
                </div>
                <div class="col-lg-6">
                    <form action="#">
                        <div class="input-group">
                            <input class="form-control form-control-lg" type="email"
                                placeholder="Enter your email address" aria-describedby="button-addon2">
                            <button class="btn btn-dark" id="button-addon2" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
