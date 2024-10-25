@extends('store.layout.master')
@section('content')
    @php
        $lang = app()->getLocale();
        $coupon_count = Cart::session('cart')->getConditionsByType('sale')->count();
    @endphp
@section('style')
    <style>
        .hidden {
            display: none !important;
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
    <!-- BILLING ADDRESS-->
    <h2 class="h5 text-uppercase mb-4">Billing details</h2>
    <div class="row">
        <div class="col-lg-8">
            <form action="#">
                <div class="row gy-3">
                    <div class="col-lg-6">
                        <label class="form-label text-sm text-uppercase" for="firstName">{{ __('First name') }} </label>
                        <input class="form-control form-control-lg" type="text" id="firstName"
                            placeholder="{{ __('Enter your first name') }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label text-sm text-uppercase" for="lastName">{{ __('Last name') }} </label>
                        <input class="form-control form-control-lg" type="text" id="lastName"
                            placeholder="{{ __('Enter your last name') }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label text-sm text-uppercase" for="email">{{ __('Email address') }}
                        </label>
                        <input class="form-control form-control-lg" type="email" id="email"
                            placeholder="e.g. Jason@example.com">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label text-sm text-uppercase" for="phone">{{ __('Phone number') }}
                        </label>
                        <input class="form-control form-control-lg" type="tel" id="phone"
                            placeholder="e.g. +02 245354745">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label text-sm text-uppercase" for="company">{{ __('Company name') }}
                            ({{ __('optional') }}) </label>
                        <input class="form-control form-control-lg" type="text" id="company"
                            placeholder="{{ __('Your company name') }}">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="form-label text-sm text-uppercase" for="country">{{ __('Country') }}</label>
                        <select class="form-control form-control-lg country" id="country"
                            data-customclass="form-control form-control-lg rounded-0">
                            <option value>{{ __('Choose your country') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label text-sm text-uppercase" for="address">{{ __('Address line 1') }}
                        </label>
                        <input class="form-control form-control-lg" type="text" id="address"
                            placeholder="{{ __('House number and street name') }}">
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label text-sm text-uppercase" for="addressalt">{{ __('Address line 2') }}
                        </label>
                        <input class="form-control form-control-lg" type="text" id="addressalt"
                            placeholder="{{ __('Apartment, Suite, Unit, etc (optional)') }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label text-sm text-uppercase" for="city">{{ __('Town/City') }} </label>
                        <input class="form-control form-control-lg" type="text" id="city">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label text-sm text-uppercase" for="state">{{ __('State/County') }}
                        </label>
                        <input class="form-control form-control-lg" type="text" id="state">
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-link text-dark p-0 shadow-0" type="button" data-bs-toggle="collapse"
                            data-bs-target="#alternateAddress">
                            <div class="form-check">
                                <input class="form-check-input" id="alternateAddressCheckbox" type="checkbox">
                                <label class="form-check-label"
                                    for="alternateAddressCheckbox">{{ __('Alternate billing address') }}</label>
                            </div>
                        </button>
                    </div>
                    <div class="collapse" id="alternateAddress">
                        <div class="row gy-3">
                            <div class="col-12 mt-4">
                                <h2 class="h4 text-uppercase mb-4">{{ __('Alternative billing details') }}</h2>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase"
                                    for="firstName2">{{ __('First name') }} </label>
                                <input class="form-control form-control-lg" type="text" id="firstName2"
                                    placeholder="{{ __('Enter your first name') }}">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase"
                                    for="lastName2">{{ __('Last name') }} </label>
                                <input class="form-control form-control-lg" type="text" id="lastName2"
                                    placeholder="{{ __('Enter your last name') }}">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase"
                                    for="email2">{{ __('Email address') }} </label>
                                <input class="form-control form-control-lg" type="email" id="email2"
                                    placeholder="e.g. Jason@example.com">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase"
                                    for="phone2">{{ __('Phone number') }} </label>
                                <input class="form-control form-control-lg" type="tel" id="phone2"
                                    placeholder="e.g. +02 245354745">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase"
                                    for="company2">{{ __('Company name') }} ({{ __('optional') }}) </label>
                                <input class="form-control form-control-lg" type="text" id="company2"
                                    placeholder="{{ __('Your company name') }}">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form-label text-sm text-uppercase"
                                    for="countryAlt">{{ __('Country') }}</label>
                                <select class="country" id="countryAlt"
                                    data-customclass="form-control form-control-lg rounded-0">
                                    <option value>Choose your country</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label text-sm text-uppercase"
                                    for="address2">{{ __('Address line 1') }} </label>
                                <input class="form-control form-control-lg" type="text" id="address2"
                                    placeholder="{{ __('House number and street name') }}">
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label text-sm text-uppercase"
                                    for="addressalt2">{{ __('Address line 2') }} </label>
                                <input class="form-control form-control-lg" type="text" id="addressalt2"
                                    placeholder="{{ __('Apartment, Suite, Unit, etc (optional)') }}">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase" for="city2">{{ __('Town/City') }}
                                </label>
                                <input class="form-control form-control-lg" type="text" id="city2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase"
                                    for="state2">{{ __('State/County') }} </label>
                                <input class="form-control form-control-lg" type="text" id="state2">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group">
                        <button class="btn btn-dark" type="submit">{{ __('Place order') }}</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- ORDER SUMMARY-->
        <div class="col-lg-4">
            <div class="card border-0 rounded-0 p-lg-4 bg-light">
                <div class="card-body">
                    <h5 class="text-uppercase mb-4">{{ __('Order Summary') }}</h5>
                    <ul class="list-unstyled mb-0">
                        {{-- @foreach ($cart as $item)
                            <li class="d-flex align-items-center justify-content-between">
                                <strong class="small fw-bold">{{ $item->associatedModel['name_' . $lang] }}</strong>
                                <span class="text-muted small">{{ $item->associatedModel->price }}</span>
                            </li>
                            <li class="border-bottom my-2"></li>
                            <br>
                        @endforeach --}}
                        <li class="d-flex align-items-center justify-content-between">
                            <strong class="text-uppercase small fw-bold">{{ __('Subtotal') }}</strong>
                            <span id="cart-subtotal">{{ $sub_total }}</span>
                        </li>
                        <br>

                        <li id="coupon-value" class="{{ !$coupon_count > 0 ? 'hidden' : '' }} d-flex align-items-center justify-content-between">
                            <strong class="text-uppercase small fw-bold">{{ __('Discount') }}</strong>
                            <span id="cart-subtotal">{{ $sub_total - $total }}</span>
                        </li>
                        <br>
                        <li class="d-flex align-items-center justify-content-between">
                            <strong class="text-uppercase small fw-bold">{{ __('Total') }}</strong>
                            <span id="cart-total">{{ $total }}</span>
                        </li>
                        <br>
                        <li>
                            <form action="" id="coupon-form">
                                <div class="input-group mb-0">
                                    <div id="apply-coupon-div"
                                        class="{{ $coupon_count > 0 ? 'hidden' : '' }} input-group mb-0">
                                        <input id="coupon_code" name="coupon_code" class="form-control"
                                            type="text" placeholder="{{ __('Enter your coupon') }}">
                                        <input name="total" type="hidden" value="{{ $total }}">
                                        <span onclick="applyCoupon('{{ route('apply.coupon') }}')"
                                            class="btn btn-dark btn-sm w-100">
                                            <i class="fas fa-gift me-2"></i>
                                            {{ __('Apply coupon') }}
                                        </span>
                                    </div>
                                    <span id="remove-coupon-btn"
                                        onclick="removeCoupon('{{ route('remove.coupon') }}')"
                                        class="{{ !$coupon_count > 0 ? 'hidden' : '' }} btn btn-danger btn-sm w-100">
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
{{-- @section('script')
<script>
    cartEmptyMessage = "{{ __('No products available in your cart.') }}";
</script>
@endsection --}}
