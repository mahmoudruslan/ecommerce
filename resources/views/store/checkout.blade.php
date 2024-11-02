@extends('store.layout.master')
@section('content')
    @php
        $lang = app()->getLocale();
        $coupon_count = Cart::session('cart')->getConditionsByType('sale')->count();
        $customer = auth()->user();

        $customer_addresses = $customer ? auth()->user()->addresses : null;
        $default_address = $customer ? $customer->defaultAddress : [];
        $default_address_count = count($default_address);

    @endphp
@section('style')
    <style>
        .hidden {
            display: none !important;
        }

        #expand-container {
            overflow: hidden;
        }

        #expand-contract {
            margin-top: 0;
            transition: all 0.25s;
            text-align: center;

        }

        #expand-contract.expanded {
            margin-top: -100%;
            text-align: center;
            /* transition: all 1s; */

        }

        .card-background {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .card-head {
            padding: 0.5rem 1rem;
            margin-bottom: 0;

            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
    </style>
@endsection
<!-- HERO SECTION-->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">{{ __('Checkout') }}</h1>
            </div>
            <div class="col-lg-6 text-lg-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                        <li class="breadcrumb-item"><a class="text-dark"
                                href="{{ route('store') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a class="text-dark"
                                href="{{ route('cart') }}">{{ __('Cart') }}</a></li>

                        <li class="breadcrumb-item active" aria-current="page">{{ __('Checkout') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="py-5">

    <div class="row">
        <div class="col-md-8">
            <div class="row gy-1">
                <!-- BILLING ADDRESS-->
                <h2 class="h5 text-uppercase">{{ __('Delivery') }}</h2>
                {{-- <form action="#"> --}}
                @if (\Auth::check() && count($customer_addresses) > 0)
                    {{-- <div class="row gy-3"> --}}
                    <div style="position: relative;" class="dropdown-toggle2" data-bs-toggle="collapse"
                        data-bs-target="#alternateAddress3">
                        {{ $customer->email }}...
                    </div>
                    <div class="collapse row gy-3" id="alternateAddress3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-dark">{{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                    <hr>
                    <div id="displayed-address" style="position: relative;" class="dropdown-toggle2"
                        data-bs-toggle="collapse" data-bs-target="#alternateAddress2">
                        {{ $default_address_count > 0 ? $default_address->first()->address : $customer_addresses[0]['address'] }}...
                    </div>
                    <hr>

                    <div class="collapse" id="alternateAddress2">
                        <div class="row gy-3" id="alternateAddress2x">
                            @foreach ($customer_addresses as $address)
                                <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordion"
                                    class="col-lg-6 collapse show">
                                    <input onclick="chooseAddress({{ $address }})"
                                        {{ $address->default_address == true ? 'checked' : '' }}
                                        class="form-check-input" type="radio" name="address"
                                        id="address-{{ $address->id }}">
                                    <label class="form-label text-sm text-uppercase"
                                        for="address-{{ $address->id }}">{{ $address->address }}</label>
                                </div>
                            @endforeach


                        </div>
                        <a class="btn-sm d-block text-center" href="#add-address" data-bs-toggle="modal">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                            <small>{{ __('Use different address.') }}</small>
                        </a>
                        @include('store.layout.add_address')
                    </div>
                @else
                    <x-store.add-address-form :governorates="$governorates"></x-add-address-form>
                @endif
                <br>
                <h2 class="h5 text-uppercase mb-4">{{ __('Shipping method') }}</h2>
                <div style="border-color: black;margin-left: 0;margin-right: 0" class="row alert bg-light">
                    <div class="col-md-10">
                        <span>{{ __('Home delivery') }}</span>
                    </div>
                    <div class="col-md-2">
                        <span
                            class="shippingCost">{{ $default_address_count > 0 ? $default_address->first()->governorate->cost : '' }}</span>
                    </div>
                </div>

                <h2 class="h5 text-uppercase mb-0">{{ __('Payment') }}</h2>
                <small>{{ __('All transactions are secure and encrypted.') }}</small>
                <br>
                <br>
                <div id="accordion">
                    <div id="pay-via-credit"
                        style="border-bottom: 0px; border-radius: 0.25rem 0.25rem 0px 0px;border-color: black"
                        class="card">
                        <div class="card-head">
                            <div class="row">
                                <div class="col-md-1 d-flex">
                                    <input onclick="openCollapse()" name="payment" class="form-check-input"
                                        type="radio">
                                </div>
                                <div class="col-md-11">
                                    <span>{{ __('Pay via (Debit/Credit cards/Wallets/Installments)') }}</span>
                                </div>
                            </div>
                        </div>

                        <div id="expand-container">
                            <div id="expand-contract" class="expanded card-body">
                                <img style="max-width: 100px" src="{{ asset('store/img/share.png') }}"
                                    alt=""><br>
                                <small>{{ __('After clicking “Pay now”, you will be redirected to Pay via (Debit/Credit cards/Wallets/Installments) to complete your purchase securely.') }}</small>
                            </div>
                        </div>
                    </div>
                    <div style="border-radius: 0px 0px 0.25rem 0.25rem;border-color: black" class="card">
                        <div class="card-head card-background" id="cash-on-delivery">
                            <div class="row">
                                <div class="col-md-1 d-flex">
                                    <input checked onclick="closeCollapse()" name="payment" class="form-check-input"
                                        type="radio">
                                </div>
                                <div class="col-md-11">
                                    <span>{{ __('Cash on Delivery (COD)') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-lg-12 form-group">
                    <button class="btn btn-dark" type="submit">{{ __('Place order') }}</button>
                </div>
            </div>
        </div>
        <!-- ORDER SUMMARY-->
        <div class="col-md-4">
            <div class="card border-0 rounded-0 p-lg-4 bg-light">
                <div class="card-body">
                    <h5 class="text-uppercase mb-2">{{ __('Order Summary') }}</h5>
                    <ul class="list-unstyled mb-0">
                        {{-- @foreach ($cart as $item)
                            <li class="d-flex align-items-center justify-content-between">
                                <strong class="small fw-bold">{{ $item->associatedModel['name_' . $lang] }}</strong>
                                <span class="text-muted small">{{ $item->associatedModel->price }}</span>
                            </li>
                            <li class="border-bottom my-2"></li>
                            <br>
                        @endforeach --}}
                        <li class="d-flex align-items-center justify-content-between mb-2">
                            <strong class="text-uppercase small fw-bold">{{ __('Subtotal') }}</strong>
                            <span id="cart-subtotal">{{ $sub_total }}</span>
                        </li>
                        <li id="shipping-li"
                            class="{{ $default_address_count > 0 ? '' : 'hidden' }} d-flex align-items-center justify-content-between mb-2">
                            <strong class="text-uppercase small fw-bold">{{ __('Shipping') }}</strong>
                            <span class="shippingCost"
                                id="shipping-value">{{ $default_address_count > 0 ? $default_address->first()->governorate->cost : '--' }}</span>
                        </li>
                        <li id="coupon-li"
                            class="{{ !$coupon_count > 0 ? 'hidden' : '' }} d-flex align-items-center justify-content-between mb-2">
                            <strong class="text-uppercase small fw-bold">{{ __('Discount') }}</strong>
                            <span id="coupon-value">{{ \Cart::session('cart')->getConditionsByType('sale')->sum('parsedRawValue')}}</span>
                        </li>
                        <hr>
                        <li class="d-flex align-items-center justify-content-between mb-2">
                            <strong class="text-uppercase small fw-bold">{{ __('Total') }}</strong>
                            <span id="cart-total">{{ $total }}</span>
                        </li>
                        <li>
                            <form action="" id="coupon-form">
                                <div class="input-group mb-0">
                                    <div id="apply-coupon-div"
                                        class="{{ $coupon_count > 0 ? 'hidden' : '' }} input-group mb-0">
                                        <input id="coupon_code" name="coupon_code" class="form-control"
                                            type="text" placeholder="{{ __('Enter your coupon') }}">
                                        <input name="total" type="hidden" value="{{ $total }}">
                                        <span onclick="applyCoupon('{{ route('apply.coupon') }}')"
                                            class="btn btn-dark btn-sm w-100 ">
                                            <i class="fas fa-gift me-2"></i>
                                            {{ __('Apply coupon') }}
                                        </span>
                                    </div>
                                    <span id="remove-coupon-btn"
                                        onclick="removeCoupon('{{ route('remove.coupon') }}')"
                                        class="{{ !$coupon_count > 0 ? 'hidden' : '' }} btn btn-danger btn-sm w-100 input-group mb-0">
                                        <i class="fas fa-gift me-2"></i>
                                        {{ __('Remove coupon') }}
                                    </span>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
