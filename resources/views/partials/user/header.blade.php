        <!--template navbar-->
        <header class="header bg-white">
            <div class="container px-lg-3">
                <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0">
                    <a class="navbar-brand" href="{{ route('index') }}">
                        <span class="fw-bold text-uppercase text-dark">{{ config('app.name') }}</span>
                    </a>
                    <button class="navbar-toggler navbar-toggler-end" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <!-- Link--><a class="nav-link active" href="index.html">Home</a>
                            </li>
                            <li class="nav-item">
                                <!-- Link--><a class="nav-link" href="shop.html">Shop</a>
                            </li>
                            <li class="nav-item">
                                <!-- Link--><a class="nav-link" href="detail.html">Product detail</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="pagesDropdown" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                                <div class="dropdown-menu mt-3 shadow-sm" aria-labelledby="pagesDropdown">
                                    <a class="dropdown-item border-0 transition-link"
                                        href="{{ route('index') }}">Homepage</a>
                                    <a class="dropdown-item border-0 transition-link"
                                        href="{{ route('user.shop') }}">Category</a>
                                    <a class="dropdown-item border-0 transition-link"
                                        href="{{ route('user.detail') }}">Product
                                        detail</a>
                                    <a class="dropdown-item border-0 transition-link"
                                        href="{{ route('user.cart') }}">Shopping cart</a>
                                    <a class="dropdown-item border-0 transition-link"
                                        href="{{ route('user.checkout') }}">Checkout</a>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.cart') }}">
                                    <i class="fas fa-dolly-flatbed me-1 text-gray"></i>Cart<small
                                        class="text-gray fw-normal">(2)</small>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#!">
                                    <i class="far fa-heart me-1">
                                    </i><small class="text-gray fw-normal"> (0)</small>
                                </a>
                            </li>
                            @guest
                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">
                                        <i class="fas fa-user me-1 text-gray fw-normal"></i>Login</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">
                                        <i class="fas fa-user me-1 text-gray fw-normal"></i>Register</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="pagesDropdown" href="#"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <img src="{{ asset(File::exists('frontend/img/' . auth()->user()->user_image)
                                                ? 'frontend/img/' . auth()->user()->user_image
                                                : 'frontend/img/default.webp',
                                        ) }}"
                                            style="width: 30px;height: 30px;margin-right: 5px; border-radius: 50%;">
                                        {{ auth()->user()->full_name }}
                                    </a>
                                    <div class="dropdown-menu mt-3 shadow-sm" aria-labelledby="pagesDropdown">

                                        <a class="dropdown-item border-0 transition-link" href="javascript:void(0)">My
                                            Profil
                                        </a>
                                        <a href="javascript:void();" class="dropdown-item border-0 transition-link"
                                            onclick="event.preventDefault;document.getElementById('logout-form').submit();">Logout
                                        </a>
                                        <form action="{{ route('logout') }}" method="POST" id="logout-form"
                                            class="d-none">
                                            @csrf
                                        </form>


                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
