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

        <div class="row mb-4 text-center">
            <div class="col-lg-5 mb-4 mb-lg-0 m-auto">
                @foreach ($order->products as $product)
                    <a href="{{ route('customer.product.detail', $product->slug) }}" class="text-muted">
                        <div class="row align-items-center my-1">
                            <div class="col-md-2 my-1">
                                <div class="position-relative d-inline-block">
                                    <img src="http://{{ request()->httpHost() }}/storage/{{ $product->firstMedia->file_name }}"
                                        alt="..." width="80" />
                                    <span class="small top-item">{{ $product->pivot->quantity }}</span>
                                </div>
                            </div>
                            <div class="col-md-5 my-1">
                                <p class="mb-0 small">
                                    {{ $product['name_' . $lang] }}
                                </p>
                                <small class="d-block"> {{ __('Size') }} : {{ $product->orderProductSize->first()->name }}</small>
                            </div>
                            <div class="col-md-5 my-1">
                                <p class="mb-0 small">
                                    {{ getCurrency() . number_format($product->pivot->price, 2) }}</p>
                            </div>
                            <hr>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </section>
    <section class="py-2 text-center">
        {{-- <h2 class="h5 text-uppercase">{{ __('Order address') }}</h2> --}}
        <div class="col-md-3 my-3 m-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title d-inline-block">{{ $order->address->fullName }}</h5>
                    @if ($order->address->default_address == 1)
                        <span><small class="text-muted bold mx-1">default</small></span>
                    @endif
                    <p class="card-text">{{ $order->address->address }}</p>
                    <p class="card-text">{{ $order->address->governorate['name_' . $lang] }}</p>
                    <p class="card-text">{{ $order->address->city['name_' . $lang] }}</p>
                    <h5 class="card-title">{{__('Contact information')}}</h5>
                    <p class="card-text">{{ $order->address->email }}</p>
                    <p class="card-text">{{ $order->address->mobile }}</p>
                    <h5 class="card-title">{{__('Shipping method')}}</h5>
                    <p class="card-text">{{__('Home delivery')}}</p>
                </div>
            </div>
        </div>
@endsection
