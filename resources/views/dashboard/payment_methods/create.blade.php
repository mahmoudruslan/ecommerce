@extends('dashboard.layout.master')

@section('title')
    {{ __('Add payment methods') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Add payment methods') }}</h1>
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Add') }}</h1>
                                            </div>
                                            <form action="{{ route('admin.payment-methods.store') }}" method="POST"
                                                enctype="multipart/form-data" class="user">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="name" value="{{ old('name') }}"
                                                            class="form-control form-control-user @error('name') is-invalid @enderror"
                                                            placeholder=" {{ __('Name') }}">
                                                        @error('name')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="code" value="{{ old('code') }}"
                                                            class="form-control form-control-user @error('code') is-invalid @enderror"
                                                            placeholder=" {{ __('Enter Code') }}">
                                                        @error('code')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="driver_name"
                                                                value="{{ old('driver_name') }}"
                                                                class="form-control form-control-user @error('driver_name') is-invalid @enderror"
                                                                placeholder=" {{ __('Enter driver_name') }}">
                                                            @error('driver_name')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="merchant_email"
                                                                value="{{ old('merchant_email') }}"
                                                                class="form-control form-control-user @error('merchant_email') is-invalid @enderror"
                                                                placeholder=" {{ __('Enter merchant_email') }}">
                                                            @error('merchant_email')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="username"
                                                                value="{{ old('username') }}"
                                                                class="form-control form-control-user @error('username') is-invalid @enderror"
                                                                placeholder=" {{ __('Enter username') }}">
                                                            @error('username')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="secret"
                                                                value="{{ old('secret') }}"
                                                                class="form-control form-control-user @error('secret') is-invalid @enderror"
                                                                placeholder=" {{ __('Enter secret') }}">
                                                            @error('secret')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="sandbox_username"
                                                                value="{{ old('sandbox_username') }}"
                                                                class="form-control form-control-user @error('sandbox_username') is-invalid @enderror"
                                                                placeholder=" {{ __('Enter sandbox_username') }}">
                                                            @error('sandbox_username')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="sandbox_secret"
                                                                value="{{ old('sandbox_secret') }}"
                                                                class="form-control form-control-user @error('sandbox_secret') is-invalid @enderror"
                                                                placeholder=" {{ __('Enter sandbox_secret') }}">
                                                            @error('sandbox_secret')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="checkbox" value="1" name="sandbox"
                                                                    class="checkbox @error('sandbox') is-invalid @enderror"
                                                                    placeholder=" {{ __('Sandbox') }}">
                                                                <label><small>{{ __('Sandbox') }}</small></label>
                                                                @error('sandbox')
                                                                    <span class="text-danger" role="alert">
                                                                        <small>{{ $message }}</small>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="checkbox" value="1" name="status"
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
        <!-- Outer Row -->
    @endsection

