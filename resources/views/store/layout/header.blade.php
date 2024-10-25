    <!-- navbar-->
    <header class="header bg-white">
        <div class="container px-lg-3 m-auto">
            <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand" href="index.html"><span
                        class="fw-bold text-uppercase text-dark">{{ __(config('app.name')) }}</span></a>
                <button class="navbar-toggler navbar-toggler-end" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <!-- Link--><a class="nav-link active" href="{{ route('store') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <!-- Link--><a class="nav-link" href="{{ route('shopping') }}">{{ __('Shop') }}</a>
                        </li>
                        {{-- <li class="nav-item">
                            <!-- Link--><a class="nav-link" href="{{ route('detail') }}">{{ __('Product detail') }}</a>
                        </li> --}}
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="pagesDropdown"
                                href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">{{ __('Pages') }}</a>
                            <div class="dropdown-menu mt-3 shadow-sm" aria-labelledby="pagesDropdown">
                                <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('store') }}">{{ __('Homepage') }}</a>
                                <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('shopping') }}">{{ __('Category') }}</a>
                                {{-- <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('detail') }}">{{ __('Product detail') }}</a> --}}
                                <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('cart') }}">{{ __('Shopping cart') }}</a>
                                <a class="dropdown-item border-0 transition-link"
                                    href="{{ route('checkout') }}">{{ __('Checkout') }}</a>
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
                            <a class="nav-link" href="{{ route('cart') }}">
                                <i class="fas fa-dolly-flatbed me-1 text-gray"></i>
                                {{-- {{ __('Cart') }} --}}
                                <small id="cart-count"
                                    class="text-gray fw-normal">({{ \Cart::session('cart')->getContent()->count() }})</small>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('wishlist') }}">
                                <i class="far fa-heart me-1"></i>
                                <small id="wishlist-count"
                                    class="text-gray fw-normal">({{ \Cart::session('wishList')->getContent()->count() }})</small>
                            </a>
                        </li>

                        @if (auth()->check())
                            <li class="nav-item dropdown">
                                <a style="display : inline-block;" class="nav-link" id="pagesDropdown" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ auth()->user()->full_name }}
                                </a>
                                <img style="max-width : 26px;border-radius : 50%"
                                    src="{{ asset('store/img/product-1.jpg') }}" class="me-1 text-gray fw-normal">
                                <div class="dropdown-menu mt-3 shadow-sm" aria-labelledby="pagesDropdown">
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
