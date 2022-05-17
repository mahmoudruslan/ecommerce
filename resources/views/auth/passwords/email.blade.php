@extends('layouts.user.master')
@section('title')
    Reset Password
@endsection
@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6"></div>
                <h1 class="h2 text-uppercase mb-0">{{ __('Reset Password') }}</h1>
            </div>
            <div class="col-lg-6 text-lg-end"></div>
        </div>
        </div>
    </section>
    <section class="py-5">
        <div class="offset-4">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="col-12 mb-3">
                    <div class="form-group">
                        <label for="email" class="text-small text-uppercase mb-2">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email"
                                class="form-control 
                    @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection
