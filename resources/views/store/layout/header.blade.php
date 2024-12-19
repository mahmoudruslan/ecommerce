    <!-- navbar-->
    <header class="header bg-white">
        @php
            $lang = app()->getLocale();
            $current_url = url()->current();
        @endphp

        @include('store.parts.cart_sidebar')
        <div style="width:100%; height:70px;position: fixed;z-index:1030;top:0;" class=" bg-white">
            <nav class="container m-auto navbar navbar-expand-lg navbar-light py-3"><a class="navbar-brand" href="{{route('customer.store')}}"><span
                        class="fw-bold text-uppercase text-dark">{{ __(config('app.name')) }}</span></a>
                <button class="navbar-toggler navbar-toggler-end" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <!-- Link--><a class="nav-link {{Route::is('customer.store') ? 'active' : ''}}"
                                href="{{ route('customer.store') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <!-- Link--><a class="nav-link {{Route::is('customer.shopping') ? 'active' : ''}}"
                                href="{{ route('customer.shopping') }}">{{ __('Shop') }}</a>
                        </li>
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="pagesDropdown"
                            href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">{{ __('Language') }}</a>
                        <div class="dropdown-menu mt-3 shadow-sm" aria-labelledby="pagesDropdown">
                            <a class="dropdown-item border-0 transition-link"
                                href="{{ route('setlang', 'ar') }}">العربية</a>
                            <a class="dropdown-item border-0 transition-link"
                                href="{{ route('setlang', 'en') }}">English</a>
                        </div>
                    </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link {{Route::is('customer.cart') ? 'active' : ''}}" href="javascript:void(0)" onclick="openCartSidBar()">
                                <i class="fas fa-dolly-flatbed"></i>
                                {{-- {{ __('Cart') }} --}}
                                <small id="cart-count"
                                    class="text-gray fw-normal">({{ \Cart::session('cart')->getContent()->count() }})</small>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{Route::is('customer.wishlist') ? 'active' : ''}}" href="{{ route('customer.wishlist') }}">
                                <i class="far fa-heart"></i>
                                <small id="wishlist-count"
                                    class="text-gray fw-normal">({{ \Cart::session('wishList')->getContent()->count() }})</small>
                            </a>
                        </li>

                        @if (auth()->check())
                            <li class="nav-item dropdown">
                                <a style="display : inline-block;" class="nav-link" id="pagesDropdown" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <div class="container m-auto mt-5">
