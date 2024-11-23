    <!-- navbar-->
    <header class="header bg-white">
        @php
            $lang = app()->getLocale();
        @endphp

        <div class="offcanvas offcanvas-{{ app()->getLocale() == 'en' ? 'end' : 'start' }}" tabindex="-1"
            id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{ __('Cart') }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">

                @foreach (\Cart::session('cart')->getContent()->sort() as $item)
                    <div class="row align-items-center my-4">
                        <div class="col-md-4">
                            <a class="reset-anchor d-block animsition-link"
                                href="{{ route('customer.product.detail', $item->associatedModel->slug) }}">
                                <img src="{{ asset('storage/' . $item->associatedModel->firstMedia->file_name) }}"
                                    alt="..." width="80" />
                            </a>
                        </div>
                        <div class="col-md-7">
                            <h6>
                                <strong class="reset-anchor animsition-link">
                                    {{ $item->associatedModel['name_' . $lang] }}
                                </strong>
                            </h6>
                            <p class="text-muted">
                                <small>{{ $item->price }}</small>
                            </p>
                            <form id="cartForm{{ $item->id }}" action="">
                                <div class="w-75 border d-flex align-items-center justify-content-between px-3"><span
                                        class="small text-uppercase text-gray headings-font-family">{{ __('Quantity') }}</span>
                                    <div class="quantity">
                                        <span
                                            onclick="cartDecreaseQuantity({{ $item->id }}, 'http\://{{ request()->httpHost() }}/cart-decrease-quantity')"
                                            class="decrease p-0">
                                            <i
                                                class="fas fa-caret-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i></span>
                                        <input name="quantity" id="quantity-{{ $item->id }}"
                                            class="form-control form-control-sm border-0 shadow-0 p-0" type="text"
                                            value="{{ $item->quantity }}" />
                                        <span
                                            onclick="cartIncreaseQuantity({{ $item->id }}, 'http\://{{ request()->httpHost() }}/cart-increase-quantity')"
                                            class="increase p-0"><i
                                                class="fas fa-caret-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1">
                            <a href="javascript:void(0)" class="reset-anchor"
                                onclick="removeFromCart({{ $item->id }}, 'http\://{{ request()->httpHost() }}/remove-from-cart')">
                                <i class="fas fa-trash-alt small text-muted"></i>
                            </a>
                        </div>
                    </div>
                    <hr style="margin: 0%">
                @endforeach
            </div>
            <div class="position-fixed w-100 bottom-0 bg-dark shadow-top">
                <div class="row">
                    {{-- <div class="col-md-6">
                        <p class="text-muted small">
                            {{ __('Total') }}: {{ $item->price * $item->quantity }}
                        </p>
                    </div> --}}
                    <div class="col-md-6">
                        <p class="text-muted small">
                            {{ __('Subtotal') }}: {{ \Cart::session('cart')->getSubTotal() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container px-lg-3 m-auto">
            <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand"
                    href="index.html"><span
                        class="fw-bold text-uppercase text-dark">{{ __(config('app.name')) }}</span></a>
                <button class="navbar-toggler navbar-toggler-end" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <!-- Link--><a class="nav-link active"
                                href="{{ route('customer.store') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <!-- Link--><a class="nav-link"
                                href="{{ route('customer.shopping') }}">{{ __('Shop') }}</a>
                        </li>
                        {{-- <li class="nav-item">
                            <!-- Link--><a class="nav-link" href="{{ route('detail') }}">{{ __('Product detail') }}</a>
                        </li> --}}
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="pagesDropdown"
                                href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">{{ __('Pages') }}</a>
                            <div class="dropdown-menu mt-3 shadow-sm" aria-labelledby="pagesDropdown">
                                <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('customer.store') }}">{{ __('Homepage') }}</a>
                                <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('customer.shopping') }}">{{ __('Category') }}</a>
                                {{-- <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('detail') }}">{{ __('Product detail') }}</a> --}}
                                <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('customer.cart') }}">{{ __('Shopping cart') }}</a>
                                <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('customer.checkout') }}">{{ __('Checkout') }}</a>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="pagesDropdown"
                                href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">{{ __('Language') }}</a>
                            <div class="dropdown-menu mt-3 shadow-sm" aria-labelledby="pagesDropdown">
                                <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('setlang', 'ar') }}">{{ __('Arabic') }}</a>
                                <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('setlang', 'en') }}">{{ __('English') }}</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.cart') }}">
                                <i class="fas fa-dolly-flatbed text-gray"></i>
                                {{-- {{ __('Cart') }} --}}
                                <small id="cart-count"
                                    class="text-gray fw-normal">({{ \Cart::session('cart')->getContent()->count() }})</small>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.wishlist') }}">
                                <i class="far fa-heart"></i>
                                <small id="wishlist-count"
                                    class="text-gray fw-normal">({{ \Cart::session('wishList')->getContent()->count() }})</small>
                            </a>
                        </li>

                        @if (auth()->check())
                            <li class="nav-item dropdown">
                                <a style="display : inline-block;" class="nav-link" id="pagesDropdown"
                                    href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ auth()->user()->full_name }}
                                    <img style="width : 30px;height : 30px;border-radius : 50%"
                                        src="{{ asset('storage/' . auth()->user()->image) }}"
                                        class="me-1 text-gray fw-normal">
                                </a>
                                <div class="dropdown-menu mt-3 shadow-sm" aria-labelledby="pagesDropdown">
                                    <a class="dropdown-item border-0 transition-link"
                                        href="{{ route('customer.profile') }}">{{ __('Profile') }}</a>
                                    <a class="dropdown-item border-0 transition-link"
                                        href="{{ route('customer.addresses') }}">{{ __('Addresses') }}</a>
                                    <a class="dropdown-item border-0 transition-link"
                                        href="{{ route('customer.orders') }}">{{ __('Orders') }}</a>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item border-0 transition-link">{{ __('Logout') }}</button>
                                    </form>
                                </div>

                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-user me-1 text-gray fw-normal"></i>{{ __('Login') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </header>
