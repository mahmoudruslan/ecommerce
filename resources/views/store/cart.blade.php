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
                    <h1 class="h2 mb-0">{{ __('Cart') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                            <li class="breadcrumb-item"><a class="text-dark"
                                    href="{{ route('customer.store') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Cart') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <h2 class="h5 text-uppercase mb-4">{{ __('Shopping cart') }}</h2>
        <div class="row">
            <div class="cart-div-main col-lg-8 mb-4 mb-lg-0">
                @foreach ($cart_items as $item)
                    <div id="cart-{{ $item->id }}" class="row align-items-center cart-row">
                        <div class="col-md-4 my-4 mb-2">
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
                                    <small class="d-block"> {{ __('Size') }} : {{ $item->attributes->size_name }}</small>
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
                            <form id="cartForm{{ $item->id }}" action="">
                                <div class="border d-flex align-items-center justify-content-between px-3"><span
                                        class="small text-uppercase text-gray headings-font-family">{{ __('Quantity') }}</span>
                                    <div class="quantity">
                                        <span
                                            onclick="decreaseQuantity('{{ $item->id }}', 'http\://{{ request()->httpHost() }}/cart-decrease-quantity')"
                                            class="decrease p-0">
                                            <i
                                                class="px-2 fas fa-caret-{{ $lang === 'ar' ? 'right' : 'left' }}"></i></span>
                                        <input readonly name="quantity" id="quantity-{{ $item->id }}"
                                            class="form-control form-control-sm border-0 shadow-0 p-0 bg-white"
                                            type="text" value="{{ $item->quantity }}" />
                                        <span
                                            onclick="increaseQuantity('{{ $item->id }}', 'http\://{{ request()->httpHost() }}/cart-increase-quantity')"
                                            class="increase p-0"><i
                                                class="px-2 fas fa-caret-{{ $lang === 'ar' ? 'left' : 'right' }}"></i></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1 mb-2">
                            <a href="javascript:void(0)" class="reset-anchor"
                                onclick="removeFromCart('{{ $item->id }}', 'http\://{{ request()->httpHost() }}/remove-from-cart')">
                                <i class="fas fa-trash-alt small text-muted"></i>
                            </a>
                        </div>
                        <hr style="margin: 0%">
                    </div>
                @endforeach
            </div>
            <!-- ORDER TOTAL-->
            <div class="col-lg-4">
                <div class="card border-0 rounded-0 p-lg-4 bg-light">
                    <div class="card-body">
                        <h5 class="text-uppercase mb-4">{{ __('Cart total') }}</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-center justify-content-between">
                                <strong class="text-uppercase small font-weight-bold">
                                    {{ __('Subtotal') }}
                                </strong>
                                <span id="cart-subtotal" class="text-muted small">
                                    {{ getCurrency() . number_format(\Cart::session('cart')->getSubTotal(), 2) }}
                                </span>
                            </li>
                            <li class="border-bottom my-2"></li>
                            <li class="d-flex align-items-center justify-content-between mb-4">
                                <strong class="text-uppercase small font-weight-bold">
                                    {{ __('Total') }}
                                </strong>
                                <span id="cart-total">
                                    {{ getCurrency() . number_format(\Cart::session('cart')->getTotal(), 2) }}
                                </span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="bg-light px-4 py-3">
                    <div class="row align-items-center text-center">
                        <div class="col-md-6 mb-3 mb-md-0 text-md-start"><a class="btn btn-link p-0 text-dark btn-sm"
                                href="{{ strpos(url()->previous(), 'shopping') ? url()->previous() : route('customer.shopping') }}"><i
                                    class="fas fa-long-arrow-alt-left me-2">
                                </i>{{ __('Continue shopping') }}</a></div>
                        <div class="col-md-6 text-md-end"><a class="btn btn-outline-dark btn-sm"
                                href="{{ route('customer.checkout') }}">{{ __('Checkout') }}<i
                                    class="fas fa-long-arrow-alt-right ms-2"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
