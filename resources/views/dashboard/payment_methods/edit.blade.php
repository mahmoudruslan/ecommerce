@extends('dashboard.layout.master')

@section('title')
    {{ __('Edit payment methods') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Edit payment methods') }}</h1>
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit') }} :
                                                    {{ __($payment_method->name) }}</h1>
                                            </div>
                                            <form
                                                action="{{ route('admin.payment-methods.update', $payment_method->id) }}"
                                                method="POST" class="user" enctype="multipart/form-data">
                                                @csrf
                                                @method('patch')
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Name') }}</small></label>
                                                        <input type="text" name="name"
                                                            value="{{ $payment_method->name }}"
                                                            class="form-control form-control-user @error('name') is-invalid @enderror"
                                                            placeholder="    {{ __('Name') }}">
                                                        @error('name')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Code') }}</small></label>
                                                        <input type="text" name="code"
                                                            value="{{ $payment_method->code }}"
                                                            class="form-control form-control-user @error('code') is-invalid @enderror"
                                                            placeholder="    {{ __('Code') }}">
                                                        @error('code')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Driver name') }}</small></label>
                                                        <input type="text" name="driver_name"
                                                            value="{{ $payment_method->driver_name }}"
                                                            class="form-control form-control-user @error('driver_name') is-invalid @enderror"
                                                            placeholder="    {{ __('Driver name') }}">
                                                        @error('driver_name')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Merchant email') }}</small></label>
                                                        <input type="text" name="merchant_email"
                                                            value="{{ $payment_method->merchant_email }}"
                                                            class="form-control form-control-user @error('merchant_email') is-invalid @enderror"
                                                            placeholder="    {{ __('Merchant email') }}">
                                                        @error('merchant_email')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Username') }}</small></label>
                                                        <input type="text" name="username"
                                                            value="{{ $payment_method->username }}"
                                                            class="form-control form-control-user @error('username') is-invalid @enderror"
                                                            placeholder="    {{ __('Username') }}">
                                                        @error('username')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Secret') }}</small></label>
                                                        <input type="text" name="secret"
                                                            value="{{ $payment_method->secret }}"
                                                            class="form-control form-control-user @error('secret') is-invalid @enderror"
                                                            placeholder="    {{ __('Secret') }}">
                                                        @error('secret')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('sandbox username') }}</small></label>
                                                        <input type="text" name="sandbox_username"
                                                            value="{{ $payment_method->sandbox_username }}"
                                                            class="form-control form-control-user @error('sandbox_username') is-invalid @enderror"
                                                            placeholder="    {{ __('Sandbox username') }}">
                                                        @error('sandbox_username')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Sandbox secret') }}</small></label>
                                                        <input type="text" name="sandbox_secret"
                                                            value="{{ $payment_method->sandbox_secret }}"
                                                            class="form-control form-control-user @error('sandbox_secret') is-invalid @enderror"
                                                            placeholder="    {{ __('Enter Name In Arabic') }}">
                                                        @error('sandbox_secret')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <div class="col-md-3">
                                                                <input
                                                                    {{ $payment_method->sandbox == true ? 'checked' : '' }}
                                                                    type="checkbox" value="1" name="sandbox"
                                                                    class="checkbox @error('sandbox') is-invalid @enderror"
                                                                    placeholder="    {{ __('Sandbox') }}">
                                                                <label><small>{{ __('Sandbox') }}</small></label>
                                                                @error('sandbox')
                                                                    <span class="text-danger" role="alert">
                                                                        <small>{{ $message }}</small>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input
                                                                    {{ $payment_method->status == true ? 'checked' : '' }}
                                                                    type="checkbox" value="1" name="status"
                                                                    class="checkbox" placeholder="{{ __('Status') }}">
                                                                <label><small>{{ __('Active') }}</small></label>
                                                                @error('status')
                                                                    <span class="text-danger" role="alert">
                                                                        <small>{{ $message }}</small>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <hr>
                                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                                        {{ __('Save') }}
                                                    </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Outer Row -->
@endsection
