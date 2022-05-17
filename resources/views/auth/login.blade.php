@extends('layouts.user.master')
@section('title')
Login
@endsection
@section('content')
    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6"></div>
                    <h1 class="h2 text-uppercase mb-0">Login</h1>
                </div>
                <div class="col-lg-6 text-lg-end"></div>
            </div>
        </div>
    </section>

    <section class="py-5">
            <div class="offset-3">
                <h2 class="h5 text-uppercase mb-4">Login</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="row col-8">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="username" class="text-small text-uppercase mb-2">{{ __('User Name') }}</label>
                                <input id="username" type="text"
                                    class="form-control form-control-lg mb-2 @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="password" class="text-small text-uppercase mb-2">{{ __('Password') }}</label>

                                <input id="password" type="password"
                                    class="form-control mb-2 @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6 form-group">
                                <input class="custom-control-input mb-2" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="custom-control-lable text-small mb-2" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">{{ __('Login') }}</button>


                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif

                                @if (Route::has('register'))
                                    <a class="btn btn-secondary" style="float: right" href="{{ route('register') }}">
                                        {{ __("Have't an account") }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </section>
@endsection
