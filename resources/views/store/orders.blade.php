@extends('store.layout.master')
@section('style')
    <style>
        .border-hidden {
            border: hidden;
        }
    </style>
@endsection
@section('content')
    <!-- HERO SECTION-->
    @php
        $lang = app()->getLocale();
    @endphp
    <section class="py-5 bg-light">
        <div class="container m-auto">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 mb-0">{{ __('Orders') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                            <li class="breadcrumb-item"><a class="text-dark"
                                    href="{{ route('customer.store') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Orders') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 text-center">
        <div class="row text-center">
            <div class="col-lg-12 mb-4 mb-lg-0">
                <div class="row g-3">
                    @foreach ($orders as $order)
                        <div class="col-md-4 col-sm-6">
                            <div class="order-card completed">
                                <a style="    color: #212529;" href="{{ route('customer.order.details', $order->id) }}">
                                    <h3>{{ __('Order') }} {{ $order->ref_id }}</h3>
                                    <p>{{ __('Subtotal') }}: {{ getCurrency() . number_format($order->sub_total, 2) }}</p>
                                    <p>{{ __('Shipping') }}: {{ getCurrency() . number_format($order->shipping, 2) }}</p>
                                    <p>{{ __('Total') }}: {{ getCurrency() . number_format($order->total, 2) }}</p>
                                    <p>{{ __('Payment method') }}: {{ $order->payment_method }}</p>
                                    <p>{{ __('Status') }}: {!! $order->statusWithHtml() !!}</p>
                                    <p>{{ __('Created at') }}: {{ $order->created_at->format('Y-m-d') }}</p>
                                   @if ($order->payment_result != null)
                                   <p>{{ __('Payment result') }}:
                                    {{ $order->transactions()->orderByDesc('id')->first()->payment_result ?? '--' }}
                                </p>
                                   @endif
                                </a>
                                <p>
                                    <a href="#buyAgain{{ $order->id }}"
                                        data-bs-toggle="modal" class="mb-0 small btn btn-sm btn-outline-primary">
                                        {{ __('Buy again') }}
                                    </a>
                                </p>
                                @include('store.modals.order_buy_again')
                                @if (
                                    $order->transactions()->orderByDesc('id')->first()->transaction == app\Models\OrderTransaction::FINISHED ||
                                        ($order->transactions()->orderByDesc('id')->first()->transaction ==
                                            app\Models\OrderTransaction::PAYMENT_COMPLETED &&
                                            $order->transactions()->orderByDesc('id')->first()->created_at->diffInDays(now()) <
                                                Config::get('app.order_return_days')))
                                    <p>
                                        <a href="{{ route('customer.orders.refund.request', $order->id) }}"
                                            class="mb-0 small btn
                                            btn-sm btn-outline-primary">
                                            {{ __('You can return order in') . ' ' . $order->created_at->diffInDays(now()) - Config::get('app.order_return_days') . ' ' . __('Days') }}
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                        <hr class="m-0 mobile-devices">
                    @endforeach
                </div>
                <div class="bg-light px-4 py-3">
                    <div class="row align-items-center text-center">
                        <div class="col-md-6 mb-3 mb-md-0 text-md-start"><a class="btn btn-link p-0 text-dark btn-sm"
                                href="{{ route('customer.shopping') }}"><i class="fas fa-long-arrow-alt-left me-2">
                                </i>{{ __('Continue shopping') }}</a></div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
