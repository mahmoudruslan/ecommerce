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



                <h2 class="h5 text-uppercase">{{ __('Orders') }}</h2>

                @foreach ($orders as $order)
                <a href="{{route('customer.order.details', $order->id)}}" class="nav-link text-muted">
                    <div id="order-{{ $order->id }}" class="row align-items-center my-4 order-row">
                        <div class="col-md-2 mb-2">
                            <p class="mb-0 small">{{ $order->ref_id }}</p>
                        </div>
                        <div class="col-md-2 mb-2">
                            <p class="mb-0 small">{{ getCurrency() . number_format($order->total, 2)}}</p>
                        </div>
                        <div class="col-md-1 mb-2">
                            <p class="mb-0 small">{{ $order->payment_method }}</p>
                        </div>
                        <div class="col-md-1 mb-2">
                            <p class="mb-0 small">{!! $order->statusWithHtml() !!}</p>
                        </div>
                        <div class="col-md-2 mb-2">
                            <p class="mb-0 small">{{ $order->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div class="col-md-1 mb-2">
                            <p class="mb-0 small">
                                {{ $order->transactions()->orderByDesc('id')->first()->payment_result ?? '--' }}
                            </p>
                        </div>
                        <div class="col-md-1 mb-2">
                            <p class="mb-0 small">
                                {{ $order->transactions()->orderByDesc('id')->first()->transaction_number ?? '--' }}
                            </p>
                        </div>

                    </div>
                </a>
                @if ($order->transactions()->orderByDesc('id')->first()->transaction == app\Models\OrderTransaction::FINISHED &&
                $order->transactions()->orderByDesc('id')->first()->created_at->diffInDays(now()) <
                    Config::get('app.order_return_days'))
            <div class="row">
                <a href="{{ route('customer.orders.refund.request', $order->id) }}" class="mb-0 small">
                    <ins>{{ __('You can return order in') . ' ' . $order->transactions()->orderByDesc('id')->first()->created_at->diffInDays(now()) - Config::get('app.order_return_days') . ' ' . __('Days') }}
                    </ins>
                </a>
            </div>
        @endif
                    <hr style="margin: 0%">
                @endforeach












                <!-- CART TABLE-->
                {{-- <div class="table-responsive mb-4">
                    <table class="table text-nowrap text-center">

                        <tbody style="position: relative" class="t-body" class="border-0">
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="p-3 align-middle border-light">
                                        <p class="mb-0 small">{{ $order->ref_id }}</p>
                                    </td>
                                    <td class="p-3 align-middle border-light">
                                        <p class="mb-0 small">{{ $order->total }}</p>
                                    </td>
                                    <td class="p-3 align-middle border-light">
                                        <p class="mb-0 small">{{ $order->payment_method }}</p>
                                    </td>
                                    <td class="p-3 align-middle border-light">
                                        <p class="mb-0 small">{!! $order->statusWithHtml() !!}</p>
                                    </td>
                                    <td class="p-3 align-middle border-light">
                                        <p class="mb-0 small">{{ $order->created_at->format('Y-m-d') }}</p>
                                    </td>
                                    <td class="p-3 align-middle border-light">
                                        <a href="#" class="nav-link" onclick="showOrderDetails({{ $order->id }})">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr id="orderDetails{{ $order->id }}" class="hidden order-details border-hidden">
                                    <td colspan="6">
                                        <div style="left: 11%;right: 11%;"
                                            class="table-responsive mb-4 position-absolute bg-white border rounded shadow p-1">
                                            @include('store.parts.order_products_table')
                                            @include('store.parts.order_transactions_table')
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="4" class="text-center ps-0 py-6 border-light" scope="row">
                                        {{ __('Not found products') }}
                                    </th>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> --}}






















                <div class="bg-light px-4 py-3">
                    <div class="row align-items-center text-center">
                        <div class="col-md-6 mb-3 mb-md-0 text-md-start"><a class="btn btn-link p-0 text-dark btn-sm"
                                href="{{ route('customer.shopping') }}"><i class="fas fa-long-arrow-alt-left me-2">
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
