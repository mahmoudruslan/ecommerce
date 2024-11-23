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
            <div class="col-lg-8 mb-4 mb-lg-0">
                <!-- CART TABLE-->
                <div class="table-responsive mb-4">
                    <table class="table text-nowrap">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 p-3" scope="col"> <strong
                                        class="text-sm text-uppercase">{{ __('Product') }}</strong></th>
                                <th class="border-0 p-3" scope="col"> <strong
                                        class="text-sm text-uppercase">{{ __('Price') }}</strong></th>
                                <th class="border-0 p-3" scope="col"> <strong
                                        class="text-sm text-uppercase">{{ __('Quantity') }}</strong></th>
                                <th class="border-0 p-3" scope="col"> <strong
                                        class="text-sm text-uppercase">{{ __('Total') }}</strong></th>
                                <th class="border-0 p-3" scope="col"> <strong class="text-sm text-uppercase"></strong>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="t-body" class="border-0">
                            @forelse ($cart_items as $item)
                                <tr id="cart-{{ $item->associatedModel->id }}" class="cart-row">
                                    <th class="ps-0 py-3 border-light" scope="row">
                                        <div class="d-flex align-items-center">
                                            <a class="reset-anchor d-block animsition-link"
                                                href="{{ route('customer.product.detail', $item->associatedModel->slug) }}">
                                                <img src="{{ asset('storage/' . $item->associatedModel->firstMedia->file_name) }}"
                                                    alt="..." width="70" />
                                            </a>
                                            <div class="ms-3"><strong class="h6">
                                                    <a class="reset-anchor animsition-link" href="{{ route('customer.product.detail', $item->associatedModel->slug) }}">
                                                        {{ $item->associatedModel['name_' . $lang] }}
                                                    </a>
                                                </strong>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="p-3 align-middle border-light">
                                        <p id="price-{{$item->id}}" class="mb-0 small">{{ $item->price }}</p>
                                    </td>
                                    <td class="p-3 align-middle border-light">
                                        <form id="cartForm{{ $item->id }}" action="">
                                            <div class="border d-flex align-items-center justify-content-between px-3"><span
                                                    class="small text-uppercase text-gray headings-font-family">{{ __('Quantity') }}</span>
                                                <div class="quantity">
                                                    <span onclick="cartDecreaseQuantity({{ $item->id }}, 'http\://{{ request()->httpHost() }}/cart-decrease-quantity')" class="decrease p-0">
                                                        <i class="fas fa-caret-{{app()->getLocale() === 'ar' ? 'right' : 'left'}}"></i></span>
                                                    <input name="quantity" id="quantity-{{ $item->id }}"
                                                        class="form-control form-control-sm border-0 shadow-0 p-0"
                                                        type="text" value="{{ $item->quantity }}" />
                                                    <span onclick="cartIncreaseQuantity({{ $item->id }}, 'http\://{{ request()->httpHost() }}/cart-increase-quantity')"
                                                        class="increase p-0"><i class="fas fa-caret-{{app()->getLocale() === 'ar' ? 'left' : 'right'}}"></i></span>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="p-3 align-middle border-light">
                                        <p id="total-quantity-{{$item->id}}" class="mb-0 small">{{ $item->quantity * $item->price }}</p>
                                    </td>
                                    <td class="p-3 align-middle border-light">
                                        <a href="javascript:void(0)" class="reset-anchor"
                                            onclick="removeFromCart({{ $item->id }}, 'http\://{{ request()->httpHost() }}/remove-from-cart')">
                                            <i class="fas fa-trash-alt small text-muted"></i>
                                        </a>
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
                </div>
                <!-- CART NAV-->
                <div class="bg-light px-4 py-3">
                    <div class="row align-items-center text-center">
                        <div class="col-md-6 mb-3 mb-md-0 text-md-start"><a class="btn btn-link p-0 text-dark btn-sm"
                                href="{{  strpos(url()->previous(), 'shopping') ? url()->previous() : route('customer.shopping') }}"><i class="fas fa-long-arrow-alt-left me-2">
                                </i>{{ __('Continue shopping') }}</a></div>
                        <div class="col-md-6 text-md-end"><a class="btn btn-outline-dark btn-sm"
                                href="{{ route('customer.checkout') }}">{{ __('Checkout') }}<i
                                    class="fas fa-long-arrow-alt-right ms-2"></i></a></div>
                    </div>
                </div>
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
                                    {{ \Cart::session('cart')->getSubTotal() }}
                                </span>
                            </li>
                            <li class="border-bottom my-2"></li>
                            <li class="d-flex align-items-center justify-content-between mb-4">
                                <strong class="text-uppercase small font-weight-bold">
                                    {{ __('Total') }}
                                </strong>
                                <span id="cart-total">
                                    {{ \Cart::session('cart')->getTotal() }}
                                </span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        let maxQuantityMessage = "{{ __('This is the available quantity of the product.') }}";
        let success = "{{ __('Success') }}";
        let noProducts = "{{ __('Not found products') }}";
    </script>
@endsection
