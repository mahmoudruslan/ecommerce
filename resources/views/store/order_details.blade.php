@extends('store.layout.master')

@section('content')
    <!-- HERO SECTION-->
    @php
        $lang = app()->getLocale();
    @endphp
    <section class="py-5 bg-light mb-4">
        <div class="container m-auto">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 mb-0">{{ __('Order details') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                            <li class="breadcrumb-item"><a class="text-dark"
                                    href="{{ route('customer.store') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item"><a class="text-dark"
                                    href="{{ route('customer.orders') }}">{{ __('Orders') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Order details') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="py-2 text-center">
        <h2 class="h5 text-uppercase">{{ __('Order products') }}</h2>
        <hr style="margin: 0%">

        <div class="row mb-4 text-center">
            <div class="col-lg-12 mb-4 mb-lg-0">
                @foreach ($order->products as $product)
                    <a href="{{ route('customer.order.details', $product->id) }}" class="text-muted">
                        <div class="row align-items-center my-1 order-row">
                            <div class="col-md-2 my-2">
                                <a class="d-inline-block reset-anchor  animsition-link" href="product/{{ $product->slug }}">
                                    <img src="http://{{ request()->httpHost() }}/storage/{{ $product->firstMedia->file_name }}"
                                        alt="..." width="80" />
                                </a>
                            </div>
                            <div class="col-md-2 my-2">
                                <p class="mb-0 small">
                                    {{ $product['name_' . $lang] }}
                                </p>
                            </div>
                            <div class="col-md-2 my-2">
                                <p class="mb-0 small">
                                    {{ getCurrency() . number_format($product->pivot->price, 2) }}</p>
                            </div>
                            <div class="col-md-3 my-2">
                                <label>{{ __('Quantity') }}</label> : <p class="mb-0 small d-inline-block">
                                    {{ $product->pivot->quantity }}</p>
                            </div>
                            <div class="col-md-3 my-2">
                                <label>{{ __('Total') }}</label> : <p class="mb-0 small d-inline-block">
                                    {{ getCurrency() . number_format($product->pivot->quantity * $product->price, 2) }}
                                </p>
                            </div>

                        </div>
                    </a>
                    <hr style="margin: 0%">
                @endforeach
            </div>
        </div>

    </section>
    <section class="py-2 text-center">
        <h2 class="h5 text-uppercase">{{ __('Order address') }}</h2>
        <hr style="margin: 0%">

        <div class="row mb-4 text-center">
            <div class="col-lg-12 mb-4 mb-lg-0">

                <div class="row align-items-center my-4 order-row">
                    <div class="col-md-1 my-2">
                        <p class="mb-0 small">
                            {{ $order->address->governorate['name_' . $lang] }}</p>
                    </div>
                    <div class="col-md-1 my-2">
                        <p class="mb-0 small">
                            {{ $order->address->city['name_' . $lang] }}</p>
                    </div>
                    <div class="col-md-2 my-2">
                        <p class="mb-0 small">
                            {{ $order->address->fullName }}</p>
                    </div>
                    <div class="col-md-2 my-2">
                        <p class="mb-0 small">
                            {{ $order->address->email }}</p>
                    </div>
                    <div class="col-md-2 my-2">
                        <p class="mb-0 small">
                            {{ $order->address->mobile }}</p>
                    </div>
                    <div class="col-md-2 my-2">
                        <p class="mb-0 small">
                            {{ $order->address->address }}</p>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
